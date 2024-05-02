<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\WhatsappService;
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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'   => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $whatsapp = new WhatsappService();
        $response = $whatsapp->sendMessage($data['phone'], "Ini hanya pesan validasi nomor whatsapp");

        if ($response->getStatusCode() == 200) {
            $user =  User::create([
                'name'     => $data['name'],
                'phone'   => $data['phone'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $user->roles()->attach(5);

            return $user;
        } else if ($response->getStatusCode() == 400) {
            return redirect()->back()->with('error', 'Nomor Whatsapp tidak valid');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }
}
