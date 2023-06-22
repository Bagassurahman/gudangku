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
                    <div class="row align-items-center d-flex mb-4">
                        <div class="col-md-10 mx-auto mt-2">
                            <select class="form-control" name="filter">
                                <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua</option>
                                <option value="daily" {{ request('filter') == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="monthly" {{ request('filter') == 'monthly' ? 'selected' : '' }}>Bulanan
                                </option>
                                <option value="yearly" {{ request('filter') == 'yearly' ? 'selected' : '' }}>Tahunan
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 mx-auto mt-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
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
                                    <th>
                                        Aksi
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
                                        <td>
                                            {{--  <a href="{{ route('finance.laporan-penjualan-product.show', $product->id) }}"
                                                class="btn btn-primary">Detail</a>  --}}
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
                                    <th colspan="4" style="text-align: right;">Total Penjualan:</th>
                                    <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align: right;">Total Quantity:</th>
                                    <th>{{ $qty }}</th>
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
