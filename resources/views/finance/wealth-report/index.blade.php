@extends('layouts.admin-new')
@section('title', 'Laporan Kekayaan Outlet')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Laporan Kekayaan Outlet</h1>
            </div>

        </div>

        <div class="row row-xs clearfix">

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                {{-- <form action="{{ route('finance.laporan-distribusi.index') }}" method="GET">
                    <div class="row align-items-center d-flex">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir">
                            </div>
                        </div>
                        <div class="col-md-2">

                            <button type="submit" class="btn btn-primary w-100 mt-2">Filter</button>
                        </div>
                    </div>
                </form> --}}
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Data Laporan Kekayaan Outlet
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
                        <table class="table stripe hover bordered datatable datatable-Role">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Outlet
                                    </th>
                                    <th>
                                        Tanggal
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Pembayaran
                                    </th>
                                    <th>
                                        Sisa Kekayaan
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riches as $riche)
                                    <tr>
                                        <th>

                                        </th>
                                        <th>
                                            {{ $loop->iteration }}
                                        </th>
                                        <th>
                                            {{ $riche->outlet->outlet_name }}
                                        </th>
                                        <th>
                                            {{ \Carbon\Carbon::createFromFormat('Y-m', $riche->date)->format('F Y') }}
                                        </th>
                                        <th>
                                            Rp {{ number_format($riche->total, 0, ',', '.') }}
                                        </th>
                                        <th>
                                            Rp {{ number_format($riche->debit, 0, ',', '.') }}
                                        </th>
                                        <th>
                                            Rp {{ number_format($riche->sub_total, 0, ',', '.') }}
                                        </th>
                                        <th>
                                            <a href="{{ route('finance.finance.laporan-kekayaan-outlet.showDetail', ['date' => $riche->date, 'id' => $riche->outlet_id]) }}"
                                                class="btn btn-primary">Detail</a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>

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

            let table = $('.datatable-Role:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                responsive: false // Menambahkan opsi responsive
            })

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        })
    </script>
@endsection
