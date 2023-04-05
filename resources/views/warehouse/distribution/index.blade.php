@extends('layouts.admin')
@section('content')
    @can('inventory_create')
        <div class="block my-4">
            <a class="btn-md btn-green" href="{{ route('warehouse.distribusi.create') }}">
                Distribusi
            </a>
        </div>
    @endcan
    <div class="main-card">
        <div class="header">
            Data Distribusi
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
                                        <a class="btn-sm btn-blue" href="{{ route('admin.data-bahan.edit', $inventory->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan


                                    @can('unit_data_delete')
                                        <form action="{{ route('admin.data-satuan.destroy', $inventory->id) }}" method="POST"
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
                    [1, 'asc']
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
