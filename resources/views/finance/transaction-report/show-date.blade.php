@extends('layouts.admin-new')
@section('title', 'Laporan Penjualan')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow"> Detail Laporan Penjualan </h1>
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
                            Detail Laporan Penjualan
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
                                        Kode
                                    </th>
                                    <th>
                                        Outlet
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
                                @foreach ($transactions as $key => $transaction)
                                    <tr data-entry-id="{{ $transaction->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $transaction->order_number }}
                                        </td>
                                        <td>
                                            {{ $transaction->outlet_name }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ route('finance.transaction.detail', $transaction->id) }}"
                                                class="btn btn-primary mr-2">
                                                Detail
                                            </a>
                                            @can('delete_transaction')
                                                <form
                                                    action="{{ route('finance.laporan-penjualan.destroy', $transaction->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
<<<<<<< HEAD
                                                        <i class="fa fa-trash"></i>
=======
                                                        Hapus Transaksi
>>>>>>> 183e60f (update from cpanel)
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                    @php
                                        $total += $transaction->total;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align: right;">Total:</th>
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
