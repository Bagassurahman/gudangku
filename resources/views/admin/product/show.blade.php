@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Detail Produk {{ $product->name }}</h1>
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
                            Detail Produk
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
                                        Nama Produk
                                    </th>
                                    <td>
                                        {{ $product->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Harga Umum
                                    </th>
                                    <td>
                                        {{ $product->general_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Harga Member
                                    </th>
                                    <td>
                                        {{ $product->member_price }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Harga Online
                                    </th>
                                    <td>
                                        {{ $product->online_price }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Foto
                                    </th>
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                            class="img-thumbnail" width="200">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bahan Yang Diperlukan</th>
                                    <td>
                                        <ul>
                                            @foreach ($product->details as $detail)
                                                <li>{{ $detail->material->name }} ({{ $detail->dose }})</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-layout-footer mt-3">
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
