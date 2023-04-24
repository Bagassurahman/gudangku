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
                    <a class="btn btn-primary" href="{{ route('warehouse.distribusi.create') }}">
                        Distribusi
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
                                        HPP
                                    </th>
                                    <th>
                                        Harga Jual
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($distributions as $key => $inventory)
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
                                            {{ ($inventory->material ? $inventory->material->entry_amount ?? 0 : 0) - ($inventory->material ? $inventory->material->exit_amount ?? 0 : 0) }}
                                        </td>
                                        <td>
                                            {{ $inventory->hpp ?? '0' }}
                                        </td>
                                        <td>
                                            {{ $inventory->price ?? '0' }}
                                        </td>
                                        <td>
                                            @can('inventory_show')
                                                <a class="btn-sm btn-indigo"
                                                    href="{{ route('warehouse.persediaan.show', $inventory->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan
                                            @can('unit_data_show')
                                                <a class="btn-sm btn-blue"
                                                    href="{{ route('admin.data-bahan.edit', $inventory->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan


                                            @can('unit_data_delete')
                                                <form action="{{ route('admin.data-satuan.destroy', $inventory->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                    style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn-sm btn-red"
                                                        value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

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
