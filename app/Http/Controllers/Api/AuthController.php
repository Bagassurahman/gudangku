<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use App\Services\WhatsappService;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Generate token pakai Passport
            $tokenResult = $user->createToken('API Token');
            $token = $tokenResult->accessToken;
            $tokenExpiresAt = $tokenResult->token->expires_at;

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $tokenExpiresAt,
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    /**
     * Handle a logout request (API version, Passport).
     */
    public function logout(Request $request)
    {
        if ($request->user()) {
            // Revoke the token yang aktif
            $request->user()->token()->revoke();
        }

        Auth::logout();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'string', 'max:255', 'unique:users', 'regex:/^08[0-9]{8,}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'phone.regex' => 'Nomor Whatsapp tidak valid, contoh: 081234567890'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tambahkan default role jika perlu
        $user->roles()->attach(5); // opsional

        // Login user dan buat token
        $tokenResult = $user->createToken('API Token');
        $token = $tokenResult->accessToken;
        $tokenExpiresAt = $tokenResult->token->expires_at;

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $tokenExpiresAt,
        ], 201);
    }
    
    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }
}
