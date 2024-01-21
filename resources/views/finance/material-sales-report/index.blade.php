@extends('layouts.admin-new')
@section('title', 'Laporan Penjualan Bahan ')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Laporan Penjualan Bahan</h1>
            </div>

        </div>

        <div class="row row-xs clearfix">

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <form action="{{ route('finance.laporan-penjualan-bahan.index') }}" method="GET">
                    <div class="row align-items-center d-flex">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ $tanggal_mulai }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir"
                                    value="{{ $tanggal_akhir }}">
                            </div>
                        </div>
                        <div class="col-md-2">

                            <button type="submit" class="btn btn-primary w-100 mt-2">Filter</button>
                        </div>
                    </div>
                </form>



                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Data Laporan Penjualan Bahan
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
                        <table class="table stripe hover bordered datatable datatable-ProductSales">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Nama Bahan
                                    </th>
                                    <th>
                                        Quantity Dosis
                                    </th>
                                    <th>
                                        Harga Jual
                                    </th>
                                    <th>
                                        Total Penjualan
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $dose = 0;
                                @endphp
                                @foreach ($materialSales as $key => $material)
                                    <tr data-entry-id="{{ $material->id }}">
                                        @php
                                            $total_harga = $material->total_dose * $material->selling_price;
                                        @endphp
                                        <td>

                                        </td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $material->name }}
                                        </td>
                                        <td>
                                            {{ $material->total_dose ?? '0' }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($material->selling_price, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($total_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @php
                                        $total += $total_harga;
                                        $dose += $material->total_dose;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">Total</th>
                                    <th>{{ $dose }}</th>
                                    <th></th>
                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let table = $('.datatable-ProductSales:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                responsive: false // Menambahkan opsi responsive
            })

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        })
    </script>
@endsection
