<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarRequest extends Model
{
    protected $fillable = ['car_id', 'client_id', 'owner_id', 'from_date_time', 'to_date_time', 'status',
        'payment_type_id', 'initial_payment_amount', 'total_amount', 'currency', 'details'];
}
