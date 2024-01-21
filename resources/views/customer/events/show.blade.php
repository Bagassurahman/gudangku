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
                    <li class="breadcrumb-item"><a href="{{ route('customer.event.index') }}">Event</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $event->name }}</li>
                </ol>
            </nav>
        </div>
        <div class="row row-xs clearfix ">
            <div class="col-12 col-lg-6">
                <img src="{{ $event->image }}" alt="{{ $event->name }}" class="img-fluid">
            </div>
            <div class="col-12 col-lg-6">
                <table class="table table-bordered mt-3">
                    <tr>
                        <td>Nama Event:</td>
                        <td>{{ $event->name }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi:</td>
                        <td>{{ $event->description }}</td>
                    </tr>

                    <tr>
                        <td>Tanggal & Waktu:</td>
                        <td>{{ $event->getFormattedDateTimeAttribute() }}</td>
                    </tr>
                    <tr>
                        <td>Tempat:</td>
                        <td>{{ $event->getFormattedLocationAttribute() }}</td>
                    </tr>
                </table>
                <a href="https://wa.me/{{ $event->phone }}" class="btn btn-success btn-sm w-100 p-2 "
                    target="_blank">Hubungi
                    Penyelenggara</a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
