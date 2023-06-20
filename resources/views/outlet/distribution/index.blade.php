@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Data Distribusi</h1>
            </div>
        </div>
        <div class="row row-xs clearfix">
            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Data Distibusi
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
                                        Kode Distribusi
                                    </th>
                                    <th>
                                        Tanggal
                                    </th>
                                    <th>
                                        Biaya Pengiriman
                                    </th>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distributions as $distribution)
                                    <tr>
                                        <th>

                                        </th>
                                        <th>
                                            {{ $loop->iteration }}
                                        </th>
                                        <th>
                                            {{ $distribution->distribution_number }}
                                        </th>
                                        <th>
                                            {{ $distribution->distribution_date }}
                                        </th>
                                        <th>
                                            Rp {{ number_format($distribution->fee, 0, ',', '.') }}
                                        </th>
                                        <th>
                                            Rp
                                            {{ number_format($distribution->distributionDetails->sum('total'), 0, ',', '.') }}
                                        </th>
                                        <td>
                                            <span
                                                class="badge
                                            {{ $distribution->status == 'on_progres' ? 'badge-warning' : '' }}
                                            {{ $distribution->status == 'accepted' ? 'badge-success' : '' }}
                                            {{ $distribution->status == 'rejected' ? 'badge-danger' : '' }}
                                            text-white">
                                                {{ $distribution->status ?? '' }}</span>
                                        </td>
                                        <td>
                                            @if ($distribution->status == 'on_progres')
                                                <a href="{{ route('outlet.distribusi.show', $distribution->id) }}"
                                                    class="btn btn-primary">
                                                    Detail
                                                </a>
                                            @endif
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
@endsection
