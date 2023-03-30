@extends('layouts.admin')
@section('content')
    @can('unit_data_create')
        <div class="block my-4">
            <a class="btn-md btn-green" href="{{ route('admin.data-satuan.create') }}">
                Tambah Satuan
            </a>
        </div>
    @endcan
    <div class="main-card">
        <div class="header">
            Daftar Satuan
        </div>

        <div class="body">
            <div class="w-full">
                <table class="stripe hover bordered datatable datatable-User">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                No
                            </th>
                            <th>
                                Satuan Gudang
                            </th>
                            <th>
                                Satuan Outlet
                            </th>
                            <th>
                                Aksi
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($units as $key => $unit)
                            <tr data-entry-id="{{ $unit->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $unit->id ?? '' }}
                                </td>
                                <td>
                                    {{ $unit->warehouse_unit ?? '' }}
                                </td>
                                <td>
                                    {{ $unit->outlet_unit ?? '' }}
                                </td>


                                <td>
                                    @can('unit_data_show')
                                        <a class="btn-sm btn-indigo" href="{{ route('admin.data-satuan.show', $unit->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan



                                    @can('unit_data_delete')
                                        <form action="{{ route('admin.data-satuan.destroy', $unit->id) }}" method="POST"
                                            onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn-sm btn-red" value="{{ trans('global.delete') }}">
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
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)


            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-User:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
