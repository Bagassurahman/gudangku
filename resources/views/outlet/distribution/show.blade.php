@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Detail Distribusi {{ $distribution->distribution_number }}</h1>
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
                            Detail Distribusi
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
                                        Kode Distribusi
                                    </th>
                                    <td>
                                        {{ $distribution->distribution_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Status
                                    </th>
                                    <td>
                                        <span
                                            class="badge
                                            {{ $distribution->status == 'on_progres' ? 'badge-warning' : '' }}
                                            {{ $distribution->status == 'accepted' ? 'badge-success' : '' }}
                                            {{ $distribution->status == 'rejected' ? 'badge-danger' : '' }}
                                            text-white">
                                            {{ $distribution->status ?? '' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Bahan Yang Di Distribusi
                                    </th>
                                    <th>
                                        <ul>
                                            @foreach ($distribution->distributionDetails as $detail)
                                                <li>{{ $detail->material->name }} ({{ $detail->quantity }})</li>
                                            @endforeach
                                        </ul>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        Total
                                    </th>
                                    <th>
                                        Rp
                                        {{ number_format($distribution->distributionDetails->sum('total'), 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-layout-footer mt-3 d-flex">
                            <button type="button" class="btn btn-primary" onclick="accept()">
                                Bahan Sudah Diterima</button>
                            <a href="{{ route('outlet.distribusi.index') }}" class="btn btn-secondary ml-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function accept() {
            Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Mohon cek bahan sebelum melakukan konfirmasi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, saya yakin!',
                    cancelButtonText: 'Batal'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('outlet.distribusi.accept', $distribution->id) }}",
                            method: 'GET',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire(
                                        'Berhasil!',
                                        'Distribusi berhasil diterima',
                                        'success'
                                    )
                                    .then((result) => {
                                        window.location.href =
                                            "{{ route('outlet.distribusi.index') }}";
                                    })
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Distribusi gagal diterima',
                                    'error'
                                )
                            }
                        })
                    }
                })
        }
    </script>
@endsection
