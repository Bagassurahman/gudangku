@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="row row-xs clearfix">
            @can('unit_data_create')
                <div class="my-4">
                    <a class="btn btn-primary" href="{{ route('admin.manajemen-outlet.create') }}">
                        Tambah Manajemen Outlet
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
                            Data Manajemen Outlet
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
                                            Nama Outlet
                                        </th>
                                        <th>
                                            Penangung Jawab
                                        </th>
                                        <th>
                                            Alamat
                                        </th>
                                        <th>
                                            Nomer Hp
                                        </th>
                                        <th>
                                            Target
                                        </th>

                                        <th>
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($outlets as $key => $user)
                                        <tr data-entry-id="{{ $user->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $user->outlet->outlet_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->address ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->phone }}
                                            </td>
                                            <td>
                                                {{ $user->outlet->target }}
                                            </td>
                                            <td>
                                                @can('user_show')
                                                    <a class="btn btn-warning"
                                                        href="{{ route('admin.users.show', $user->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('user_edit')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('admin.users.edit', $user->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('user_delete')
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                        style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-danger"
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
