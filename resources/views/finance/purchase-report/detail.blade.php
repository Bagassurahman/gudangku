@extends('layouts.admin-new')
@section('title', 'Laporan Pembelian ' . $date)
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow"> Detail Laporan Pembelian {{ $warehouse->warehouse_name }}
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
                            Detail Laporan Pembelian {{ $date }}
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
                                        Nama Bahan
                                    </th>
                                    <th>
                                        Total Qty
                                    </th>
                                    <th>
                                        Harga
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($purchaseDetails as $key => $purchase)
                                    <tr data-entry-id="{{ $purchase->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $purchase->material_name }}
                                        </td>
                                        <td>
                                            {{ $purchase->total_quantity }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($purchase->price, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($purchase->total_price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @php
                                        $total += $purchase->total_price;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">Total</td>
                                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
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
