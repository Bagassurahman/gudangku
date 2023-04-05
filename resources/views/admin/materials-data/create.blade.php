@extends('layouts.admin')
@section('content')
    <div class="main-card">
        <div class="header">
            Input Bahan
        </div>

        <form method="POST" action="{{ route('admin.data-bahan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <div class="mb-3">
                    <label for="name" class="text-xs required">Nama Bahan</label>
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="{{ $errors->has('name') ? ' ' : '' }}"
                            value="{{ old('name') }}" required>
                    </div>
                    @if ($errors->has('name'))
                        <p class="invalid-feedback">{{ $errors->first('name') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="unit_id" class="text-xs required">Satuan Bahan</label>
                    <div class="form-group">
                        <select name="unit_id" id="unit_id"
                            class="form-control select {{ $errors->has('unit_id') ? ' ' : '' }}" required>
                            <option value="" selected>Pilih
                                Satuan</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">
                                    {{ $unit->warehouse_unit }}/{{ $unit->outlet_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('unit_id'))
                        <p class="invalid-feedback">{{ $errors->first('unit_id') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="selling_price" class="text-xs required">Harga Jual</label>
                    <div class="form-group">
                        <input type="number" id="selling_price" name="selling_price"
                            class="{{ $errors->has('selling_price') ? ' ' : '' }}" value="{{ old('selling_price') }}"
                            required>
                    </div>
                    @if ($errors->has('selling_price'))
                        <p class="invalid-feedback">{{ $errors->first('selling_price') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="category" class="text-xs required">Kategori Bahan</label>
                    <div class="form-group">
                        <select name="category" id="category"
                            class="form-control select {{ $errors->has('category') ? ' ' : '' }}" required>
                            <option value="" selected>Pilih
                                Kategori</option>
                            <option value="Produk">
                                Produk
                            </option>
                            <option value="Non-Produk">
                                Non-Produk
                            </option>
                        </select>
                    </div>
                    @if ($errors->has('category'))
                        <p class="invalid-feedback">{{ $errors->first('category') }}</p>
                    @endif
                </div>
            </div>

            <div class="footer">
                <button type="submit" class="submit-button">Simpan</button>
            </div>
        </form>
    </div>
@endsection
