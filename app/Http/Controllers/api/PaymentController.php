<?php

namespace App\Http\Controllers\api;

use App\InterestType;
use App\Loan;
use App\Payment;
use App\PaymentType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index(){
        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('manager')){
            $payment = Payment::with('loanPayment', 'loan', 'receiver','payer')
                ->orderBy('payments.created_at', 'desc')
                ->get();
            return response()->json($payment);
        }else{
            $payment = Payment::with('loanPayment', 'loan', 'receiver','payer')
                ->where('payer_id', $user->id)
                ->orderBy('payments.created_at', 'desc')
                ->get();
            return response()->json($payment);
        }
    }

    public function store(Request $request){

        $user = Auth::user();

        $validator = Validator::make($request->all(), Payment::rules());
        if ($validator->fails()) {
            return response()->json($validator->messages(),422);
        }

        $loan = Loan::findOrFail($request['loan_id']);
        $payment = Payment::where('loan_id',$loan->id)->first();
        $payment_type = PaymentType::findOrFail($request['payment_type_id']);

        if($payment->status == 'SUCCESS'){
            return response()->json(['message' => 'Loan already paid'],200);
        }

        if($user->id == $payment->payer_id){
            return response()->json(['error' => 'bad-request'], 400);
        }

        $payment->loanPayment()->attach($loan->id, [
            'receiver_id' => $user->id,
            'payer_id' => $payment->payer_id,
            'amount' => $request['amount'],
            'payment_status' => 'SUCCESS',
            'payment_type_id' => $payment_type->id,
            'details' => empty($request['details']) ? 'Payment for loan code: '.$loan->code : $request['details'],
        ]);

        $payment->total_amount_paid += $request['amount'];
        $payment->save();

        if($payment->total_amount_paid >= $payment->total_amount){
            $payment->status = 'SUCCESS';
            $payment->save();

            $loan->status = 'SUCCESS';
            $loan->save();
        }


        return response()->json($payment);

    }

    public function show($id){
        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('manager')){
            $payment =  Payment::with('loanPayment', 'loan','payer')
                                ->where('id', $id)
                                ->first();
            return response()->json($payment);
        }else{
            $payment =  Payment::with('loanPayment', 'loan','payer')
                                ->where('payer_id', $user->id)
                                ->where('id', $id)
                                ->first();
            return response()->json($payment);
        }
    }
}
