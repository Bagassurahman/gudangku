<div class="pageheader pd-t-25 pd-b-35">
    <div class="pd-t-5 pd-b-5">
        <h1 class="pd-0 mg-0 tx-20">Rekap Bulan
            {{ trans('date.months.' . date('F')) }} {{ date('Y') }}

        </h1>
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
                        <label>Total Setoran Hari Ini</label>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <div
                            class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-success">
                            <i class="icon-diamond tx-success tx-20"></i>
                        </div>
                        <div>
                            <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                Rp {{ number_format($depo, 0, ',', '.') }}
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
                        <label>Total Kekayaan Outlet Bulan Ini</label>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <div
                            class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-primary">
                            <i class="icon-handbag tx-primary tx-20"></i>
                        </div>
                        <div>
                            <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                Rp
                                {{ number_format($riche, 0, ',', '.') }}


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
                        <label>Total Hutang Bulan Ini</label>
                    </div>
                    <div class="d-flex align-items-center text-dark">
                        <div
                            class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-danger">
                            <i class="icon-speedometer tx-danger tx-20"></i>
                        </div>
                        <div>
                            <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                Rp {{ number_format($debt, 0, ',', '.') }}

                            </h2>

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
                    Data Transaksi
                </h4>
                <div class="card-header-btn">
                    <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse1"
                        aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                    <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                            class="ion-android-refresh"></i></a>
                    <a href="#" data-toggle="expand" class="btn card-expand"><i
                            class="ion-android-expand"></i></a>
                    <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
                </div>
            </div>
            <div class="card-body collapse show" id="collapse1">
                <div class="table-responsive">
                    <table class="table stripe hover bordered ">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                                <th>
                                    Kode
                                </th>
                                <th>
                                    Tanggal
                                </th>
                                <th>
                                    Outlet
                                </th>
                                <th>
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $transaction->order_number }}
                                    </td>
                                    <td>
                                        {{ $transaction->order_date }}
                                    </td>
                                    <td>
                                        {{ $transaction->outlet->outlet_name }}
                                    </td>
                                    <td>
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
 <div class="col-md-12 col-lg-12">
        <div class="card mg-b-20">
            <div class="card-header">
                <h4 class="card-header-title">
                    Data Setoran Sukses Hari Ini
                </h4>
                <div class="card-header-btn">
                    <a href="#" data-toggle="collapse" class="btn card-collapse" data-target="#collapse1"
                        aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                    <a href="#" data-toggle="refresh" class="btn card-refresh"><i
                            class="ion-android-refresh"></i></a>
                    <a href="#" data-toggle="expand" class="btn card-expand"><i
                            class="ion-android-expand"></i></a>
                    <a href="#" data-toggle="remove" class="btn card-remove"><i class="ion-android-close"></i></a>
                </div>
            </div>
            <div class="card-body collapse show" id="collapse1">
                <div class="table-responsive">
                    <table class="table stripe hover bordered ">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                               <th>Outlet</th>
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
                            </tr>
                        </thead>
                        <tbody>
                           @foreach ($deposits as $deposit)
                                        <tr>
                                           
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $deposit->account->user->outlet->outlet_name }}</td>
                                            <td>{{ $deposit->deposit_number }}</td>
                                            <td>{{ $deposit->deposit_date }}</td>
                                            <td>Rp {{ number_format($deposit->omset, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($deposit->online, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($deposit->shoppe_pay, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($deposit->cash_journal, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($deposit->amount, 0, ',', '.') }}</td>
                                         
                                        </tr>
                                    @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
