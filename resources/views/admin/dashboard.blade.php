<div class="pageheader pd-t-25 pd-b-35">
    <div class="pd-t-5 pd-b-5">
        <h1 class="pd-0 mg-0 tx-20">Dashboard Admin</h1>
    </div>
</div>
<div class="row row-xs clearfix">
    <div class="col-sm-6 col-xl-3">
        <div class="card mg-b-20">
            <div class="card-body pd-y-0">
                <div class="custom-fieldset mb-4">
                    <div class="clearfix">
                        <label>Total Omset</label>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <div
                            class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-warning">
                            <i class="icon-screen-desktop tx-warning tx-20"></i>
                        </div>
                        <div>
                            <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                Rp {{ number_format($totalOmset, 0, ',', '.') }}
                            </h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card mg-b-20">
            <div class="card-body pd-y-0">
                <div class="custom-fieldset mb-4">
                    <div class="clearfix">
                        <label>Total Biaya-Biaya</label>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <div
                            class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-success">
                            <i class="icon-diamond tx-success tx-20"></i>
                        </div>
                        <div>
                            <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                Rp {{ number_format($totalBiaya->total_biaya, 0, ',', '.') }}
                            </h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card mg-b-20">
            <div class="card-body pd-y-0">
                <div class="custom-fieldset mb-4">
                    <div class="clearfix">
                        <label>Total Pembelian</label>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <div
                            class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-primary">
                            <i class="icon-handbag tx-primary tx-20"></i>
                        </div>
                        <div>
                            @if (count($totalPembelian) > 0)
                                <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                    Rp {{ number_format($totalPembelian[0]->total_pembelian, 0, ',', '.') }}
                                </h2>
                            @else
                                <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                    Rp 0
                                </h2>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card mg-b-20">
            <div class="card-body pd-y-0">
                <div class="custom-fieldset mb-4">
                    <div class="clearfix">
                        <label>Total Margin</label>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <div
                            class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-danger">
                            <i class="icon-speedometer tx-danger tx-20"></i>
                        </div>
                        <div>
                            <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                Rp {{ number_format($margin, 0, ',', '.') }}

                            </h2>
                            <span>{{ $persentaseMargin }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 col-lg-12">
        <div class="card mg-b-20">
            <div class="card-header">
                <h4 class="card-header-title">
                    Produk Terlaris
                </h4>
                <div class="card-header-btn">
                    <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse8"
                        aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                    <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                            class="ion-android-refresh"></i></a>
                    <a href="#" data-toggle="expand" class="btn card-expand"><i
                            class="ion-android-expand"></i></a>
                    <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
                </div>
            </div>
            <div class="card-body collapse show p-0" id="collapse8">
                <div class="chart">
                    <div id="chart-product"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 col-lg-12">
        <div class="card mg-b-20">
            <div class="card-header">
                <h4 class="card-header-title">
                    Outet Terlaris
                </h4>
                <div class="card-header-btn">
                    <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse8"
                        aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                    <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                            class="ion-android-refresh"></i></a>
                    <a href="#" data-toggle="expand" class="btn card-expand"><i
                            class="ion-android-expand"></i></a>
                    <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
                </div>
            </div>
            <div class="card-body collapse show" id="collapse8">
                <div class="chart">
                    <div id="chart-outlet"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 col-lg-12">
        <div class="card mg-b-20">
            <div class="card-header">
                <h4 class="card-header-title">
                    Penjualan
                </h4>
                <div class="card-header-btn">
                    <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse8"
                        aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                    <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                            class="ion-android-refresh"></i></a>
                    <a href="#" data-toggle="expand" class="btn card-expand"><i
                            class="ion-android-expand"></i></a>
                    <a href="#" data-toggle="remove" class="btn card-remove"><i
                            class="ion-android-close"></i></a>
                </div>
            </div>
            <div class="card-body collapse show" id="collapse8">
                <div class="chart">
                    <div id="chart-penjualan"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 col-lg-12">
        <div class="card mg-b-20">
            <div class="card-header">
                <h4 class="card-header-title">
                    Kekayaan
                </h4>
                <div class="card-header-btn">
                    <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse8"
                        aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                    <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                            class="ion-android-refresh"></i></a>
                    <a href="#" data-toggle="expand" class="btn card-expand"><i
                            class="ion-android-expand"></i></a>
                    <a href="#" data-toggle="remove" class="btn card-remove"><i
                            class="ion-android-close"></i></a>
                </div>
            </div>
            <div class="card-body collapse show" id="collapse8">
                <div class="chart">
                    <div id="chart-kekayaan"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12">



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
    <div class="col-md-12 col-lg-12">
        <div class="card mg-b-20">
            <div class="card-header">
                <h4 class="card-header-title">
                    Data Kekayaan
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
                    <table class="table stripe hover bordered ">
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
                                    Total Kekayaan
                                </th>
                                <th>
                                    Jumlah Keluar
                                </th>
                                <th>
                                    Sisa Kekayaan
                                </th>


                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_riche = 0;
                                $debit_riche = 0;
                                $sub_total_riche = 0;
                            @endphp
                            @foreach ($riches as $riche)
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $riche->outlet->outlet_name ?? '' }}

                                    </td>
                                    <td>
                                        Rp {{ number_format($riche->total, 0, ',', '.') }}

                                    </td>
                                    <td>
                                        Rp {{ number_format($riche->debit, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        Rp {{ number_format($riche->sub_total, 0, ',', '.') }}

                                    </td>
                                </tr>
                                @php
                                    $total_riche += $riche->total;
                                    $debit_riche += $riche->debit;
                                    $sub_total_riche += $riche->sub_total;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="font-weight-bold">Total</th>
                                <th class="font-weight-bold">Rp {{ number_format($total_riche, 0, ',', '.') }}</th>
                                <th class="font-weight-bold">Rp {{ number_format($debit_riche, 0, ',', '.') }}</th>
                                <th class="font-weight-bold">Rp {{ number_format($sub_total_riche, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
