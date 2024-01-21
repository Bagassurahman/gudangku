@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Input Data Produk</h1>
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
                            Input Data Produk
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
                        <form class="form-layout form-layout-1" method="POST" action="{{ route('admin.produk.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Nama Produk<span class="tx-danger">*</span></label>
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
                                <label class="form-control-label active">Foto Produk<span class="tx-danger">*</span></label>
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
                                <label class="form-control-label active">Pilih Bahan<span class="tx-danger">*</span></label>
                                {{-- select2 --}}
                                <select class="form-control select2" name="materials[]" id="materials" multiple>
                                    <option value="">Pilih Bahan</option>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                                @error('materials')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div id="takaran-form"></div>
                            <div class="form-group mg-b-10-force">Harga Normal<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('general_price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="general_price" value="{{ old('general_price') }}">
                                @error('general_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">Harga Member<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('member_price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="member_price" value="{{ old('member_price') }}">
                                @error('member_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">Harga Online<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('online_price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="online_price" value="{{ old('online_price') }}">
                                @error('online_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- row -->
                            <div class="form-layout-footer mt-3">
                                <button class="btn btn-custom-primary" type="submit">Simpan</button>
                                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                            <!-- form-layout-footer -->
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#materials').on('change', function() {
                var selectedMaterials = $(this).val();
                var html = '';
                if (selectedMaterials) {
                    @foreach ($materials as $material)
                        if ($.inArray("{{ $material->id }}", selectedMaterials) !== -1) {
                            html += '<div class="form-group">';
                            html +=
                                '<label for="takaran-{{ $material->id }}">Takaran {{ $material->name }} <span class="tx-danger">*</span></label>';
                            html +=
                                '<input type="text" name="takaran[{{ $material->id }}]" id="takaran-{{ $material->id }}" class="form-control" placeholder="Masukkan Takaran {{ $material->name }}">';
                            html +=
                                '<div class="form-text">Satuan Takaran: {{ $material->unit->outlet_unit ?? '' }}</div>'
                            html += '</div>';

                        }
                    @endforeach
                }
                $('#takaran-form').html(html);
            });
        });
    </script>
@endsection
