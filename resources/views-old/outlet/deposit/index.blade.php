@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">


        <div class="row row-xs clearfix">



            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <form action="{{ route('outlet.jurnal-kas.index') }}" method="GET">
                    <div class="row align-items-center d-flex">
                        <div class="col-md-5 col-12">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir">
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
                            Data Setoran
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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deposits as $deposit)
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
                                                class="badge
                                            {{ $deposit->status == 'pending' ? 'badge-warning' : '' }}
                                            {{ $deposit->status == 'success' ? 'badge-success' : '' }}
                                            {{ $deposit->status == 'waiting' ? 'badge-danger' : '' }}
                                            text-white">
                                                {{ $deposit->status ?? '' }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('outlet.setoran.show', $deposit->id) }}"
                                                class="btn btn-primary">
                                                Detail
                                            </a>

                                        </td>
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
    {{-- <script>
        // Mendapatkan tanggal hari ini
        var today = new Date().toISOString().split('T')[0];

        // Mengatur nilai default tanggal mulai dan tanggal akhir ke hari ini
        document.getElementById('tanggal_mulai').value = today;
        document.getElementById('tanggal_akhir').value = today;
    </script> --}}
@endsection
