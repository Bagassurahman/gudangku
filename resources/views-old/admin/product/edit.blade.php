@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Edit Data Produk</h1>
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
                            Edit Data Produk
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
                            action="{{ route('admin.produk.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Nama Produk<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                    type="text" name="name" value="{{ old('name', $product->name) }}">
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
                            <div class="form-group">
                                <label for="materials">Pilih Bahan<span class="tx-danger">*</span></label>
                                <select class="form-control select2" id="materials" name="materials[]" multiple required>
                                    @foreach ($materials as $material)
                                        <option value="{{ $material->id }}"
                                            {{ in_array($material->id, old('materials', $product->details->pluck('material_id')->toArray())) ? 'selected' : '' }}>
                                            {{ $material->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="takaran-form">
                                @foreach ($product->details as $productDetail)
                                    <div class="form-group">
                                        <label for="takaran-{{ $productDetail->material_id }}">Takaran
                                            {{ $productDetail->material->name }} <span class="tx-danger">*</span></label>
                                        <input type="text" name="takaran[{{ $productDetail->material_id }}]"
                                            id="takaran-{{ $productDetail->material_id }}" class="form-control"
                                            value="{{ old('takaran.' . $productDetail->material_id, $productDetail->dose) }}"
                                            placeholder="Masukkan Takaran {{ $productDetail->material->name }}">
                                        <div class="form-text "><em>*Satuan Takaran:
                                                {{ $productDetail->material->unit->outlet_unit ?? '' }}</em></div>
                                    </div>
                                @endforeach
                            </div>


                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Harga Normal<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('general_price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="general_price"
                                    value="{{ old('general_price', $product->general_price) }}">
                                @error('general_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Harga Member<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('member_price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="member_price"
                                    value="{{ old('member_price', $product->member_price) }}">
                                @error('member_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Harga Online<span
                                        class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('online_price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="online_price"
                                    value="{{ old('online_price', $product->online_price) }}">
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
            var selectedMaterials = $('#materials').val();
            showTakaranFields(selectedMaterials);

            $('#materials').on('change', function() {
                var selectedMaterials = $(this).val();
                showTakaranFields(selectedMaterials);
            });

            function showTakaranFields(selectedMaterials) {
                var html = '';
                if (selectedMaterials) {
                    @foreach ($materials as $material)
                        if ($.inArray("{{ $material->id }}", selectedMaterials) !== -1) {
                            html += '<div class="form-group">';
                            html +=
                                '<label for="takaran-{{ $material->id }}">Takaran {{ $material->name }} <span class="tx-danger">*</span></label>';
                            html +=
                                '<input type="text" name="takaran[{{ $material->id }}]" id="takaran-{{ $material->id }}" class="form-control" placeholder="Masukkan Takaran {{ $material->name }}" value="{{ old('takaran.' . $material->id, $product->details->where('material_id', $material->id)->first()->dose ?? '') }}">';
                            html +=
                                '<div class="form-text "><em>*Satuan Takaran: {{ $material->unit->outlet_unit ?? '' }}</em></div>';
                            html += '</div>';
                        }
                    @endforeach
                }
                $('#takaran-form').html(html);
            }
        });
    </script>
@endsection
