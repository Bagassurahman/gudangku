@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">


        <div class="row row-xs clearfix">

            @can('request_create')
                <div class="my-4">
                    <a class="btn btn-primary" href="{{ route('outlet.request.create') }}">
                        Request Bahan
                    </a>
                </div>
            @endcan

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Data Request
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
                                    <th>No</th>
                                    <th>Kode Request</th>
                                    <th>Status</th>
                                    <th>Gudang</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $key => $request)
                                    <tr data-entry-id="{{ $request->id }}">
                                        <td></td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $request->code ?? '' }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge
                                            {{ $request->status == 'pending' ? 'badge-warning' : '' }}
                                            {{ $request->status == 'approved' ? 'badge-success' : '' }}
                                            {{ $request->status == 'rejected' ? 'badge-danger' : '' }}


                                            text-white">
                                                {{ $request->status ?? '' }}</span>
                                        </td>
                                        <td>
                                            {{ $request->warehouse->warehouse_name ?? '' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('outlet.request.show', $request->id) }}"
                                                class="btn btn-primary">
                                                Lihat Data
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
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
