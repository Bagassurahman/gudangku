@extends('layouts.app')
@section('content')
    <div class="auth-card">
        <img src="{{ asset('images/logo-zamzam.jpeg') }}" alt="" class="max-w-none mx-auto mb-3" width="100">
        <div class="title">
            Daftar Zamzam Time
        </div>

        @if (session('message'))
            <div class="alert success">
                {{ session('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label class="block">
                <span class="text-gray-700 text-sm">Nama Lengkap</span>
                <input type="text" name="name" class="form-input {{ $errors->has('name') ? ' is-invalid' : '' }}"
                    value="{{ old('name') }}" autofocus required>
                @if ($errors->has('name'))
                    <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                @endif
            </label>
            <label class="block mt-3">
                <span class="text-gray-700 text-sm">Nomer Hp</span>
                <input type="text" name="phone" class="form-input {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                    value="{{ old('phone') }}" autofocus required>
                @if ($errors->has('phone'))
                    <p class="invalid-feedback">{{ $errors->first('phone') }}</p>
                @endif
            </label>
            <label class="block mt-3">
                <span class="text-gray-700 text-sm">{{ trans('global.login_email') }}</span>
                <input type="email" name="email" class="form-input {{ $errors->has('email') ? ' is-invalid' : '' }}"
                    value="{{ old('email') }}" autofocus required>
                @if ($errors->has('email'))
                    <p class="invalid-feedback">{{ $errors->first('email') }}</p>
                @endif
            </label>

            <label class="block mt-3">
                <span class="text-gray-700 text-sm">{{ trans('global.login_password') }}</span>
                <input type="password" name="password"
                    class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" required>
                @if ($errors->has('password'))
                    <p class="invalid-feedback">{{ $errors->first('password') }}</p>
                @endif
            </label>
            <label class="block mt-3">
                <span class="text-gray-700 text-sm">Konfirmasi Password</span>
                <input type="password" name="password_confirmation"
                    class="form-input{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" required>
                @if ($errors->has('password_confirmation'))
                    <p class="invalid-feedback">{{ $errors->first('password_confirmation') }}</p>
                @endif
            </label>

            <div class="flex justify-between items-center mt-4">
                <div>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="form-checkbox text-indigo-600">
                        <span class="mx-2 text-gray-600 text-sm">{{ trans('global.remember_me') }}</span>
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div>
                        <a class="link" href="{{ route('password.request') }}">{{ trans('global.forgot_password') }}</a>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="button">
                    Daftar
                </button>
            </div>

            <a class="link mt-3 text-center" href="{{ route('login') }}">Sudah Punya Akun? Login</a>

        </form>
    </div>
@endsection
