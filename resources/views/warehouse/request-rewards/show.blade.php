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
            filter: url("https://gist.githubusercontent.com/amitabhaghosh197/b7865b409e835b5a43b5/raw/1a255b551091924971e7dee8935fd38a7fdf7311/blur" .svg#blur);
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
                            Detail Request {{ $request->code }}
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
                                            Kode Request
                                        </th>
                                        <td>
                                            {{ $request->code }}
                                        </td>
                                    </tr>
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
                                            Nama Pelanggan
                                        </th>
                                        <td>
                                            {{ $request->user->name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            No. Telepon
                                        </th>
                                        <td>
                                            {{ $request->user->phone ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Hadiah
                                        </th>
                                        <td>
                                            {{ $request->reward->name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Outlet Penukaran
                                        </th>
                                        <td>
                                            {{ $request->outlet->outlet_name ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                        <td>
                                            <span
                                                class="badge badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }}">{{ $request->status }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Poin Yang Ditukarkan
                                        </th>
                                        <td>
                                            {{ $request->point }} Poin
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Catatan
                                        </th>
                                        <td>
                                            {{ $request->note ?? '-' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-layout-footer mt-3 d-flex">
                            {{-- @if ($request[0]->status === 'pending')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_modal_1">
                                    Distribusikan</button>

                                <form action="{{ route('warehouse.request.reject') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $request[0]->id }}">

                                    <input type="submit" class="btn btn-danger ml-2" value="Tolak">
                                </form>
                            @endif --}}
                            @if ($request->status === 'pending')
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#m_modal_1">Setujui</button>


                                <form action="{{ route('warehouse.request-reward.reject') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $request->id }}">

                                    <input type="submit" class="btn btn-danger ml-2" value="Tolak">
                                </form>
                            @endif
                            <a href="{{ route('warehouse.request-reward.index') }}"
                                class="btn btn-secondary ml-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                    </button>
                </div>
                <form action="{{ route('warehouse.request-reward.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $request->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="outlet_id">Outlet</label>
                            <select name="outlet_id" id="outlet_id" class="form-control">
                                <option value="">Pilih Outlet</option>
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->outlet_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note">Catatan</label>
                            <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script></script>
@endsection
