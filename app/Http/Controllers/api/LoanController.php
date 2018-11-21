<?php

namespace App\Http\Controllers\api;

use App\InterestType;
use App\Loan;
use App\LoanType;
use App\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    ////list loan
    public function index(){
        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('manager')){
            $loans = Loan::with('loanType', 'approval', 'request', 'interestType')
                ->orderBy('loans.created_at', 'desc')
                ->get();
            return response()->json($loans);
        }else{
            $loans = Loan::with('loanType', 'approval', 'request', 'interestType')
                ->where('request_id', $user->id)
                ->orderBy('loans.created_at', 'desc')
                ->get();
            return response()->json($loans);
        }
    }

    ///create loan
    public function store(Request $request){

        $user = Auth::user();

        $validator = Validator::make($request->all(), Loan::rules());
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
        }

        ////check if user doesnt have other running loans
        $exist = Loan::where('request_id', $user->id)->where('status', '!=', 'SUCCESS')->first();
        if(!empty($exist)){
            return response()->json(['error' => 'bad-request', 'next' => 'please pay the previous loan'], 400);
        }


        $repayment_frequency = $request['repayment_frequency'] != "monthly" ? "annual"  : "monthly";

        $interest_type = InterestType::findOrFail($request['interest_type_id']);
        $loan_type = LoanType::findOrFail($request['loan_type_id']);
        $period = $request['period'];
        if($repayment_frequency == 'monthly') {
            $to_time = date('Y-m-d', strtotime("+".$period." months", strtotime($request['from_time'])));
        }else{
            $to_time =strtotime(date("Y-m-d", strtotime($request['from_time'])) . " +".$period." years");
            $to_time = date("Y-m-d",$to_time);

        }
        $request->merge(
            [
                'interest_type_id' => $interest_type->id,
                'loan_type_id' => $loan_type->id,
                'request_id' => $user->id,
                'repayment_frequency' => $repayment_frequency,
                'code'=> $this->generateUniqueCode(),
                'to_time' => $to_time
            ]);

        $loan = Loan::create($request->all());

        if($loan->request_id == $loan->request_id){

            ///check type of interest first
            $interest_type = InterestType::findOrFail($loan->interest_type_id);

            ////calculate interest
            if($interest_type->description == 'simple interest'){


                ///formula
                /// Interest= C x interest rate
                //new capital =capital + Interest

                $interest = (($loan->requested_amount * $loan->interest_rate ) / 100) * $loan->period;
                $total_amount_with_rate = $loan->requested_amount + $interest;
                Payment::create(
                    [
                        'name' => 'Payment for loan code:'. $loan->code,
                        'total_amount' => $total_amount_with_rate,
                        'payer_id' => $loan->request_id,
                        'loan_id' => $loan->id,
                        'status' => 'pending',
                        'deadline' => $loan->to_time,
                        'code' => $loan->code
                    ]
                );


            }else{
                ///compound interest
                ///formula: total_amount = requested_amount x (1 + interest_rate) power period

                $total_amount = $loan->requested_amount * ( 1 + $loan->interest_rate) ** $loan->period;

                Payment::create(
                    [
                        'name' => 'Payment for loan code:'. $loan->code,
                        'total_amount' => $total_amount,
                        'payer_id' => $loan->request_id,
                        'loan_id' => $loan->id,
                        'status' => 'pending',
                        'deadline' => $loan->to_time,
                        'code' => $loan->code
                    ]
                );

            }

        }else{
            return response()->json(['error' => 'bad-request'],400);
        }
        return response()->json($loan);
    }

    public function show($id){
        $loan = Loan::findOrFail($id);
        return response()->json($loan);
    }

    public function generateUniqueCode(){
        $random = time().mt_rand(0, 999) . mt_rand(0, 999);
        $exists = DB::table('payments')->where('code', $random)->first();
        if ($exists) {
            return $this->generateUniqueCode();
        }
        return $random;
    }
}
