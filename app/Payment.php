<?php
/* created by pacoder */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'code',
        'name',
        'total_amount',
        'payer_id',
        'receiver_id',
        'currency',
        'loan_id',
        'total_amount_paid',
        'status', # status is pending the total amount to pay with rate is paid
        'deadline'
    ];


    #receiver relationship to user
    public function receiver(){
        return $this->belongsTo('App\User', 'receiver_id');
    }

    #payer relationship to users table
    public function payer(){
        return $this->belongsTo('App\User', 'payer_id');
    }

    #loan relationship
    public function loan(){
        return $this->belongsTo('App\Loan', 'loan_id');
    }

    #pivot table
    public function loanPayment()
    {
        return $this->belongsToMany('App\Loan','loan_payments')
            ->withPivot('receiver_id', 'payer_id', 'payment_type_id', 'amount','payment_status','details','id')
            ->withTimestamps();
    }

    ///validation rules
    public static function rules() {
        $rules = [
            'amount' => 'required|numeric',
            'details' => 'required',
            'loan_id' => 'required|numeric',
            'payment_type_id' => 'required|numeric'
        ];
        return $rules;
    }
}
