@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">{{ $reward->name }}</h1>
            </div>

        </div>
        <div class="row row-xs clearfix">
            <!--================================-->
            <!-- Top Label Layout Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            {{ $reward->name }}
                        </h4>
                        <div class="card-header-btn">
                            <a href="" data-toggle="collapse" class="btn card-collapse" data-target="#collapse1"
                                aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                            <a href="" data-toggle="refresh" class="btn card-refresh"><i
                                    class="ion-android-refresh"></i></a>
                            <a href="" data-toggle="expand" class="btn card-expand"><i
                                    class="ion-android-expand"></i></a>
                            <a href="" data-toggle="remove" class="btn card-remove"><i
                                    class="ion-android-close"></i></a>
                        </div>
                    </div>
                    <div class="card-body collapse show" id="collapse1">
                        <table class="table table-bordered">
                            <tr>
                                <td width="200">
                                    Nama Reward
                                </td>
                                <td>{{ $reward->name }}</td>
                            </tr>
                            <tr>
                                <td width="200">
                                    Deskripsi
                                </td>
                                <td>{{ $reward->description }}</td>
                            </tr>
                            <tr>
                                <td width="200">
                                    Point
                                </td>
                                <td>{{ $reward->point }}</td>
                            </tr>
                            <tr>
                                <td width="200">
                                    Gambar
                                </td>
                                <td><img src="{{ $reward->image }}" alt="" width="200"></td>
                            </tr>
                            <tr>
                                <td width="200">
                                    Stok
                                </td>
                                <td>{{ $reward->stock }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.reward.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>

        </div>



    </div>
@endsection
