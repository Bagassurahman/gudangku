@extends('layouts.admin-new')
@section('title', 'Laporan Setoran ' . $date)
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow"> Detail Laporan Setoran {{ $outlet }}
                    <br>
                    Tanggal:
                    {{ $date }}
                </h1>
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
                            Detail Laporan Setoran {{ $date }}
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
                                    <th width="10"></th>
                                    <th>No</th>
                                    <th>Kode Setoran</th>
                                    <th>Tanggal</th>
                                    <th>
                                        Omset
                                    </th>
                                    <th>
                                        SF & GF
                                    </th>
                                    <th>
                                        Shoppe Pay
                                    </th>
                                    <th>
                                        Jurnal Kas
                                    </th>
                                    <th>Total Setoran</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($deposits as $key => $deposit)
                                    <tr>
                                        <td></td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $deposit->deposit_number }}</td>
                                        <td>{{ $deposit->deposit_date }}</td>
                                        <td>Rp {{ number_format($deposit->omset, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($deposit->online, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($deposit->shoppe_pay, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($deposit->cash_journal, 0, ',', '.') }}</td>

                                        <td>Rp {{ number_format($deposit->amount, 0, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $deposit->status == 'pending' ? 'badge-warning' : 'badge-success' }}">{{ $deposit->status }}</span>
                                        </td>

                                    </tr>
                                    @php
                                        $total += $deposit->amount;
                                    @endphp
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="8" class="text-right">Total</th>
                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                    <th></th>
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
