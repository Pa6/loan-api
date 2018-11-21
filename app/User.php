<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends  Authenticatable implements JWTSubject
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
        // TODO: Implement getJWTIdentifier() method.
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
        // TODO: Implement getJWTCustomClaims() method.
    }

    public function withEmail($email)
    {
        return User::where('email',  $email);
    }


    ///validation rules
    public static function rules($user_id = 0) {
        $rules = [
            'name' => 'required',
            'role_id' => 'required|numeric',
            'email' => 'email|required|unique:users,email,' . $user_id,
            'password' =>'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|min:8',
        ];
        if ($user_id) {
            $rules['password'] = 'min:8|confirmed';
            $rules['password_confirmation'] = 'min:8';
        }
        return $rules;
    }
}
