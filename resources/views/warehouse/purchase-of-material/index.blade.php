@extends('layouts.admin')
@section('content')
    <div class="main-card">
        <div class="header">
            Pembelian
        </div>

        <form method="POST" action="{{ route('warehouse.pembelian-bahan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <div class="mb-3">
                    <label for="po_number" class="text-xs required">No Pembelian</label>
                    <div class="form-group">
                        <input type="text" id="po_number" name="po_number"
                            class="{{ $errors->has('po_number') ? ' ' : '' }}" value="{{ old('po_number') }}" required>
                    </div>
                    @if ($errors->has('po_number'))
                        <p class="invalid-feedback">{{ $errors->first('po_number') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="po_date" class="text-xs required">Tanggal Pembelian</label>
                    <div class="form-group">
                        <input type="date" id="po_date" name="po_date" class="{{ $errors->has('po_date') ? ' ' : '' }}"
                            value="{{ old('po_date') }}" required>
                    </div>
                    @if ($errors->has('po_date'))
                        <p class="invalid-feedback">{{ $errors->first('po_date') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="supplier_id" class="text-xs required">Supplier</label>
                    <div class="form-group">
                        <select name="supplier_id" id="supplier_id" class="form-control">
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($errors->has('supplier_id'))
                        <p class="invalid-feedback">{{ $errors->first('supplier_id') }}</p>
                    @endif
                </div>
            </div>

            <div class="footer">
                <button type="submit" class="submit-button">Selanjutnya</button>
            </div>
        </form>
    </div>
@endsection
