@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Detail Outlet</h1>
            </div>

        </div>

        <div class="row row-xs clearfix">

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Detail Outlet
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
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            Nama Outlet
                                        </th>
                                        <td>
                                            {{ $outlet->outlet->outlet_name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Penanggung Jawab
                                        </th>
                                        <td>
                                            {{ $outlet->name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Target
                                        </th>
                                        <td>
                                            {{ $outlet->outlet->target ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Gudang Suplai
                                        </th>
                                        <td>
                                            {{ $outlet->outlet->warehouse->warehouse_name ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Alamat
                                        </th>
                                        <td>
                                            {{ $outlet->address ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Email
                                        </th>
                                        <td>
                                            {{ $outlet->email ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            No. Telepon
                                        </th>
                                        <td>
                                            {{ $outlet->phone ?? '' }}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-layout-footer mt-3">
                            <a href="{{ route('admin.manajemen-outlet.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
