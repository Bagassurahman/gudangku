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
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Detail Setoran</h1>
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
                            Detail Setoran
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
                                            Kode Setoran
                                        </th>
                                        <td>
                                            {{ $deposit->deposit_number }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Tanggal Setoran
                                        </th>
                                        <td>
                                            {{ $deposit->deposit_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Status
                                        </th>
                                        <td>
                                            <span
                                                class="badge
                                            {{ $deposit->status == 'pending' ? 'badge-warning' : '' }}
                                            {{ $deposit->status == 'success' ? 'badge-success' : '' }}
                                            {{ $deposit->status == 'waiting' ? 'badge-danger' : '' }}
                                            text-white">
                                                {{ $deposit->status ?? '' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Total Setoran
                                        </th>
                                        <td>
                                            Rp {{ number_format($deposit->amount, 0, ',', '.') }}

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Total Omset
                                        </th>
                                        <td>
                                            Rp {{ number_format($deposit->omset, 0, ',', '.') }}
                                            <button type="button" class="btn btn-sm btn-primary ml-3" data-toggle="modal"
                                                data-target="#modalOmset">
                                                Tampilkan Detail
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            SF & GF
                                        </th>
                                        <td>
                                            Rp {{ number_format($deposit->online, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            ShopePay
                                        </th>
                                        <td>
                                            Rp {{ number_format($deposit->shoppe_pay, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Jurnal Kas
                                        </th>
                                        <td>
                                            Rp {{ number_format($deposit->cash_journal, 0, ',', '.') }}
                                            <button type="button" class="btn btn-sm btn-primary ml-3" data-toggle="modal"
                                                data-target="#modalJurnal">
                                                Tampilkan Detail
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-layout-footer mt-3 d-flex">
                            @if ($deposit->status === 'pending')
                                <button type="button" class="btn btn-primary" onclick="accept()">
                                    Aprrove</button>
                            @endif
                            <a href="{{ route('finance.setoran.index') }}" class="btn btn-secondary ml-2">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalOmset" tabindex="-1" role="dialog" aria-labelledby="modalOmsetLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalOmsetLabel">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($transactionDetails as $item)
                            <li>({{ $item->qty }} Item) {{ $item->name }}
                                ({{ number_format($item->price, 0, ',', '.') }})
                                Total Harga: {{ number_format($item->qty * $item->price, 0, ',', '.') }}
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalJurnal" tabindex="-1" role="dialog" aria-labelledby="modalJurnalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalJurnalLabel">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        @foreach ($jurnalCash as $item)
                            <li>({{ $item->cost_name }})
                                ({{ number_format($item->debit, 0, ',', '.') }})
                            </li>
                        @endforeach
                    </ul>
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
                    text: "Mohon cek sebelum melakukan konfirmasi",
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
                            url: "{{ route('finance.setoran.update', $deposit->id) }}",
                            method: 'PUT',
                            data: {
                                _token: "{{ csrf_token() }}",
                                account_number: {{ $deposit->account_number }},
                            },
                            success: function(response) {
                                Swal.fire(
                                        'Berhasil!',
                                        'Setoran berhasil dikirim',
                                        'success'
                                    )
                                    .then((result) => {
                                        window.location.href =
                                            "{{ route('finance.setoran.index') }}";
                                    })
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Setoran Gagal Dikirim',
                                    'error'
                                )
                            }
                        })
                    }
                })
        }
    </script>
@endsection
