@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Penjualan Outlet All</h1>
            </div>
        </div>
        <div class="row row-xs clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <select id="outlet-select" class="form-control select" aria-label="Default select example">
                            <option selected disabled>Pilih Outlet</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->user_id }}">{{ $outlet->outlet_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-xs clearfix">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" id="transaction-card">
                        <table id="outlet-inventory-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Jumlah Transaksi</th>
                                    <th>Total Penghasilan</th>
                                    <th>Aksi</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table data will be fetched by AJAX request -->
                                <tr>
                                    <td colspan="4">Pilih outlet untuk melihat data penjualan</td>
                                </tr>


                            </tbody>
                            <tfoot class="bg-primary text-white"></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="transactionModalBody">
                    <!-- Konten Detail Transaksi akan ditampilkan di sini -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        var originalTable;
        // Function to fetch and update the table data
        // Function to fetch and update the table data
        function updateTableData(outletId) {
            // Make an AJAX request to the server to get the inventory data for the selected outlet
            console.log(outletId)
            $.ajax({
                url: '/api/outlet/' + outletId + '/sales', // Replace with your API endpoint
                method: 'GET',
                success: function(response) {
                    // Assuming the response is an array of inventory items
                    var inventoryItems = response;

                    // Clear the table body
                    $('#outlet-inventory-table tbody').empty();
                    $('#outlet-inventory-table tfoot').empty();


                    // Check if inventoryItems array is empty
                    if (inventoryItems.length === 0) {
                        // Display a row indicating empty inventory
                        var emptyRow = '<tr><td colspan="4">Belum ada penjualan</td></tr>';
                        $('#outlet-inventory-table tbody').append(emptyRow);
                    } else {
                        // Iterate over the inventory items and append rows to the table
                        // ...
                        var totalEarnings = 0;

                        inventoryItems.forEach(function(item) {
                            var row = '<tr>' +
                                '<td>' + item.month + '</td>' +
                                '<td>' + item.transaction_count + '</td>' +
                                '<td>' + formatRupiah(item.total_earnings) + '</td>' +
                                '<td><button class="btn btn-sm btn-primary" onclick="showTransactionDetails(' +
                                item.month_number + ')">Detail</button></td>' +
                                '</tr>';

                            totalEarnings += item.total_earnings; // Mengakumulasi total pendapatan

                            $('#outlet-inventory-table tbody').append(row);
                        });

                        // Tambahkan baris baru di elemen <tfoot> tabel
                        var footerRow = '<tr>' +
                            '<td colspan="2"><strong>Total:</strong></td>' +
                            '<td>' + formatRupiah(totalEarnings) + '</td>' +
                            '<td></td>' +
                            '</tr>';

                        $('#outlet-inventory-table tfoot').append(footerRow);
                        // ...


                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Handle error response
                }
            });
        }


        $(document).ready(function() {
            // Event listener for select element change
            $('#outlet-select').change(function() {
                var selectedOutletId = $(this).val();
                updateTableData(selectedOutletId);
            });
        });

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var hasil = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + hasil;
        }


        function showTransactionDetails(month) {
            // Simpan tampilan awal tabel penjualan

            // Lakukan permintaan AJAX ke API
            originalTable = $('#outlet-inventory-table').detach();

            // Lakukan permintaan AJAX ke API
            $.ajax({
                url: '/api/transaction/details?month=' + month, // Ubah URL sesuai dengan API yang Anda gunakan
                type: 'GET',
                success: function(response) {
                    // Buat tabel untuk menampilkan detail transaksi
                    var table = '<table class="table table-striped">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Order Number</th>' +
                        '<th>Tanggal Transaksi</th>' +
                        '<th>Produk</th>' +
                        '<th>Harga</th>' +
                        '<th>Jumlah</th>' +
                        '<th>Total</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    // Variabel untuk menyimpan nomor pesanan sebelumnya
                    var previousOrderNumber = '';

                    // Tambahkan baris tabel untuk setiap detail transaksi
                    response.forEach(function(detail) {
                        // Jika nomor pesanan sama dengan nomor pesanan sebelumnya, tambahkan jumlah dan total ke baris sebelumnya
                        if (detail.order_number === previousOrderNumber) {
                            // Ambil indeks baris terakhir
                            var lastIndex = table.lastIndexOf('<tr>');
                            // Hapus tag penutup baris terakhir
                            table = table.substring(0, lastIndex);
                            // Tambahkan jumlah dan total ke baris terakhir
                            table += '<td></td>' +
                                '<td></td>' +
                                '<td>' + detail.name + '</td>' +
                                '<td>' + formatRupiah(detail.price) + '</td>' +
                                '<td>' + detail.qty + '</td>' +
                                '<td>' + formatRupiah(detail.total) + '</td>' +
                                '</tr>';
                        } else {
                            // Tambahkan baris baru untuk nomor pesanan yang berbeda
                            table += '<tr>' +
                                '<td>' + detail.order_number + '</td>' +
                                '<td>' + detail.order_date + '</td>' +
                                '<td>' + detail.name + '</td>' +
                                '<td>' + formatRupiah(detail.price) + '</td>' +
                                '<td>' + detail.qty + '</td>' +
                                '<td>' + formatRupiah(detail.total) + '</td>' +
                                '</tr>';
                        }


                        // Simpan nomor pesanan saat ini untuk digunakan pada iterasi berikutnya
                        previousOrderNumber = detail.order_number;
                    });

                    table += '</tbody>' +
                        '</table>';

                    // Tambahkan tombol "Kembali" di bawah tabel detail transaksi
                    var backButton =
                        '<div class="text-center mt-4"><button class="btn btn-sm btn-primary" onclick="showOriginalTable()">Kembali</button></div>';
                    $('#transaction-card').html(table + backButton);
                },
                error: function(xhr) {
                    // Tangani kesalahan jika terjadi
                    console.log(xhr.responseText);
                }
            });
        }

        function showOriginalTable() {
            // Ganti konten card dengan tampilan awal tabel penjualan
            $('#transaction-card').html(originalTable);
        }
    </script>
@endsection
