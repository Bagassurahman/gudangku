@extends('layouts.admin')
@section('content')
    @can('cost_create')
        <div class="block my-4">
            <a class="btn-md btn-green" href="{{ route('admin.biaya.create') }}">
                Tambah Biaya
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
                                Biaya Biaya
                            </th>
                            <th>
                                Aksi
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costs as $key => $cost)
                            <tr data-entry-id="{{ $cost->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $cost->id ?? '' }}
                                </td>
                                <td>
                                    {{ $cost->name ?? '' }}
                                </td>

                                <td>
                                    @can('cost_show')
                                        <a class="btn-sm btn-indigo" href="{{ route('admin.biaya.show', $cost->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan



                                    @can('cost_delete')
                                        <form action="{{ route('admin.biaya.destroy', $cost->id) }}" method="POST"
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
