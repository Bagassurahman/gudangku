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
                <h1 class="pd-0 mg-0 tx-20 text-overflow">Distribusi Bahan</h1>
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
                            <label class="form-control-label active">Tanggal Distribusi<span
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
                            <label class="form-control-label active">Outlet<span class="tx-danger">*</span></label>
                            <select
                                class="form-control select @error('outlet_id')
                                            is-invalid
                                        @enderror"
                                name="outlet_id" id="outlet-id">
                                <option value="">Pilih Outlet</option>
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->user_id }}"
                                        {{ old('outlet_id') == $outlet->user_id ? 'selected' : '' }}>
                                        {{ $outlet->outlet_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mg-b-10-force">
                            <label class="form-control-label active">Pilih Bahan<span class="tx-danger">*</span></label>
                            <div class="row">
                                @foreach ($materials as $material)
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 mt-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between justify-between">
                                                    {{ $material->material->name }}
                                                    /
                                                    Stok: {{ $material->remaining_amount }}
                                                </div>
                                            </div>
                                            <div class="card-body mx-3 p-0">
                                                <div class="row">
                                                    <div class="col-9">
                                                        <input type="number" id="data-price-{{ $material->material->id }}"
                                                            name="data-price-{{ $material->material->id }}"
                                                            class="form-control mb-3" placeholder="Masukan Harga"
                                                            value="{{ $material->material->selling_price }}">
                                                    </div>
                                                    <div class="col-3">
                                                        <a href="#" data-id={{ $material->material->id }}
                                                            data-name="{{ $material->material->name }}" data-price="1.22"
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
                        <h5 class="modal-title" id="exampleModalLabel">Distribusi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('warehouse.distribusi.store') }}" method="POST" id="cart-form">
                        @csrf
                        <div class="modal-body">
                            <table class="show-cart table">

                            </table>
                            <div>Total Harga: Rp<span class="total-cart"></span></div>
                        </div>
                        <div class="modal-footer">
                            <button class="clear-cart btn btn-danger me-4" type="button">Kosongkan Keranjang</button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit" id="btn-submit">Distribusikan</button>
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

        var distributionCart = (function() {
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
                sessionStorage.setItem('distributionCart', JSON.stringify(cart));
            }

            // Load cart
            function loadCart() {
                cart = JSON.parse(sessionStorage.getItem('distributionCart'));
            }
            if (sessionStorage.getItem("distributionCart") != null) {
                loadCart();
            }


            // =============================
            // Public methods and propeties
            // =============================
            var obj = {};

            // Add to cart
            obj.addItemToCart = function(id, name, price, count) {
                for (var i in cart) {
                    if (cart[i].id === id) {
                        cart[i].count++;
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
                return Number(totalCart.toFixed(0));
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
            btn.addEventListener('click', async function(event) {
                event.preventDefault();
                const id = parseInt(this.getAttribute('data-id'));
                const name = this.getAttribute('data-name');
                const priceInput = document.querySelector(`#data-price-${id}`);
                const price = parseFloat(priceInput?.value);

                const stock = checkStock(id);

                if (stock <= 0) {
                    alert('Stok tidak mencukupi');
                    return;
                }

                // await reduceStock(id);

                distributionCart.addItemToCart(id, name, price, 1);
                displayCart();

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


        function checkStock(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: '/gudang/check-stock',
                    data: {
                        material_id: id
                    },
                    success: function(data) {
                        resolve(data);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }



        function reduceStock(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: '/gudang/reduce-stock',
                    data: {
                        material_id: id
                    },
                    success: function(data) {
                        resolve(data);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }

        function increaseStock(id) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: '/gudang/increase-stock',
                    data: {
                        material_id: id
                    },
                    success: function(data) {
                        resolve(data);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }


        // Clear items
        $('.clear-cart').click(function() {
            const cart = distributionCart.listCart();

            // cart.forEach(async item => {
            //     for (let i = 0; i < item.count; i++) {
            //         await increaseStock(item.id);
            //     }
            // });

            distributionCart.clearCart();

            displayCart();
        });



        function displayCart() {
            var cartArray = distributionCart.listCart();
            var output = "";
            for (var i in cartArray) {
               output += "<tr>" +
    "<td colspan='5'>" +
    "<div class='card'>" +
    "<div class='card-body'>" +
    "<div class='d-flex justify-content-between align-items-center'>" +
    "<span>" + cartArray[i].name + "</span>" +
    "<span>(" + cartArray[i].price + ")</span>" +
    "</div>" +
    "</div>" +
    "<div class='card-footer'>" +
    "<div class='row'>" +
    "<div class='col-3'>" +
    "<button type='button' class='minus-item btn btn-primary' data-id=" + cartArray[i].id +
    " data-count=" + cartArray[i].count + ">-</button>" +
    "</div>" +
    "<div class='col-4'>" +
    "<input type='number' class='item-count form-control' data-id='" +
    cartArray[i].id + "' value='" + cartArray[i].count + "'>" +
    "</div>" +
    "<div class='col-3'>" +
    "<button type='button' class='plus-item btn btn-primary' data-id=" + cartArray[i].id +
    " data-count=" + cartArray[i].count + ">+</button>" +
    "</div>" +
    "<div class='col-2'>" +
    "<button type='button' class='delete-item btn btn-danger' data-id=" + cartArray[i].id +
    " data-count=" + cartArray[i].count + ">X</button>" +
    "</div>" +
    "<div class='col'>" + cartArray[i].total + "</div>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "</td>" +
    "</tr>";


            }


            $('.show-cart').html(output);
            $('.total-cart').html(distributionCart.totalCart());
            $('.total-count').html(distributionCart.totalCount());
            if (cartArray.length == 0) {
                $('#btn-submit').hide();
            } else {
                $('#btn-submit').show();
            }
        }


        $('.show-cart').on("click", ".delete-item", function(event) {
            var id = parseInt($(this).data('id'));
            var count = $(this).data('count'); // Mengambil jumlah (count) dari atribut data pada elemen

            // for (let i = 0; i < count; i++) {
            //     increaseStock(id);
            // }

            distributionCart.removeItemFromCartAll(id);
            displayCart();
        });


        // -1
        $('.show-cart').on("click", ".minus-item", function(event) {
            var id = $(this).data('id');

            // increaseStock(id);

            distributionCart.removeItemFromCart(id);
            displayCart();
        })

        // +1
        $('.show-cart').on("click", ".plus-item", function(event) {
            var id = $(this).data('id');

            const stock = checkStock(id);

            if (stock <= 0) {
                alert('Stok tidak mencukupi');
                return;
            }

            // reduceStock(id);


            distributionCart.addItemToCart(id);
            displayCart();
        })

        // Item count input
        $('.show-cart').on("change", ".item-count", function(event) {
            var id = $(this).data('id');
            var count = Number($(this).val());
            distributionCart.setCountForItem(id, count);
            displayCart();
        });

        const cartForm = document.querySelector('#cart-form');
        const beliBtn = document.querySelector('#btn-submit');

        beliBtn.addEventListener('click', function() {
            // Ambil nilai input tanggal dan supplier
            const poDate = document.querySelector('#po-date').value;
            const outletId = document.querySelector('#outlet-id').value;

            // Validasi input tanggal dan outlet
            if (!poDate || !outletId) {
                event.preventDefault();
                alert('Harap masukkan tanggal dan pilih outlet');
                return;
            }

            const cartItems = distributionCart.listCart();
            const cartInput = document.createElement('input');
            cartInput.type = 'hidden';
            cartInput.name = 'cart_items';
            cartInput.value = JSON.stringify(cartItems);

            // Tambahkan input tanggal dan outlet ke dalam form
            const poDateInput = document.createElement('input');
            poDateInput.type = 'hidden';
            poDateInput.name = 'po_date';
            poDateInput.value = poDate;

            const outletIdInput = document.createElement('input');
            outletIdInput.type = 'hidden';
            outletIdInput.name = 'outlet_id';
            outletIdInput.value = outletId;

            cartForm.appendChild(cartInput);
            cartForm.appendChild(poDateInput);
            cartForm.appendChild(outletIdInput);
            cartForm.submit();

            distributionCart.clearCart();
        });





        displayCart();
    </script>
@endsection
