@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        @can('dashboard_warehouse_access')
            <!--================================-->
            <!-- Breadcrumb Start -->
            <!--================================-->
            <div class="pageheader pd-t-25 pd-b-35">
                <div class="pd-t-5 pd-b-5">
                    <h1 class="pd-0 mg-0 tx-20">Rekap Bulan April 2023</h1>
                </div>

            </div>
            <!--/ Breadcrumb End -->

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
                                            Rp<span class="counter">30.000</span></h2>

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
                                            Rp<span class="counter">0</span></h2>

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
                                        <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                            Rp<span class="counter">{{ $totalPembelianPerBulan }}</span>
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
                                    <label>Total Margin</label>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div
                                        class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-danger">
                                        <i class="icon-speedometer tx-danger tx-20"></i>
                                    </div>
                                    <div>
                                        <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                            Rp<span class="counter">9,900</span></h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="card mg-b-20">
                        <div class="card-header">
                            <h4 class="card-header-title">
                                Data Persediaan
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
                                            Jumlah Masuk
                                        </th>
                                        <th>
                                            Jumlah Keluar
                                        </th>
                                        <th>
                                            Jumlah Sisa
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventories as $key => $inventory)
                                        <tr data-entry-id="{{ $inventory->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $inventory->name ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($inventory->inventories as $inv)
                                                    {{ $inv->entry_amount ?? '0' }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($inventory->inventories as $inv)
                                                    {{ $inv->exit_amount ?? '0' }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($inventory->inventories as $inv)
                                                    {{ $inv->remaining_amount ?? '0' }}
                                                @endforeach
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('warehouse.persediaan.index') }}" class="btn btn-primary">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
@section('scripts')
    @parent
@endsection
