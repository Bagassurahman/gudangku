@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Hutang Piutang</h1>
            </div>

        </div>

        <div class="row row-xs clearfix">

            <!--================================-->
            <!-- Basic dataTable Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                
                <form action="{{ route('finance.hutang-piutang.index') }}" method="GET">
                    <div class="row align-items-center d-flex">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai:</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir">
                            </div>
                        </div>
                        <div class="col-md-2">

                            <button type="submit" class="btn btn-primary w-100 mt-2">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Data Hutang Piutang
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
                        <table class="table stripe hover bordered datatable datatable-Role">
                            <thead>
                                <tr>
                                    <th width="10"></th>
                                    <th>No</th>
                                    <th>Outlet</th>
                                    <th>Gudang</th>
                                    <th>Tanggal</th>
                                    <th>
                                        Total Hutang
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($debts as $debt)
                                    <tr>
                                        <td>

                                        </td>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $debt->outlet->outlet_name }}
                                        </td>
                                        <td>
                                            {{ $debt->warehouse->warehouse_name }}
                                        </td>
                                        <td>
                                            {{ $debt->date }}
                                        </td>
                                        <td>Rp {{ number_format($debt->amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($debt->status == 'pending')
                                                <span class="badge badge-danger">Belum Lunas</span>
                                            @endif
                                            @if ($debt->status == 'waiting')
                                                <span class="badge badge-warning">Menunggu Request</span>
                                            @endif
                                            @if ($debt->status == 'on_progres')
                                                <span class="badge badge-warning">Menunggu Aproval</span>
                                            @endif
                                            @if ($debt->status == 'success')
                                                <span class="badge badge-success">Lunas</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if ($debt->status == 'pending')
                                                <form action="{{ route('finance.hutang-piutang.update', $debt->id) }}"
                                                    method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">
                                                        Lunasi
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                             <tfoot>
                                <tr>
                                    <th colspan="1">Total Menunggu Aproval:</th>
                                   
                                    <th>Rp {{ number_format($wait, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            let table = $('.datatable-Role:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                responsive: false // Menambahkan opsi responsive
            })

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        })
    </script>
    {{-- <script>
        // Mendapatkan tanggal hari ini
        var today = new Date().toISOString().split('T')[0];

        // Mengatur nilai default tanggal mulai dan tanggal akhir ke hari ini
        document.getElementById('tanggal_mulai').value = today;
        document.getElementById('tanggal_akhir').value = today;
    </script> --}}
@endsection
