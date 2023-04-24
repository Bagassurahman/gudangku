@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">


        <div class="row row-xs clearfix">
            @can('product_create')
                <div class="my-4">
                    <a class="btn btn-primary" href="{{ route('admin.produk.create') }}">
                        Tambah Produk
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
                            Data Produk
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
                                    <th>Nama Produk</th>
                                    <th>Harga Umum</th>
                                    <th>Harga Member</th>
                                    <th>Harga Online</th>
                                    <tH>Aksi</tH>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    <tr data-entry-id="{{ $product->id }}">
                                        <td></td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $product->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->general_price ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->member_price ?? '' }}
                                        </td>
                                        <td>
                                            {{ $product->online_price ?? '' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.produk.show', $product->id) }}"
                                                class="btn btn-primary">Lihat</a>
                                            @can('product_edit')
                                                <a href="{{ route('admin.produk.edit', $product->id) }}"
                                                    class="btn btn-info">Edit</a>
                                            @endcan

                                            @can('product_delete')
                                                <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin?');"
                                                    style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-danger" value="Hapus">
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
