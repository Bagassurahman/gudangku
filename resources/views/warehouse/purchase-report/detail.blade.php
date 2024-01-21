@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Detail Pembelian {{ $purchase->po_number }}</h1>
            </div>
        </div>
        <div class="row row-xs clearfix">

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Detail Pembelian
                        </h4>
                        <div class="card-header-btn">
                            <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse1"
                                aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                            <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                                    class="ion-android-refresh"></i></a>
                            <a href="#" data-toggle="expand" class="btn card-expand"><i
                                    class="ion-android-expand"></i></a>
                            <a href="#" data-toggle="remove" class="btn card-remove"><i
                                    class="ion-android-close"></i></a>
                        </div>
                    </div>
                    <div class="card-body collapse show" id="collapse1">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            Tanggal Beli
                                        </th>
                                        <td>
                                            {{ $purchase->po_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Suplier
                                        </th>
                                        <td>
                                            {{ $purchase->supplier->name }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th colspan="2">
                                            Bahan Yang Di Beli
                                        </th>

                                    </tr>
                                    <tr>
                                        <th colspan="2">
                                            <ul class="list-group">
                                                @foreach ($purchase->purchaseOfMaterialsDetails as $detail)
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{ $detail->material->name }} / Harga: {{ $detail->price }} x
                                                        ({{ $detail->qty }})
                                                        = {{ $detail->price * $detail->qty }}
                                                    </li>
                                                @endforeach
                                            </ul>

                                        </th>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-layout-footer mt-3 d-flex">

                            <a href="{{ route('warehouse.laporan-pembelian.index') }}"
                                class="btn btn-secondary ml-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#btn-distribusi').click(function() {
                // Ambil nilai kuantitas yang diperbarui
                var qtyInputs = $('input[name="qty[]"]');
                qtyInputs.each(function(index, input) {
                    var newQty = $(input).val();
                    // Tambahkan nilai kuantitas ke formulir saat submit
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'updated_qty[]',
                        value: newQty
                    }).appendTo('#distribution_form');
                });
                // Submit formulir setelah menambahkan nilai kuantitas
                $('#distribution_form').submit();
            });
        });
    </script>
@endsection
