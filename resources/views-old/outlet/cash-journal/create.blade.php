@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Tambah Jurnal Kas</h1>
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
                            Tambah Jurnal Kas
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
                            action="{{ route('outlet.jurnal-kas.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mg-b-10-force">
                                <label class="form-control-label active">Tanggal<span class="tx-danger">*</span></label>
                                <input
                                    class="form-control @error('date')
                                            is-invalid
                                        @enderror"
                                    type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" id="date">
                                @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div id="additional-costs-container">
                                <!-- Tempat untuk menambahkan biaya tambahan -->
                            </div>

                            <button type="button" class="btn btn-primary" onclick="addAdditionalCost()">Tambah
                                Biaya</button>



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
        var costs = {!! json_encode($costs) !!};


        function addAdditionalCost() {
            var container = document.getElementById('additional-costs-container');

            var additionalCost = document.createElement('div');
            additionalCost.className = 'form-group';

            var label = document.createElement('label');
            label.className = 'form-control-label';
            label.textContent = 'Biaya ' + (container.children.length + 1);

            var select = document.createElement('select');
            select.className = 'form-control select2';
            select.name = 'additional_costs[]';

            var option = document.createElement('option');
            option.value = '';
            option.text = 'Pilih Biaya';
            select.appendChild(option);

            // Tambahkan opsi biaya dari variabel costs
            costs.forEach(function(cost) {
                var option = document.createElement('option');
                option.value = cost.id;
                option.text = cost.name;
                select.appendChild(option);
            });

            var note = document.createElement('input');
            note.className = 'form-control mt-2';
            note.type = 'text';
            note.name = 'notes[]';
            note.placeholder = 'Catatan';

            var amount = document.createElement('input');
            amount.className = 'form-control mt-2';
            amount.type = 'number';
            amount.name = 'amounts[]';
            amount.placeholder = 'Jumlah Biaya';

            additionalCost.appendChild(label);
            additionalCost.appendChild(select);
            additionalCost.appendChild(note);
            additionalCost.appendChild(amount);

            container.appendChild(additionalCost);
        }
    </script>
@endsection
