<?php
/* created by pacoder */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    ///////create penalties if deadline passed
    protected $fillable = ['name', 'user_id', 'amount', 'frequency', 'currency', 'status', 'approval_id','loan_id'];
}
