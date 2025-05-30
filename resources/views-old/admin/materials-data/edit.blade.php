@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Edit Data Bahan</h1>
            </div>

        </div>
        <div class="row row-xs clearfix">
            <!--================================-->
            <!-- Top Label Layout Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Edit Data Bahan
                        </h4>
                        <div class="card-header-btn">
                            <a href="" data-toggle="collapse" class="btn card-collapse" data-target="#collapse1"
                                aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                            <a href="" data-toggle="refresh" class="btn card-refresh"><i
                                    class="ion-android-refresh"></i></a>
                            <a href="" data-toggle="expand" class="btn card-expand"><i
                                    class="ion-android-expand"></i></a>
                            <a href="" data-toggle="remove" class="btn card-remove"><i
                                    class="ion-android-close"></i></a>
                        </div>
                    </div>
                    <div class="card-body collapse show" id="collapse1">
                        <form class="form-layout form-layout-1" method="POST"
                            action="{{ route('admin.data-bahan.update', $material->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Nama Bahan<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                    type="text" name="name" value="{{ $material->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Satuan Bahan<span
                                        class="tx-danger">*</span></label>
                                <select name="unit_id" class="form-control">
                                    <option value="" selected>Pilih Satuan</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ $material->unit_id == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->warehouse_unit }}/{{ $unit->outlet_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Harga Jual<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('selling_price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="selling_price" value="{{ $material->selling_price }}">
                                @error('selling_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Kategori Bahan<span
                                        class="tx-danger">*</span></label>
                                <select name="category" class="form-control">
                                    <option value="" selected>Pilih Kategori</option>
                                    <option value="Produk" {{ $material->category == 'Produk' ? 'selected' : '' }}>Produk
                                    </option>
                                    <option value="Bahan Baku" {{ $material->category == 'Non-Produk' ? 'selected' : '' }}>
                                        Non-Produk</option>
                                </select>
                            </div>
                            <!-- row -->
                            <div class="form-layout-footer mt-3">
                                <button class="btn btn-custom-primary" type="submit">Update</button>
                                <a href="{{ route('admin.data-bahan.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                            <!-- form-layout-footer -->
                        </form>
                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection
