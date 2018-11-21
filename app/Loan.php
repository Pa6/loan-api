<?php
/* created by pacoder */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',  #details of loans , ..
        'requested_amount',
        'repayment_frequency', # monthly or annual
        'total_amount_with_rate',
        'currency',
        'collateral_data',  #
        'request_id', # user who request a loan
        'approval_id',  # admin who approval
        'status',
        'extra', # any extra data
        'loan_type_id',  # loan type
        'interest_rate',
        'from_time',
        'to_time',
        'interest_type_id',
        'period'
    ];

    #loan type relationship
    public function loanType(){
        return $this->belongsTo('App\LoanType');
    }

    #approval user relationship
    public function approval(){
        return $this->belongsTo('App\User', 'approval_id');
    }

    #request user relationship
    public function request(){
        return $this->belongsTo('App\User', 'request_id');
    }


    #interest type relationship
    public function interestType(){
        return $this->belongsTo('App\InterestType', 'interest_type_id');
    }

    ///validation rules
    public static function rules() {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'loan_type_id' => 'required|numeric',
            'requested_amount' => 'required|numeric',
            'repayment_frequency' => 'required', #monthly or annual
            'interest_type_id' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'from_time' => 'required|date_format:Y-m-d',
            'payment_type_id' => 'required|numeric',
            'period' => 'required|numeric'

        ];
        return $rules;
    }

}