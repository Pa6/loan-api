<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverRequest extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $fillable = [ 'client_id', 'driver_id', 'from_date_time', 'to_date_time', 'status',
        'payment_type_id', 'initial_payment_amount', 'total_amount', 'currency', 'details'];
}
