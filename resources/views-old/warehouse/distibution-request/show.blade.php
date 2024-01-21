@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">

    <style>
        body.modal-open .row {
            -webkit-filter: blur(4px);
            -moz-filter: blur(4px);
            -o-filter: blur(4px);
            -ms-filter: blur(4px);
            filter: blur(4px);
            filter: url("https://gist.githubusercontent.com/amitabhaghosh197/b7865b409e835b5a43b5/raw/1a255b551091924971e7dee8935fd38a7fdf7311/blur".svg#blur);
            filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius='4');
        }

        .modal-content {
            border: none;
            border-radius: 16px;
        }

        .modal-content .modal-header {
            background-color: #f6f8fd;
            border-radius: 16px 16px 0 0;
        }
    </style>
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
                        <div class="table-responsive">
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
                                            @if ($request->status === 'pending')
                                                <ul class="list-group">
                                                    @foreach ($request->details as $detail)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $detail->material->name }}
                                                            <input type="number" name="qty[]"
                                                                value="{{ $detail->qty }}" class="form-control w-25"
                                                                id="input_qty">
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <ul class="list-group">
                                                    @foreach ($request->details as $detail)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $detail->material->name }}
                                                            <input type="number" name="qty[]"
                                                                value="{{ $detail->qty }}" class="form-control w-25"
                                                                id="input_qty" disabled>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </th>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                        <div class="form-layout-footer mt-3 d-flex">
                            @if ($request->status === 'pending')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_modal_1">
                                    Distribusikan</button>
                            @endif
                            <a href="{{ route('warehouse.data-request-bahan.index') }}"
                                class="btn btn-secondary ml-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel_1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel_1">Konfirmasi Distribusi</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                    </button>
                </div>
                <form action="{{ route('warehouse.data-request-bahan.update', $request->id) }}" method="POST"
                    id="distribution_form">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label active">Biaya Pengiriman</label>
                            <input
                                class="form-control @error('fee')
                                            is-invalid
                                        @enderror"
                                type="number" name="fee" value="{{ old('fee') }}">
                            @error('fee')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-distribusi">Distribusikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#btn-distribusi').click(function() {
                // Ambil nilai kuantitas yang diperbarui
                var qtyInputs = $('input[name="qty[]"]');
                qtyInputs.each(function(index, input) {
                    var newQty = $(input).val();
                    // Tambahkan nilai kuantitas ke formulir saat submit
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'updated_qty[]',
                        value: newQty
                    }).appendTo('#distribution_form');
                });
                // Submit formulir setelah menambahkan nilai kuantitas
                $('#distribution_form').submit();
            });
        });
    </script>
@endsection
