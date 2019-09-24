<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'details', 'car_type_id', 'owner_id', 'status', 'manufacturer_year',
        'price', 'currency','approval_id'];
}
