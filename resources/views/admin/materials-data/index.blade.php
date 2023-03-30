@extends('layouts.admin')
@section('content')
    @can('material_data_create')
        <div class="block my-4">
            <a class="btn-md btn-green" href="{{ route('admin.data-bahan.create') }}">
                Tambah Data
            </a>
        </div>
    @endcan
    <div class="main-card">
        <div class="header">
            Daftar Bahan
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
                                Nama Bahan
                            </th>
                            <th>
                                Kategori
                            </th>
                            <th>
                                Satuan Gudang
                            </th>
                            <th>
                                Satuan Outlet
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
                        @foreach ($materials as $key => $material)
                            <tr data-entry-id="{{ $material->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $material->id ?? '' }}
                                </td>
                                <td>
                                    {{ $material->name ?? '' }}
                                </td>
                                <td>
                                    {{ $material->category ?? '' }}
                                </td>
                                <td>
                                    {{ $material->unit->warehouse_unit ?? '' }}
                                </td>
                                <td>
                                    {{ $material->unit->outlet_unit ?? '' }}
                                </td>
                                <td>
                                    {{ $material->price ?? '' }}

                                </td>
                                <td>
                                    @can('unit_data_show')
                                        <a class="btn-sm btn-indigo"
                                            href="{{ route('admin.data-satuan.show', $material->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('unit_data_show')
                                        <a class="btn-sm btn-blue" href="{{ route('admin.data-bahan.edit', $material->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan


                                    @can('unit_data_delete')
                                        <form action="{{ route('admin.data-satuan.destroy', $material->id) }}" method="POST"
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
