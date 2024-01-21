@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">


        <div class="row row-xs clearfix">
            @can('inventory_create')
                <div class="my-4">
                    <a class="btn btn-primary" href="{{ route('warehouse.pembelian-bahan.index') }}">
                        Tambah Persediaan
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
                                        <th>
                                            Sedang Dalam Proses Distribusi
                                        </th>
                                        <th>
                                            Jumlah Seharusnya
                                        </th>
                                        <th>
                                            HPP
                                        </th>
                                        <th>
                                            Harga Jual
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($combinedData as $cb)
                                        <tr>
                                            <td></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $cb['inventory']->name ?? '' }}</td>
                                            <td>{{ $cb['inventory']->inventories->first()->entry_amount ?? '' }}
                                                {{ $cb['inventory']->inventories->first()->material->unit->warehouse_unit ?? '' }}
                                            </td>
                                            <td>{{ $cb['inventory']->inventories->first()->exit_amount ?? '' }}
                                                {{ $cb['inventory']->inventories->first()->material->unit->warehouse_unit ?? '' }}
                                            </td>
                                            <td>
                                                @if ($cb['inventory']->inventories->first())
                                                    {{ $cb['inventory']->inventories->first()->remaining_amount ?? '' }}
                                                    {{ $cb['inventory']->inventories->first()->material->unit->warehouse_unit ?? '' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $cb['totalQuantity'] ?? '' }}
                                                {{ $cb['inventory']->inventories->first()->material->unit->warehouse_unit ?? '' }}
                                            </td>
                                            <td>
                                                @if ($cb['inventory']->inventories->first() && $cb['totalQuantity'])
                                                    {{ ($cb['inventory']->inventories->first()->remaining_amount ?? 0) - ($cb['totalQuantity'] ?? 0) }}
                                                    {{ $cb['inventory']->inventories->first()->material->unit->warehouse_unit ?? '' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $cb['inventory']->inventories->first()->hpp ?? '' }}</td>
                                            <td>{{ $cb['inventory']->selling_price ?? '' }}</td>
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
