@extends('layouts.admin-new')
@section('title', 'Laporan Jurnal Kas ' . $date)
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow"> Detail Laporan Jurnal Kas {{ $date }}</h1>
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
                            Detail Laporan Jurnal Kas {{ $date }}
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
                                        Nama Outlet
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($cashJournals as $key => $cashJournal)
                                    <tr>
                                        <td>

                                        </td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $cashJournal->outlet_name }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($cashJournal->total_debit, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('finance.cash-journal.detail', ['date' => $date, 'outletId' => $cashJournal->user_id]) }}"
                                                class="btn btn-primary">
                                                Detail
                                            </a>

                                        </td>
                                    </tr>
                                    @php
                                        $total += $cashJournal->total_debit;
                                    @endphp
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">
                                        Total
                                    </th>
                                    <th>
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </th>
                                    <th>

                                    </th>
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
