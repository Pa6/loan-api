<?php
/* created by pacoder */
namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestType extends Model
{
    protected $table = 'interest_types';
    protected $fillable = ['name', 'description'];
}
