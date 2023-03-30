@extends('layouts.admin')
@section('content')
    <div class="main-card">
        <div class="header">
            Input Supplier
        </div>

        <form method="POST" action="{{ route('warehouse.suppliers.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <div class="mb-3">
                    <label for="name" class="text-xs required">Nama Supplier</label>
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="{{ $errors->has('name') ? ' ' : '' }}"
                            value="{{ old('name') }}" required>
                    </div>
                    @if ($errors->has('name'))
                        <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="address" class="text-xs required">Alamat Supplier</label>
                    <div class="form-group">
                        <input type="text" id="address" name="address" class="{{ $errors->has('address') ? ' ' : '' }}"
                            value="{{ old('address') }}" required>
                    </div>
                    @if ($errors->has('address'))
                        <p class="invalid-feedback">{{ $errors->first('address') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="phone" class="text-xs required">Nomer Hp Supplier</label>
                    <div class="form-group">
                        <input type="number" id="phone" name="phone" class="{{ $errors->has('phone') ? ' ' : '' }}"
                            value="{{ old('phone') }}" required>
                    </div>
                    @if ($errors->has('phone'))
                        <p class="invalid-feedback">{{ $errors->first('phone') }}</p>
                    @endif
                </div>
            </div>

            <div class="footer">
                <button type="submit" class="submit-button">Simpan</button>
            </div>
        </form>
    </div>
@endsection
