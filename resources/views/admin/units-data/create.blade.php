@extends('layouts.admin')
@section('content')
    <div class="main-card">
        <div class="header">
            Input Satuan
        </div>

        <form method="POST" action="{{ route('admin.data-satuan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <div class="mb-3">
                    <label for="warehouse_unit" class="text-xs required">Satuan Gudang</label>
                    <div class="form-group">
                        <input type="text" id="warehouse_unit" name="warehouse_unit"
                            class="{{ $errors->has('warehouse_unit') ? ' ' : '' }}" value="{{ old('warehouse_unit') }}"
                            required>
                    </div>
                    @if ($errors->has('warehouse_unit'))
                        <p class="invalid-feedback">{{ $errors->first('warehouse_unit') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="outlet_unit" class="text-xs required">Satuan Outlet</label>
                    <div class="form-group">
                        <input type="text" id="outlet_unit" name="outlet_unit"
                            class="{{ $errors->has('outlet_unit') ? ' ' : '' }}" value="{{ old('outlet_unit') }}" required>
                    </div>
                    @if ($errors->has('outlet_unit'))
                        <p class="invalid-feedback">{{ $errors->first('outlet_unit') }}</p>
                    @endif
                </div>
            </div>

            <div class="footer">
                <button type="submit" class="submit-button">Simpan</button>
            </div>
        </form>
    </div>
@endsection
