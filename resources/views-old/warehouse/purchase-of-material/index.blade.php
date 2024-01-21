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

        .btn .badge {
            position: relative;
            top: -1px;
            right: 0px;
        }
    </style>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
    <div id="main-wrapper">
        <button type="button" class="btn btn-primary btn-cart" data-toggle="modal" data-target="#cart" type="button">
            <span class="total-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
            <i class="fa fa-shopping-cart"></i>
        </button>
        <div class="pageheader pd-t-25 pd-b-35">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Pembelian Bahan</h1>
            </div>

        </div>
        <div class="row row-xs clearfix">
            <!--================================-->
            <!-- Top Label Layout Start -->
            <!--================================-->
            <div class="col-md-12 col-lg-12">
                <div class="card mg-b-20">
                    <div class="card-header">
                        <h4 class="card-header-title">
                            Pembelian Bahan
                        </h4>
                        <div class="card-header-btn">
                            <a href="" data-toggle="collapse" class="btn card-collapse" data-target="#collapse1"
                                aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                            <a href="" data-toggle="refresh" class="btn card-refresh"><i
                                    class="ion-android-refresh"></i></a>
                            <a href="" data-toggle="expand" class="btn card-expand"><i
                                    class="ion-android-expand"></i></a>
                            <a href="" data-toggle="remove" class="btn card-remove"><i
                                    class="ion-android-close"></i></a>
                        </div>
                    </div>
                    <div class="card-body collapse show" id="collapse1">


                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label active">Tanggal Pembeliam<span
                                    class="tx-danger">*</span></label>
                            <input
                                class="form-control @error('po_date')
                                            is-invalid
                                        @enderror"
                                type="date" name="po_date" value="{{ old('po_date', date('Y-m-d')) }}" id="po-date">
                            @error('po_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label active">Supplier<span class="tx-danger">*</span></label>
                            <select
                                class="form-control select @error('supplier_id')
                                            is-invalid
                                        @enderror"
                                name="supplier_id" id="supplier-id">
                                <option value="">Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label active">Pilih Bahan<span class="tx-danger">*</span></label>
                            <div class="row">
                                @foreach ($materials as $material)
                                         <div class="col-12 col-sm-12 col-md-4 col-lg-3 mt-lg-2 mt-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between">
                                                    {{ $material->name }}

                                                    Satuan: {{ $material->unit->warehouse_unit }}
                                                </div>
                                            </div>
                                            <div class="card-body mx-3 p-0">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <input type="number" id="data-price-{{ $material->id }}"
                                                            name="data-price-{{ $material->id }}" class="form-control mb-3"
                                                            placeholder="Harga Beli">
                                                    </div>
                                                    <div class="col-3">
                                                        <a href="#" data-id="{{ $material->id }}"
                                                            data-name="{{ $material->name }}" data-price="1.22"
                                                            class="add-to-cart btn btn-primary w-100">+</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- row -->
                        <div class="form-layout-footer mt-3">

                            <a href="{{ route('warehouse.persediaan.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                        <!-- form-layout-footer -->

                    </div>
                </div>
            </div>

        </div>
        <!-- Modal -->
        <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="exampleModalLabel">Keranjang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('warehouse.pembelian-bahan.store') }}" method="POST" id="cart-form">
                        @csrf
                        <div class="modal-body">
                            <table class="show-cart table">

                            </table>
                            <div>Total Harga:<span class="total-cart"></span></div>
                        </div>
                        <div class="modal-footer">
                            <button class="clear-cart btn btn-danger me-4" type="button">Kosongkan Keranjang</button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="btn-submit">Beli</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
        integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous">
    </script>
    <script>
        // ************************************************
        // Shopping Cart API
        // ************************************************

        var purchaseCart = (function() {
            // =============================
            // Private methods and propeties
            // =============================
            cart = [];

            // Constructor
            function Item(id, name, price, count) {
                this.id = id;
                this.name = name;
                this.price = price;
                this.count = count;
            }

            // Save cart
            function saveCart() {
                sessionStorage.setItem('purchaseCart', JSON.stringify(cart));
            }

            // Load cart
            function loadCart() {
                cart = JSON.parse(sessionStorage.getItem('purchaseCart'));
            }
            if (sessionStorage.getItem("purchaseCart") != null) {
                loadCart();
            }


            // =============================
            // Public methods and propeties
            // =============================
            var obj = {};

            // Add to cart
            obj.addItemToCart = function(id, name, price, count) {
                for (var item in cart) {

                    if (cart[item].id === id) {
                        cart[item].count++;
                        saveCart();
                        return;
                    }
                }
                var item = new Item(id, name, price, count);
                cart.push(item);
                saveCart();
            };

            // Set count from item
            obj.setCountForItem = function(id, count) {
                for (var i in cart) {
                    if (cart[i].id === id) {
                        cart[i].count = count;
                        break;
                    }
                }
            };
            // Remove item from cart
            obj.removeItemFromCart = function(id) {
                for (var item in cart) {
                    if (cart[item].id === id) {
                        cart[item].count--;
                        if (cart[item].count === 0) {
                            cart.splice(item, 1);
                        }
                        break;
                    }
                }
                saveCart();
            }

            // Remove all items from cart
            obj.removeItemFromCartAll = function(id) {
                for (var item in cart) {
                    if (cart[item].id === id) {
                        cart.splice(item, 1);
                        break;
                    }
                }
                saveCart();
            }

            // Clear cart
            obj.clearCart = function() {
                cart = [];
                saveCart();
            }

            // Count cart
            obj.totalCount = function() {
                var totalCount = 0;
                for (var item in cart) {
                    totalCount += cart[item].count;
                }
                return totalCount;
            }

            // Total cart
            obj.totalCart = function() {
                var totalCart = 0;
                for (var item in cart) {
                    totalCart += cart[item].price * cart[item].count;
                }
                return 'Rp ' + Number(totalCart).toLocaleString('id-ID');
            }


            // List cart
            obj.listCart = function() {
                var cartCopy = [];
                for (i in cart) {
                    item = cart[i];
                    itemCopy = {};
                    for (p in item) {
                        itemCopy[p] = item[p];

                    }
                    itemCopy.total = Number(item.price * item.count).toFixed(0);
                    cartCopy.push(itemCopy)
                }
                return cartCopy;
            }

            // cart : Array
            // Item : Object/Class
            // addItemToCart : Function
            // removeItemFromCart : Function
            // removeItemFromCartAll : Function
            // clearCart : Function
            // countCart : Function
            // totalCart : Function
            // listCart : Function
            // saveCart : Function
            // loadCart : Function
            return obj;
        })();


        // *****************************************
        // Triggers / Events
        // *****************************************
        // Add item
        const addBtns = document.querySelectorAll('.add-to-cart');
        addBtns.forEach(btn => {
            btn.addEventListener('click', function(event) {
                event.preventDefault();
                const id = parseInt(this.getAttribute('data-id'), 10);
                const name = this.getAttribute('data-name');
                const priceInput = document.querySelector(`#data-price-${id}`);
                const price = parseFloat(priceInput.value);
                if (isNaN(price) || price <= 0) {
                    alert('Masukan harga yang valid');
                    return;
                }
                this.setAttribute('data-price', price.toFixed(0));
                purchaseCart.addItemToCart(id, name, price, 1);
                displayCart();

                // Tampilkan toast SweetAlert dengan nama item
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Item ' + name + ' berhasil ditambahkan ke keranjang',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    toast: true,
                    timerProgressBar: true
                });
            });
        });




        // Clear items
        $('.clear-cart').click(function() {
            purchaseCart.clearCart();
            displayCart();
        });


        function displayCart() {
            var cartArray = purchaseCart.listCart();
            var output = "";
          for (var i in cartArray) {
    output += '<div class="card mb-3">' +
        '<div class="card-body">' +
        '<div class="row">' +
        '<div class="col">' +
        '<h6 class="card-title">' + cartArray[i].name + ' ' + cartArray[i].price + '</h6>' +
        '</div>' +
        '</div>' +
        '<div class="row">' +
        '<div class="col-9">' +
        '<div class="input-group">' +
        '<button type="button" class="minus-item input-group-addon btn btn-primary" data-id="' + cartArray[i].id + '" data-count="' + cartArray[i].count + '">-</button>' +
        '<input type="number" class="item-count form-control" data-id="' + cartArray[i].id + '" value="' + cartArray[i].count + '">' +
        '<button type="button" class="plus-item btn btn-primary input-group-addon" data-id="' + cartArray[i].id + '" data-count="' + cartArray[i].count + '">+</button>' +
        '</div>' +
        '</div>' +
        '<div class="col-3">' +
        '<button class="delete-item btn btn-danger" data-id="' + cartArray[i].id + '">X</button>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';
}

            $('.show-cart').html(output);
            $('.total-cart').html(purchaseCart.totalCart());
            $('.total-count').html(purchaseCart.totalCount());
            if (cartArray.length == 0) {
                $('#btn-submit').hide();
            } else {
                $('#btn-submit').show();
            }
        }

        // Delete item button

        $('.show-cart').on("click", ".delete-item", function(event) {
            var id = $(this).data('id')

            purchaseCart.removeItemFromCartAll(id);
            displayCart();
        })


        // -1
        $('.show-cart').on("click", ".minus-item", function(event) {
            var id = $(this).data('id')
            purchaseCart.removeItemFromCart(id);
            displayCart();
        })
        // +1
        $('.show-cart').on("click", ".plus-item", function(event) {
            var id = $(this).data('id')
            console.log(id)
            purchaseCart.addItemToCart(id);
            displayCart();
        })

        // Item count input
        $('.show-cart').on("keyup", ".item-count", function(event) {
            var id = $(this).data('id');
            var count = Number($(this).val());
            purchaseCart.setCountForItem(id, count);
            displayCart();
        });

        const cartForm = document.querySelector('#cart-form');
        const beliBtn = document.querySelector('#btn-submit');

        beliBtn.addEventListener('click', function() {
            // Ambil nilai input tanggal dan supplier
            const poDate = document.querySelector('#po-date').value;
            const supplierId = document.querySelector('#supplier-id').value;

            // Validasi input tanggal dan supplier
            if (!poDate || !supplierId) {
                event.preventDefault();
                alert('Harap masukkan tanggal dan pilih supplier');
                return;
            }

            const cartItems = purchaseCart.listCart();
            const cartInput = document.createElement('input');
            cartInput.type = 'hidden';
            cartInput.name = 'cart_items';
            cartInput.value = JSON.stringify(cartItems);

            // Tambahkan input tanggal dan supplier ke dalam form
            const poDateInput = document.createElement('input');
            poDateInput.type = 'hidden';
            poDateInput.name = 'po_date';
            poDateInput.value = poDate;

            const supplierIdInput = document.createElement('input');
            supplierIdInput.type = 'hidden';
            supplierIdInput.name = 'supplier_id';
            supplierIdInput.value = supplierId;

            cartForm.appendChild(cartInput);
            cartForm.appendChild(poDateInput);
            cartForm.appendChild(supplierIdInput);
            cartForm.submit();
        });


        displayCart();
    </script>
@endsection
