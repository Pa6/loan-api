<?php

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
        'to_time'
    ];
}