<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanType extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'loan_types';
    protected $fillable = ['name', 'description'];
}
