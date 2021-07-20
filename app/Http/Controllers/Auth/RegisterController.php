<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public function register(Request $request)
    {
        // dd($request->all());


        $this->validator($request->all())->validate();
        $avatar = null;
        if ($request->hasFile('avatar')) {
            $img = $request->avatar;
            $filename = $img->getClientOriginalName();
            $avatar = Storage::putFileAs('/public/images', $request->file('avatar'), $filename);
        }

        $user = $this->create(array_merge($request->all(), ['avatar' => $avatar]));

        $token = $user->createToken('authToken')->accessToken;

        //login after register
        // $this->guard()->login($user);

        return response()->json([
            'success' => true,
            'message' => 'user registered successfully.',
            'token' => $token
        ], 200);
    }
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
            'avatar' => ['nullable'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'companyName' => ['nullable'],
            'mobile_no' => ['nullable', 'digits:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // dd($data);
        return User::create([
            'avatar' => $data['avatar'],
            'username' => $data['username'],
            'email' => $data['email'],
            'company_name' => $data['companyName'],
            'mobile_no' => $data['mobile_no'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
