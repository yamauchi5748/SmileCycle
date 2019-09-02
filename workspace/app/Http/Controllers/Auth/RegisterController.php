<?php

namespace App\Http\Controllers\Auth;

use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        //　画像をストレージに保存し、URLを生成
        //$this->middleware('profile_image_register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /*
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:64', 'unique:members'],
            'ruby' => ['required', 'string', 'max:128'],
            'post' => ['required', 'string', 'max:32'],
            'company_id' => ['required', 'uuid'],
            'department_name' => ['required', 'string'],
            'mail' => ['required', 'string', 'email', 'max:256', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        */
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:64', 'unique:members'],
            'email' => ['required', 'string', 'email', 'max:256', 'unique:members'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Member
     */
    protected function create(array $data)
    {
        /*
        return Member::create([
            'id' => (string) Str::uuid(),
            'api_token' => Str::random(60),
            'is_notification' => true,
            'notification_interval' => '0.5h',
            'is_admin' => false,
            'name' => $data['name'],
            'ruby' => $data['ruby'],
            'post' => $data['post'],
            'tel' => $data['tel'],
            'company_id' => $data['company_id'],
            'department_name' => $data['department_name'],
            'mail' => $data['mail'],
            'password' => Hash::make($data['password'])
        ]);
        */
        return Member::create([
            'id' => (string) Str::uuid(),
            'api_token' => Str::random(60),
            'is_notification' => true,
            'notification_interval' => '0.5h',
            'is_admin' => false,
            'name' => $data['name'],
            'ruby' => 'unti',
            'post' => 'post',
            'tel' => 'xxx-xxxx-xxxx',
            'company_id' => 'company_id',
            'department_name' => 'department_name',
            'mail' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }
}