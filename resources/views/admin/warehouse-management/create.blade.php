@extends('layouts.admin')
@section('content')
    <div class="main-card">
        <div class="header">
            Tambah Manajemen
        </div>

        <form method="POST" action="{{ route('admin.manajemen-gudang.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <div class="mb-3">
                    <label for="warehouse_name" class="text-xs required">Nama Gudang</label>

                    <div class="form-group">
                        <input type="text" id="warehouse_name" name="warehouse_name"
                            class="{{ $errors->has('warehouse_name') ? ' is-invalid' : '' }}"
                            value="{{ old('warehouse_name') }}" required>
                    </div>
                    @if ($errors->has('warehouse_name'))
                        <p class="invalid-feedback">{{ $errors->first('warehouse_name') }}</p>
                    @endif

                </div>
                <div class="mb-3">
                    <label for="name" class="text-xs required">Penanggung Jawab</label>

                    <div class="form-group">
                        <input type="text" id="name" name="name"
                            class="{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" required>
                    </div>
                    @if ($errors->has('name'))
                        <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                    @endif
                    <span class="block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="mb-3">
                    <label for="phone" class="text-xs required">No Telp</label>

                    <div class="form-group">
                        <input type="number" id="phone" name="phone"
                            class="{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" required>
                    </div>
                    @if ($errors->has('phone'))
                        <p class="invalid-feedback">{{ $errors->first('phone') }}</p>
                    @endif

                </div>
                <div class="mb-3">
                    <label for="address" class="text-xs required">Alamat</label>

                    <div class="form-group">
                        <textarea
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500   {{ $errors->has('address') ? ' is-invalid' : '' }} "
                            name="address" id="address" required>{{ old('address') }}</textarea>
                    </div>
                    @if ($errors->has('address'))
                        <p class="invalid-feedback">{{ $errors->first('address') }}</p>
                    @endif

                </div>
                <div class="mb-3">
                    <label for="email" class="text-xs required">{{ trans('cruds.user.fields.email') }}</label>

                    <div class="form-group">
                        <input type="email" id="email" name="email"
                            class="{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" required>
                    </div>
                    @if ($errors->has('email'))
                        <p class="invalid-feedback">{{ $errors->first('email') }}</p>
                    @endif
                    <span class="block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="mb-3">
                    <label for="password" class="text-xs required">{{ trans('cruds.user.fields.password') }}</label>

                    <div class="form-group">
                        <input type="password" id="password" name="password"
                            class="{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password') }}">
                    </div>
                    @if ($errors->has('password'))
                        <p class="invalid-feedback">{{ $errors->first('password') }}</p>
                    @endif
                    <span class="block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>

            </div>

            <div class="footer">
                <button type="submit" class="submit-button">{{ trans('global.save') }}</button>
            </div>
        </form>
    </div>
@endsection
