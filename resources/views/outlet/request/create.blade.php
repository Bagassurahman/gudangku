@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Request Bahan</h1>
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
                            Request Bahan
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
                        <form class="form-layout form-layout-1" method="POST" action="{{ route('outlet.request.store') }}"
                            enctype="multipart/form-data">
                            @csrf
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

                            <!-- row -->
                            <div class="form-layout-footer mt-3">
                                <button class="btn btn-custom-primary" type="submit">Simpan</button>
                                <a href="{{ route('outlet.request.index') }}" class="btn btn-secondary">Cancel</a>
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
                                '<label for="qty-{{ $material->id }}">Qty {{ $material->name }} <span class="tx-danger">*</span></label>';
                            html +=
                                '<input type="text" name="qty[{{ $material->id }}]" id="qty-{{ $material->id }}" class="form-control" placeholder="Masukkan Qty {{ $material->name }}">';
                            html +=
                                '<div class="form-text">Satuan Takaran: {{ $material->unit->warehouse_unit ?? '' }}</div>'
                            html += '</div>';

                        }
                    @endforeach
                }
                $('#takaran-form').html(html);
            });
        });
    </script>
@endsection
