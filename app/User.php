<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'birthday', 'photo', 'bio', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relashioinships
     */

    // has many incomes
    public function incomes()
    {
        return $this->hasMany('App\Income', 'user');
    }

    // has many incomes
    public function expenses()
    {
        return $this->hasMany('App\Expence', 'user');
    }

    /**
     * get the type of identifier (email, phone)
     */
    public function identifierType($identifier)
    {
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 
                    "email" : "phone"; // filter_var($logger, FILTER_VALIDATE_REGEXP, '/0[\d]{9}|\+?[\d]{12}|\+?\([\d]{3}\)[\d]{9}$/gm') ? 'phone' : 'username';

        return $field;
    }

    /**
     * register a user
     * 
     * @param array params
     * @return User use
     */
    public function register($params)
    {
        return User::create([
            'firstname' => $params['firstname'],
            'lastname' => $params['lastname'] ?? null,
            'email' => $params['email'],
            'phone' => $params['phone'] ?? null,
            'birthday' => $params['birthday'] ?? null,
            'photo' => $params['photo'] ?? null,
            'bio' => $params['bio'] ?? null,
            'password' => Hash::make($params['password']),
        ]);
    }

    /**
     * login a user
     * 
     * @param string params
     * @return User user
     */
    public function login($params)
    {
        // get the type of the field (email, phone)
        $field = $this->identifierType($params["identifier"]);

        $credentials = [
            $field => $params['identifier'],
            "password" => $params['password'],
        ];

        if(!Auth::attempt($credentials))
            return ["status" => false];

        // retrieve the logged user
        $user = Auth::user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if($params['remember_me']){
            $token->expires_at = Carbon::now()->addWeeks(4);
        }else{
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        // return array that holds token and status
        return [
            "access_token" => $tokenResult->accessToken,
            "expires_at" => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            "status" => true,
            "user" => Auth::user(),
        ];
    }

    /**
     * logout users
     * 
     * @param User
     * @return boolean
     */
    public function logout($user)
    {
        return $user->token()->revoke();
    }

}
