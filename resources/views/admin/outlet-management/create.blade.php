@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Input Data Outlet</h1>
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
                            Input Data Outlet
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
                            action="{{ route('admin.manajemen-outlet.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Penangung Jawab<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                    type="text" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Nama Outlet<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('outlet_name')
                                            is-invalid
                                        @enderror"
                                    type="text" name="outlet_name" value="{{ old('outlet_name') }}">
                                @error('outlet_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Target<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('target')
                                            is-invalid
                                        @enderror"
                                    type="number" name="target" value="{{ old('target') }}">
                                @error('target')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Gudang Suplai<span
                                        class="tx-danger">*</span></label>
                                <select class="form-control select" name="warehouse_id">
                                    <option label="Pilih Gudang"></option>
                                    @foreach ($warehouse as $item)
                                        <option value="{{ $item->id }}">{{ $item->warehouse_name }}</option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Nomer Hp<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('phone_number')
                                            is-invalid
                                        @enderror"
                                    type="text" name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Alamat<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('address')
                                            is-invalid
                                        @enderror"
                                    type="text" name="address" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Email<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                    type="text" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Password<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('password')
                                            is-invalid
                                        @enderror"
                                    type="password" name="password" value="{{ old('password') }}">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- row -->
                            <div class="form-layout-footer mt-3">
                                <button class="btn btn-custom-primary" type="submit">Simpan</button>
                                <a href="{{ route('admin.manajemen-gudang.index') }}"
                                    class="btn btn-secondary">Cancel</a>
                            </div>
                            <!-- form-layout-footer -->
                        </form>
                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection
