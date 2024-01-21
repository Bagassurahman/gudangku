@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Input Data Reward</h1>
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
                            Input Data Reward
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
                        <form class="form-layout form-layout-1" method="POST" action="{{ route('admin.reward.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Nama Reward<span class="tx-danger">*</span></label>
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
                                <label class="form-control-label active">Point Reward<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('point')
                                            is-invalid
                                        @enderror"
                                    type="number" name="point" value="{{ old('point') }}">
                                @error('point')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Gambar<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('image')
                                            is-invalid
                                        @enderror"
                                    type="file" name="image" value="{{ old('image') }}">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Deskripsi Reward<span
                                        class="tx-danger">*</span></label>
                                <textarea
                                    class="form-control @error('description')
                                            is-invalid
                                        @enderror"
                                    type="text" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Stock Reward<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('stock')
                                            is-invalid
                                        @enderror"
                                    type="number" name="stock" value="{{ old('stock') }}">
                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- row -->
                            <div class="form-layout-footer mt-3">
                                <button class="btn btn-custom-primary" type="submit">Simpan</button>
                                <a href="{{ route('admin.reward.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                            <!-- form-layout-footer -->
                        </form>
                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection
