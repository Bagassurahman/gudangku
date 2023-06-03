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
                    <div class="card-body">
                        <table id="outlet-inventory-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Detail Transaksi</th>

                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be dynamically populated -->
                            </tbody>
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
        // Function to fetch and update the table data
        // Function to fetch and update the table data
        function updateTableData(outletId) {
            // Make an AJAX request to the server to get the inventory data for the selected outlet
            $.ajax({
                url: '/api/outlet/' + outletId + '/sales', // Replace with your API endpoint
                method: 'GET',
                success: function(response) {
                    // Assuming the response is an array of inventory items
                    var inventoryItems = response;

                    // Clear the table body
                    $('#outlet-inventory-table tbody').empty();

                    // Check if inventoryItems array is empty
                    if (inventoryItems.length === 0) {
                        // Display a row indicating empty inventory
                        var emptyRow = '<tr><td colspan="3">No inventory data available</td></tr>';
                        $('#outlet-inventory-table tbody').append(emptyRow);
                    } else {
                        // Iterate over the inventory items and append rows to the table
                        inventoryItems.forEach(function(item) {
                            var orderDate = item.order_date;
                            var transactionDetails = item.transaction_details;

                            // Create a row for each order
                            var row = '<tr>' +
                                '<td>' + orderDate + '</td>' +
                                '<td>';

                            // Iterate through transaction details and add them to the row
                            transactionDetails.forEach(function(detail) {
                                var productName = detail.product.name;
                                var qty = detail.qty;
                                var price = detail.price.toLocaleString('id-ID');
                                var total = detail.total.toLocaleString('id-ID');

                                row += 'Product: ' + productName + '<br>' +
                                    'Quantity: ' + qty + '<br>' +
                                    'Price: ' + price + ' IDR<br>' +
                                    'Total: ' + total + ' IDR<br><br>';
                            });

                            row += '</td>' +
                                '</tr>';

                            $('#outlet-inventory-table tbody').append(row);
                        });


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
    </script>
@endsection
