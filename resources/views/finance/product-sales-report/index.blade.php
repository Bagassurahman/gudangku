@extends('layouts.admin-new')
@section('title', 'Laporan Penjualan Produk ')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Laporan Penjualan Produk</h1>
            </div>

        </div>

        <div class="row row-xs clearfix">

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <form action="{{ route('finance.laporan-penjualan-product.index') }}" method="GET">
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
                            Data Laporan Penjualan Produk
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
                                        Nama Produk
                                    </th>
                                    {{--  <th>
                                        UMUM
                                    </th>  --}}
                                    <th>
                                        Total Quantity
                                    </th>
                                    <th>
                                        Total Penjualan
                                    </th>



                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $qty = 0;
                                @endphp
                                @foreach ($productSales as $key => $product)
                                    <tr data-entry-id="{{ $product->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $product->name }}
                                        </td>
                                        {{--  <td>
                                            @php
                                                $umum = \App\Product::where('transactions.customer_type', 'umum')->get();
                                            @endphp
                                            {{ $product->name }}
                                        </td>  --}}
                                        <td>
                                            {{ $product->total_qty ?? '0' }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($product->total_amount, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                    @php
                                        $total += $product->total_amount;
                                        $qty += $product->total_qty;
                                    @endphp
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th>{{ $qty }}</th>
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
