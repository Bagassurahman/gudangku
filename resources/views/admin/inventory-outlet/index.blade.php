@extends('layouts.admin-new')
@section('style')
    <link type="text/css" rel="stylesheet"
        href="{{ asset('assets/plugins/datatables/extensions/dataTables.jqueryui.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Persediaan Outlet All</h1>
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
                                    <th>Nama Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Function to fetch and update the table data
        // Function to fetch and update the table data
        function updateTableData(outletId) {
            // Make an AJAX request to the server to get the inventory data for the selected outlet
            $.ajax({
                url: '/api/outlet/' + outletId + '/inventory', // Replace with your API endpoint
                method: 'GET',
                success: function(response) {
                    // Assuming the response is an array of inventory items
                    var inventoryItems = response;

                    inventoryItems.sort(function(a, b) {
                        var nameA = a.material.name.toUpperCase();
                        var nameB = b.material.name.toUpperCase();
                        if (nameA < nameB) {
                            return -1;
                        }
                        if (nameA > nameB) {
                            return 1;
                        }
                        return 0;
                    });

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
                            var row = '<tr data-inventory-id="' + item.id + '">' +
                                '<td>' + item.material.name + '</td>' +
                                '<td>' + item.remaining_amount + ' ' + item.material.unit.outlet_unit +
                                '</td>' +
                                '<td><button class="edit-button btn btn-primary" data-inventory-id="' +
                                item.id +
                                '" data-remaining-amount="' + item.remaining_amount +
                                '" data-material-unit="' + item.material.unit.outlet_unit +
                                '">Edit</button></td>' +
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

        $(document).on('click', '.edit-button', function() {
            var remainingAmount = $(this).data('remaining-amount');
            var materialUnit = $(this).data('material-unit');

            var inventoryId = $(this).data('inventory-id');

            Swal.fire({
                title: 'Edit',
                html: '<input class="form-control" type="number" id="edit-remaining-amount" value="' +
                    remainingAmount + '">',
                showCancelButton: true,
                confirmButtonText: 'Save',
                preConfirm: function() {
                    var editedRemainingAmount = $('#edit-remaining-amount').val();


                    // Jika editedRemainingAmount belum diisi, hentikan permintaan Ajax
                    if (!editedRemainingAmount) {
                        return false;
                    }

                    // Lakukan operasi penyimpanan/edit sesuai kebutuhan Anda menggunakan nilai editedRemainingAmount

                    // Contoh penggunaan Ajax untuk mengirim permintaan penyimpanan/edit ke server
                    $.ajax({
                        url: '{{ route('admin.update-persediaan') }}',
                        method: 'POST',
                        data: {
                            inventory_id: inventoryId, // Menggunakan inventoryId yang diperoleh dari tombol edit yang diklik
                            remainingAmount: editedRemainingAmount
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {

                            $('#outlet-inventory-table tbody tr[data-inventory-id="' +
                                inventoryId + '"] td:nth-child(2)').html(
                                editedRemainingAmount + ' ' + materialUnit);

                            $('#outlet-inventory-table tbody tr[data-inventory-id="' +
                                    inventoryId + '"] .edit-button')
                                .attr('data-remaining-amount', editedRemainingAmount)
                                .attr('data-material-unit', materialUnit);

                            Swal.fire({
                                title: 'Success',
                                text: 'Data berhasil diubah',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(response) {

                        }
                    });


                }


            });

            // Contoh penggunaan Bootstrap Modal untuk menampilkan modal dengan formulir
            // $('#edit-modal').modal('show');
            // $('#remaining-amount-input').val(remainingAmount);
            // ...
        });
    </script>
@endsection
