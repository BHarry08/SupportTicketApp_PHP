<?php

namespace App\Http\Controllers\Auth;

use App\Agents;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'emails' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'Phone' => ['required', 'int', 'digits:10'],
            'City' => ['required', 'string', 'min:3'],
            'State' => ['required', 'string', 'min:3'],
            'Zip' => ['required', 'string', 'min:6', 'max:6'],
            'user_type' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data = [
            'name' => $data['name'],
            'emails' => $data['emails'],
            'password' => Hash::make($data['password']),
            'phone' => $data['Phone'],
            'city' => $data['City'],
            'state' => $data['State'],
            'zip' => $data['Zip'],
            'user_type' => $data['user_type'],
        ];
        if($data['user_type'] == "user"){
            return User::create($data);
        }else {
            return Agents::create($data);
        }

    }
}
