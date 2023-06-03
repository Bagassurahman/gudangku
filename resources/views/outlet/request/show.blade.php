@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Detail Request {{ $request->code }}</h1>
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
                            Detail Request
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
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        Tanggal Request
                                    </th>
                                    <td>
                                        {{ $request->created_at }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Kode Request
                                    </th>
                                    <td>
                                        {{ $request->code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Outlet
                                    </th>
                                    <td>
                                        {{ $request->outlet->outlet_name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Status
                                    </th>
                                    <td>
                                        <span
                                            class="badge
                                            {{ $request->status == 'pending' ? 'badge-warning' : '' }}
                                            {{ $request->status == 'approved' ? 'badge-success' : '' }}
                                            {{ $request->status == 'rejected' ? 'badge-danger' : '' }}
                                            text-white">
                                            {{ $request->status ?? '' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Bahan Yang Di Request
                                    </th>
                                    <th>
                                        <ul>
                                            @foreach ($request->details as $detail)
                                                <li>{{ $detail->material->name }} ({{ $detail->qty }})</li>
                                            @endforeach
                                        </ul>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-layout-footer mt-3">
                            <a href="{{ route('outlet.request.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
