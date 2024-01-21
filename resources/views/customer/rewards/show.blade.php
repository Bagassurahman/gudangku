@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 ">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-0">
                    <li class="breadcrumb-item"><a href="{{ route('customer.reward.index') }}">Hadiah</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $reward->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="row row-xs clearfix ">
            <div class="col-12 col-lg-6">
                <img src="{{ $reward->image }}" alt="{{ $reward->name }}" class="img-fluid">
            </div>
            <div class="col-12 col-lg-6">
                <table class="table table-bordered mt-3">
                    <tr>
                        <td>Nama Reward:</td>
                        <td>{{ $reward->name }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi:</td>
                        <td>{{ $reward->description }}</td>
                    </tr>

                    <tr>
                        <td>Stok:</td>
                        <td>{{ $reward->stock }}</td>
                    </tr>
                    <tr>
                        <td>Poin yang dibutuhkan:</td>
                        <td>{{ $reward->point }}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
