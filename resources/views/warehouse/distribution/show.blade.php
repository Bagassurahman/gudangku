@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow"> Data Distribusi</h1>
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
                            Data Distribusi
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
                                        Tanggal Distribusi
                                    </th>
                                    <th>
                                        Biaya Kirim
                                    </th>
                                    <th>
                                        SubTotal
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
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($distributionDetails as $key => $distribution)
                                    <tr data-entry-id="{{ $distribution->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $distribution->distribution_date }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($distribution->fee, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            Rp {{ number_format($distribution->total_summary, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            Rp
                                            {{ number_format($distribution->total_summary + $distribution->fee, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @if ($distribution->status == 'accepted')
                                                <span class="badge badge-success">Diterima</span>
                                            @endif
                                            @if ($distribution->status == 'on_progres')
                                                <span class="badge badge-warning">Dalam Proses</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                @if ($distribution->status == 'on_progres')
                                                    <form
                                                        action="{{ route('warehouse.distribusi.destroy', $distribution->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                            <i class="fa fa-trash"></i>

                                                            Hapus

                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('warehouse.distribusi.detail', $distribution->id) }}">
                                                    <button type="button" class="btn btn-primary ml-2">
                                                        <i class="fa fa-eye"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-primary ml-2">Detail</button>

                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $total += $distribution->total + $distribution->fee;
                                    @endphp
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
