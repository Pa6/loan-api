<?php

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
        'status', # status is pending the total amount to pay with rate is paid
        'deadline'
    ];
}
