@extends('layouts.admin-new')
@section('style')
    <style>
        .btn-cart {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 999;
            width: 50px;
            height: 50px;
            background-color: #5d78ff;
            border: none;
            color: white;
            border-radius: 50%;
        }


        @media (max-width: 768px) {
            .btn-cart-mobile {
                position: fixed;
                bottom: 20px;
                z-index: 999;
                width: 90% !important;
                height: 50px;
                background-color: #5d78ff;
                border: none;
                color: white;
                border-radius: 20px;
            }
        }

        .btn .badge {
            position: relative;
            top: -1px;
            right: 0px;
        }

        .row-bg:nth-child(even) {
            background-color: #f2f2f2;
            /* Replace with your desired background color for even rows */
        }

        .row-bg:nth-child(odd) {
            background-color: #ffffff;
            /* Replace with your desired background color for odd rows */
        }
    </style>
    @can('dashboard_outlet_access')
        <style>
            .card-product .card-img-top {
                object-fit: cover;
                border-radius: 13px;
            }

            .card-product .card-body {
                padding: 0px;
                margin-top: 12px
            }

            .card-product .card-body .btn.btn-primary {
                border-radius: 20px;
                background-color: transparent;
                color: #5d78ff
            }

            .modal-mobile {
                height: 100vh !important;
            }

            .collapsing {
                position: fixed;
                bottom: 55px;
                height: 0px !important;
                width: 90% !important;
                overflow: hidden;
                transition: height .35s ease
            }

            @media (max-width: 575.98px) {
                .collapse {
                    position: fixed;
                    bottom: 55px;
                    width: 90% !important;
                    z-index: 999 !important;
                }
            }

            .collapse.show {
                height: fit-content
            }

            /* #outlet-pos-mobile .input-group{
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        flex-wrap: nowrap
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */
        </style>
    @endcan
@endsection
@section('content')
    <div id="main-wrapper">
        @can('dashboard_admin_access')
            @include('admin.dashboard')
        @endcan
        @can('dashboard_outlet_access')
            @include('outlet.dashboard')
        @endcan
        @can('dashboard_warehouse_access')
            @include('warehouse.dashboard')
        @endcan
        @can('dashboard_finance_access')
            @include('finance.dashboard')
        @endcan
    </div>
@endsection
@section('scripts')
    @parent
    @can('dashboard_outlet_access')
        @if ($isMobile === true)
            <script src="{{ asset('assets/js/post-script-mobile.js') }}"></script>
        @else
            <script src="{{ asset('assets/js/pos-script.js') }}"></script>
        @endif
    @endcan



    @can('dashboard_admin_access')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            var options = {
                chart: {
                    type: 'donut',
                    width: 500, // Atur lebar chart (dalam piksel)
                    height: 300, // Atur tinggi chart (dalam piksel)
                },
                series: @json($dataPt),
                labels: @json($labelsPt),
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' Penjualan';
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-product"), options);

            chart.render();
        </script>
        <script>
            var options = {
                chart: {
                    type: 'donut',
                    width: 500, // Atur lebar chart (dalam piksel)
                    height: 300, // Atur tinggi chart (dalam piksel)
                },
                series: @json($dataOt),
                labels: @json($labelsOt),
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' Penjualan';
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-outlet"), options);

            chart.render();
        </script>
        <script>
            var options = {
                series: [{
                    name: "Penjualan",
                    data: [
                        @foreach ($penjualanPerBulan as $penjualan)
                            {{ $penjualan->total_penjualan }},
                        @endforeach
                    ]
                }],

                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: 'Data penjualan per bulan',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [
                        @foreach ($penjualanPerBulan as $penjualan)
                            '{{ date('M', mktime(0, 0, 0, $penjualan->month, 1)) }}',
                        @endforeach
                    ],
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-penjualan"), options);
            chart.render();
        </script>
        <script>
            var options = {
                series: [{
                    name: 'Kekayaan',
                    data: @json($series)
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: @json($categories)
                },
                yaxis: {
                    title: {
                        text: 'Rp'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "Rp " + val.toLocaleString('id-ID');
                        }

                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-kekayaan"), options);
            chart.render();
        </script>
    @endcan
@endsection
