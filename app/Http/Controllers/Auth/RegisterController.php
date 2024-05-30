<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\WhatsappService;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'string', 'max:255', 'unique:users', 'regex:/^08[0-9]{8,}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'phone.regex' => 'Nomor Whatsapp tidak valid, contoh: 081234567890'
        ]);
    }


    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'phone'    => $data['phone'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $whatsapp = new WhatsappService();
        $response = $whatsapp->sendMessage(
            $request->input('phone'),
            "Selamat, Sobtime sudah terdaftar.\n\n" .
                "Berikut data dari Sobtime\n" .
                "Nama : " . $request->input('name') . "\n" .
                "No WhatsApp : " . $request->input('phone') . "\n" .
                "Email : " . $request->input('email') . "\n\n" .
                "Harap simpan data diatas. Untuk bisa login di Sobtime.com\n\n" .
                "Untuk melihat jumlah point dan hadiah yang bisa ditukar dengan point Sobtime.\n\n" .
                "Kumpulkan point dan tukarkan dengan hadiah yang Sobtime inginkan.\n\n" .
                "Sukses dan Sehat selalu\n\n" .
                "Jangan lupa ajak teman teman untuk daftar di sobtime.com"
        );

        if ($response->getStatusCode() == 200) {
            $user = $this->create($request->all());
            $user->roles()->attach(5);
            $this->guard()->login($user);
            return redirect($this->redirectPath());
        } else if ($response->getStatusCode() == 400) {
            return redirect()->back()->withInput()->withErrors(['phone' => 'Nomor Whatsapp tidak valid']);
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan, silahkan coba lagi']);
        }
    }
}
