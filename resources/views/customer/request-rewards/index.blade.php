@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Riwayat Penukaran Poin</h1>
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
                            Riwayat Penukaran Poin
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
                                        Kode Request
                                    </th>
                                    <th>
                                        Tanggal
                                    </th>
                                    <th>
                                        Hadiah
                                    </th>
                                    <th>
                                        Outlet Penukaran
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Poin Dibutuhkan
                                    </th>
                                    <th>
                                        Catatan
                                    </th>
                                    <th>
                                        Bukti Pengambilan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $key => $request)
                                    <tr data-entry-id="{{ $request->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $request->code }}
                                        </td>
                                        <td>
                                            {{ $request->created_at }}
                                        </td>
                                        <td>
                                            {{ $request->reward->name }}
                                        </td>
                                        <td>
                                            {{ $request->outlet->outlet_name ?? 'Belum diproses' }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'approved' ? 'success' : 'danger') }}">
                                                {{ $request->status == 'approved' ? 'Disetujui Menunggu Pengambilan' : $request->status }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $request->point }}
                                        </td>
                                        <td>
                                            {{ $request->note }}
                                        </td>
                                        <td>
                                            @if ($request->proof)
                                                <img src="{{ asset('storage/' . $request->proof) }}" alt="Bukti Penukaran"
                                                    style="width: 100px">
                                            @else
                                                Belum ada bukti penukaran
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
