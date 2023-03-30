@extends('layouts.admin')
@section('content')
    @can('supplier_create')
        <div class="block my-4">
            <a class="btn-md btn-green" href="{{ route('warehouse.suppliers.create') }}">
                Tambah Data
            </a>
        </div>
    @endcan
    <div class="main-card">
        <div class="header">
            Daftar Supplier
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
                                Nama Supplier
                            </th>
                            <th>
                                Alamat Supplier
                            </th>
                            <th>
                                Nomer Telfon
                            </th>

                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $key => $supplier)
                            <tr data-entry-id="{{ $supplier->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $supplier->id ?? '' }}
                                </td>
                                <td>
                                    {{ $supplier->name ?? '' }}
                                </td>
                                <td>
                                    {{ $supplier->address ?? '' }}
                                </td>
                                <td>
                                    {{ $supplier->phone ?? '' }}
                                </td>

                                <td>
                                    @can('supplier_show')
                                        <a class="btn-sm btn-indigo"
                                            href="{{ route('warehouse.suppliers.show', $supplier->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @can('unit_data_show')
                                        <a class="btn-sm btn-blue" href="{{ route('admin.data-bahan.edit', $supplier->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan


                                    @can('unit_data_delete')
                                        <form action="{{ route('admin.data-satuan.destroy', $supplier->id) }}" method="POST"
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
