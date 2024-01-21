@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Input Data Satuan</h1>
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
                            Input Data Satuan
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
                            action="{{ route('admin.data-satuan.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Satuan Gudang<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('warehouse_unit')
                                            is-invalid
                                        @enderror"
                                    type="text" name="warehouse_unit" value="{{ old('warehouse_unit') }}">
                                @error('warehouse_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Satuan Outlet<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('outlet_unit')
                                            is-invalid
                                        @enderror"
                                    type="text" name="outlet_unit" value="{{ old('outlet_unit') }}">
                                @error('outlet_unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Nilai Konversi<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('value')
                                            is-invalid
                                        @enderror"
                                    type="text" name="value" value="{{ old('value') }}">
                                @error('value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- row -->
                            <div class="form-layout-footer mt-3">
                                <button class="btn btn-custom-primary" type="submit">Simpan</button>
                                <a href="{{ route('admin.data-satuan.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                            <!-- form-layout-footer -->
                        </form>
                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection
