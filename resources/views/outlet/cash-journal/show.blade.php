@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-a5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Detail Jurnal {{ $journal->code }}</h1>
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
                            Detail Jurnal {{ $journal->code }}
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
                                    <th>Nama Biaya</th>
                                    <th>Catatan</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp



                                @foreach ($journal->detail as $key => $detail)
                                    <tr data-entry-id="{{ $detail->id }}">
                                        <td></td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $detail->cost->name }}</td>
                                        <td>
                                            {{ $detail->note ?? '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $formattedNominal = number_format($detail->debit, 0, ',', '.');
                                            @endphp
                                            Rp {{ $formattedNominal }}
                                            @php
                                                $total += $detail->debit;
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th>
                                        @php
                                            $formattedTotal = number_format($total, 0, ',', '.');
                                        @endphp
                                        Rp {{ $formattedTotal }}
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="5" class="text-right">
                                        <a href="{{ route('outlet.jurnal-kas.index') }}" class="btn btn-primary">Kembali</a>
                                    </th>
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
@endsection
