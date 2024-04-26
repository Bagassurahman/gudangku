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
            <div class="col-md-12 col-lg-12 mt-4">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Data Customer
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
                            <table class="table stripe hover bordered datatable datatable-Role">
                                <thead>
                                    <tr>
                                        <th width="10">

                                        </th>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Nama Customer
                                        </th>
                                        <th>
                                            Nomor Hp
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Jumlah Poin
                                        </th>
                                        <th>
                                            Total Transaksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $key => $customer)
                                        <tr data-entry-id="{{ $customer->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $customer->name ?? '' }}
                                            </td>

                                            <td>
                                                {{ $customer->phone ?? '' }}
                                            </td>
                                            <td>
                                                {{ $customer->email ?? '' }}
                                            </td>
                                            <td>
                                                {{ $customer->point }}
                                            </td>
                                            <td>
                                                {{ $customer->transactions_history->sum('total_price') ?? '' }}
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
