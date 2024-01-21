@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">


        <div class="row row-xs clearfix">

            @can('cash_journal_create')
                <div class="my-4">
                    <a class="btn btn-primary" href="{{ route('outlet.jurnal-kas.create') }}">
                        Tambah Jurnal
                    </a>
                </div>
            @endcan

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <form action="{{ route('outlet.jurnal-kas.index') }}" method="GET">
                    <div class="row align-items-center d-flex">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-md-5">
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
                            Data Jurnal
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
                                    <th>Tanggal</th>
                                    <th>Kode</th>
                                    <th>Total Debit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($journals as $cashJournal)
                                    <tr data-entry-id="{{ $cashJournal->id }}">
                                        <td></td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $cashJournal->date }}</td>
                                        <td>{{ $cashJournal->code }}</td>
                                        <td>
                                            @php
                                                $totalDebit = $cashJournal->detail->sum('debit');
                                                $formattedTotalDebit = number_format($totalDebit, 0, ',', '.');
                                            @endphp
                                            @php
                                                $total += $totalDebit;
                                                $formattedTotal = number_format($total, 0, ',', '.');
                                            @endphp
                                            Rp {{ $formattedTotalDebit }}
                                        </td>

                                        <td>
                                            <a href="{{ route('outlet.jurnal-kas.show', $cashJournal->id) }}">
                                                <button type="button" class="btn btn-primary btn-sm">
                                                    Detail
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right">Total</td>
                                    <td>Rp {{ $formattedTotal ?? '-' }}</td>
                                    <td></td>
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
    {{-- <script>
        // Mendapatkan tanggal hari ini
        var today = new Date().toISOString().split('T')[0];

        // Mengatur nilai default tanggal mulai dan tanggal akhir ke hari ini
        document.getElementById('tanggal_mulai').value = today;
        document.getElementById('tanggal_akhir').value = today;
    </script> --}}
@endsection
