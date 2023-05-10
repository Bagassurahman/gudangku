@extends('layouts.admin-new')
@section('content')
    <div id="main-wrapper">
        @can('dashboard_admin_access')
            <div class="pageheader pd-t-25 pd-b-35">
                <div class="pd-t-5 pd-b-5">
                    <h1 class="pd-0 mg-0 tx-20">Dashboard</h1>
                </div>

            </div>
            <div class="row row-xs clearfix">
                <div class="col-lg-12 col-xl-12 col-12">
                    <div class="card mg-b-20">
                        <div class="card-header">
                            <h4 class="card-header-title">
                                Audience Metrics
                            </h4>
                            <div class="card-header-btn">
                                <a href="" data-toggle="collapse" class="btn card-collapse"
                                    data-target="#audienceMetrics" aria-expanded="true"><i class="ion-ios-arrow-down"></i></a>
                                <a href="" data-toggle="refresh" class="btn card-refresh"><i
                                        class="ion-android-refresh"></i></a>
                                <a href="" data-toggle="expand" class="btn card-expand"><i
                                        class="ion-android-expand"></i></a>
                                <a href="" data-toggle="remove" class="btn card-remove"><i
                                        class="ion-android-close"></i></a>
                            </div>
                        </div>
                        <div class="collapse show" id="audienceMetrics">
                            <div class="card-body pd-t-0 pd-b-20">

                                <div class="d-block clearfix">
                                    <div id="audienceOverviewBar" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        @endcan
        @can('dashboard_outlet_access')
            <div class="pageheader pd-t-25 pd-b-35">
                <div class="pd-t-5 pd-b-5">
                    <h1 class="pd-0 mg-0 tx-20">Menu Zam-Zam Time</h1>

                </div>
                <label class="form-label mt-3">Pilih Jenis Customer</label>
                <select id="tipe_harga" class="tipe-harga-select custom-select">
                    <option value="umum">Umum</option>
                    <option value="member">Member</option>
                    <option value="online">Online</option>
                </select>

            </div>
            <div class="row justify-content-between">
                <div class="col-xl-7">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-xl-4">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p>Rp <span class="harga-produk" data-harga-umum="{{ $product->general_price }}"
                                                data-harga-member="{{ $product->member_price }}"
                                                data-harga-online="{{ $product->online_price }}">
                                                {{ number_format($product->general_price, 0, ',', '.') }}
                                            </span>
                                        </p>

                                        <a href="#" class="add-to-cart btn btn-primary w-100"
                                            data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                            data-harga-umum="{{ $product->general_price }}"
                                            data-harga-member="{{ $product->member_price }}"
                                            data-harga-online="{{ $product->online_price }}"
                                            data-price="{{ $product->general_price }}" data-tipe-harga="umum">Tambahkan
                                            ke Keranjang</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-5">

                    <div class="card p-2">
                        <form action="{{ route('outlet.transaction.store') }}" method="POST" id="cart-form">
                            @csrf
                            <table class="show-cart table">

                            </table>
                            <h6>Total Harga: <span class="total-cart"></span></h6>
                            <input type="number" class="form-control mt-3" name="total_price" id="total-price" value=""
                                hidden>
                            <input type="number" class="form-control mt-3" name="paid_amount" placeholder="Jumlah Bayar"
                                id="paid_amount">
                            <h6 class="mt-3">Kembalian: <span class="total-change"></span></h6>
                            <button class="btn btn-primary mt-3 w-100" type="submit" id="btn-submit">Beli</button>

                        </form>
                        {{-- <button class="clear-cart btn btn-danger mt-3 w-100">Clear Cart</button> --}}

                    </div>
                </div>
            </div>
        @endcan
        @can('dashboard_warehouse_access')
            <!--================================-->
            <!-- Breadcrumb Start -->
            <!--================================-->
            <div class="pageheader pd-t-25 pd-b-35">
                <div class="pd-t-5 pd-b-5">
                    <h1 class="pd-0 mg-0 tx-20">Rekap Bulan
                        {{ date('F') }} {{ date('Y') }}
                    </h1>
                </div>

            </div>
            <!--/ Breadcrumb End -->

            <div class="row row-xs clearfix">
                <div class="col-sm-6 col-xl-3">
                    <div class="card mg-b-20">
                        <div class="card-body pd-y-0">
                            <div class="custom-fieldset mb-4">
                                <div class="clearfix">
                                    <label>Total Omset</label>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div
                                        class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-warning">
                                        <i class="icon-screen-desktop tx-warning tx-20"></i>
                                    </div>
                                    <div>
                                        <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                            Rp 30.000</h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card mg-b-20">
                        <div class="card-body pd-y-0">
                            <div class="custom-fieldset mb-4">
                                <div class="clearfix">
                                    <label>Total Biaya-Biaya</label>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div
                                        class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-success">
                                        <i class="icon-diamond tx-success tx-20"></i>
                                    </div>
                                    <div>
                                        <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                            Rp0
                                        </h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card mg-b-20">
                        <div class="card-body pd-y-0">
                            <div class="custom-fieldset mb-4">
                                <div class="clearfix">
                                    <label>Total Pembelian</label>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div
                                        class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-primary">
                                        <i class="icon-handbag tx-primary tx-20"></i>
                                    </div>
                                    <div>
                                        <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                            Rp {{ number_format($totalPembelianPerBulan[0]->total_pembelian, 0, ',', '.') }}
                                        </h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card mg-b-20">
                        <div class="card-body pd-y-0">
                            <div class="custom-fieldset mb-4">
                                <div class="clearfix">
                                    <label>Total Margin</label>
                                </div>
                                <div class="d-flex align-items-center text-dark">
                                    <div
                                        class="wd-40 wd-md-50 ht-40 ht-md-50 mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded card-icon-danger">
                                        <i class="icon-speedometer tx-danger tx-20"></i>
                                    </div>
                                    <div>
                                        <h2 class="tx-20 tx-sm-18 tx-md-24 mb-0 mt-2 mt-sm-0 tx-normal tx-rubik tx-dark">
                                            Rp 9,900
                                        </h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-12">
                    <div class="card mg-b-20">
                        <div class="card-header">
                            <h4 class="card-header-title">
                                Data Persediaan
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
                                        <th width="10">

                                        </th>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Nama Bahan
                                        </th>
                                        <th>
                                            Jumlah Masuk
                                        </th>
                                        <th>
                                            Jumlah Keluar
                                        </th>
                                        <th>
                                            Jumlah Sisa
                                        </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventories as $key => $inventory)
                                        <tr data-entry-id="{{ $inventory->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $inventory->name ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($inventory->inventories as $inv)
                                                    {{ $inv->entry_amount ?? '0' }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($inventory->inventories as $inv)
                                                    {{ $inv->exit_amount ?? '0' }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($inventory->inventories as $inv)
                                                    {{ $inv->remaining_amount ?? '0' }}
                                                @endforeach
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('warehouse.persediaan.index') }}" class="btn btn-primary">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        // hide btn-submit
        $('#btn-submit').hide();
        $('#paid_amount').on('keyup', function() {
            var total = parseInt($('#total-price').val()) ||
                0; // menggunakan parseInt untuk mengambil nilai integer dari input
            var paid = parseInt($(this).val()) || 0;
            var due = paid - total;
            $('.total-change').html(due.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }));
            if (due > 0) {
                $('#btn-submit').show();
            } else {
                $('#btn-submit').hide();
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // Simpan elemen DOM dalam variabel lokal
            var $hargaProduk = $('.harga-produk');
            var $addToCart = $('.add-to-cart');

            $('.tipe-harga-select').on('change', function() {
                var tipeHarga = $(this).val();

                // Loop melalui elemen harga produk dan ubah konten
                $hargaProduk.each(function() {
                    var harga = $(this).data('harga-' + tipeHarga);
                    $(this).html(harga);
                });

                // Loop melalui elemen tambah ke keranjang dan ubah atribut data-price
                $addToCart.each(function() {
                    var harga = $(this).data('harga-' + tipeHarga);
                    $(this).attr('data-price', harga);
                });
            });
        });
    </script>
    <script>
        var shoppingCart = (function() {
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
                sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
            }

            // Load cart
            function loadCart() {
                cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
            }
            if (sessionStorage.getItem("shoppingCart") != null) {
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
            }
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
                var removedItemIndex;

                cart.forEach(function(item, index) {
                    if (item.id === id) {
                        removedItemIndex = index;

                        $.get('outlet/detail-produk', {
                            id: id
                        }, function(materials) {
                            materials.forEach(function(material) {
                                var materialId = material.material_id;
                                var dose = material.dose * item.count;

                                increaseProductStockByMaterial(materialId, dose);
                            });
                        });
                    }
                });

                if (removedItemIndex !== undefined) {
                    cart.splice(removedItemIndex, 1);
                    saveCart();
                }
            };


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
                return Number(totalCart);
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
                    itemCopy.total = Number(item.price * item.count);
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

        $('.add-to-cart').click(function(event) {
            event.preventDefault();
            var id = $(this).data('id');
            var name = $(this).data('name')
            var price = Number($(this).data('price'));

            // melakukan request AJAX untuk mendapatkan informasi bahan dan dosis
            $.get('outlet/detail-produk', {
                id: id
            }).then(async function(materials) {
                // memeriksa apakah persediaan cukup untuk setiap bahan pada produk
                var allMaterialsAvailable = true;
                for (var i = 0; i < materials.length; i++) {
                    var material = materials[i];
                    var availableStock = await getProductStockByMaterial(material.material_id);

                    if (availableStock < material.dose) {
                        // alert se
                        alert('Persediaan ' + material.material_name + ' tidak cukup!')
                        allMaterialsAvailable = false;
                        break;
                    }
                }

                // jika persediaan cukup, tambahkan produk ke dalam keranjang
                if (allMaterialsAvailable) {
                    shoppingCart.addItemToCart(id, name, price, 1);
                    for (var i = 0; i < materials.length; i++) {
                        var material = materials[i];
                        reduceProductStockByMaterial(material.material_id, material.dose);
                    }
                    displayCart();
                }
            });
        });


        function getProductStockByMaterial(materialId) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: 'outlet/stok-produk',
                    data: {
                        material_id: materialId
                    },
                    success: function(data) {
                        resolve(data)
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }



        function reduceProductStockByMaterial(materialId, dose) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: 'outlet/decrease-stok-produk',
                    data: {
                        material_id: materialId,
                        dose: dose
                    },
                    success: function(data) {
                        resolve(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        reject(errorThrown);
                    }
                });
            });
        }

        function increaseProductStockByMaterial(materialId, dose) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: 'outlet/increase-stok-produk',
                    async: false,
                    data: {
                        material_id: materialId,
                        dose: dose
                    },
                    success: function(data) {
                        resolve(data);
                    },
                    error: function(error) {
                        reject(error);
                    }
                });
            });
        }



        function displayCart() {
            var cartArray = shoppingCart.listCart();
            var output = "";
            for (var i in cartArray) {
                output += "<tr>" +
                    "<td>" + cartArray[i].name + "</td>" +
                    "<td>(" + cartArray[i].price + ")</td>" +
                    "<td><div class='input-group'><button class='minus-item input-group-addon btn btn-primary' data-id=" +
                    cartArray[i].id + " type='button'>-</button>" +
                    "<input type='number' class='item-count form-control' data-id='" + cartArray[i].name +
                    "' value='" +
                    cartArray[i].count + "'>" +
                    "<button class='plus-item btn btn-primary input-group-addon' data-id=" + cartArray[i].id +
                    " type='button'>+</button></div></td>" +
                    "<td><button class='delete-item btn btn-danger' data-id=" + cartArray[i].id +
                    " >X</button></td>" +
                    " = " +
                    "<td>" + cartArray[i].total + "</td>" +
                    "</tr>";
            }
            $('.show-cart').html(output);
            $('.total-cart').html(shoppingCart.totalCart().toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }));
            $('#total-price').val(shoppingCart.totalCart());
            $('#total-price').attr('value', shoppingCart.totalCart());
            $('.total-count').html(shoppingCart.totalCount());
        }

        // $('.clear-cart').click(function() {
        //     for (var i = 0; i < cart.length; i++) {
        //         var item = cart[i];
        //         var id = item.id;
        //         var materials = [];
        //         $.ajax({
        //             url: 'outlet/detail-produk',
        //             data: {
        //                 id: id
        //             },
        //             async: false,
        //             success: function(materials) {
        //                 for (var j = 0; j < cart.length; j++) {
        //                     if (cart[j].id === id) {
        //                         var count = cart[j].count;
        //                         for (var k = 0; k < materials.length; k++) {
        //                             var material = materials[k];
        //                             var materialId = material.material_id;
        //                             var dose = material.dose;
        //                             increaseProductStockByMaterial(materialId, dose);
        //                         }
        //                         break;
        //                     }
        //                 }
        //             }
        //         });
        //     }

        //     setTimeout(function() {
        //         shoppingCart.clearCart();
        //         displayCart();
        //     }, 1000);
        // });


        $('.show-cart').on("click", ".delete-item", function(event) {
            event.preventDefault();
            var id = $(this).data('id');

            shoppingCart.removeItemFromCartAll(id);

            displayCart();

        })


        $('.show-cart').on("click", ".minus-item", function(event) {
            var id = $(this).data('id');

            // membuat array promise untuk setiap bahan pada produk
            var promises = [];

            $.get('outlet/detail-produk', {
                id: id
            }, function(materials) {
                for (var i = 0; i < materials.length; i++) {
                    var material = materials[i];
                    var materialId = material.material_id;
                    var dose = material.dose;

                    // menambahkan promise untuk setiap bahan pada produk
                    promises.push(increaseProductStockByMaterial(materialId, dose));
                }
            });

            // menunggu semua promise selesai
            Promise.all(promises).then(function() {
                shoppingCart.removeItemFromCart(id);
                displayCart();
            }).catch(function(error) {
                console.log(error);
            });
        });


        $('.show-cart').on("click", ".plus-item", function(event) {
            var id = $(this).data('id');

            $.get('outlet/detail-produk', {
                    id: id
                })
                .then(function(materials) {
                    var allMaterialsAvailable = true;

                    // memeriksa apakah persediaan cukup untuk setiap bahan pada produk
                    var promises = materials.map(function(material) {
                        var materialId = material.material_id;
                        var dose = material.dose;

                        return getProductStockByMaterial(materialId)
                            .then(function(availableStock) {
                                if (availableStock < dose) {
                                    allMaterialsAvailable = false;
                                    alert('Persediaan bahan ' + material.material_name +
                                        ' tidak cukup!');
                                    throw new Error('Material ' + material.material_name +
                                        ' tidak cukup');
                                }
                            });
                    });

                    // jika persediaan cukup, tambahkan produk ke dalam keranjang
                    Promise.all(promises).then(function() {
                        if (allMaterialsAvailable) {
                            shoppingCart.addItemToCart(id);

                            materials.forEach(function(material) {
                                var materialId = material.material_id;
                                var dose = material.dose;

                                reduceProductStockByMaterial(materialId, dose);
                            });

                            displayCart();
                        }
                    }).catch(function(error) {
                        console.error(error);
                    });
                });
        });


        const cartForm = document.querySelector('#cart-form');
        const beliBtn = document.querySelector('#btn-submit');

        beliBtn.addEventListener('click', function() {

            const cartItems = shoppingCart.listCart();
            const cartInput = document.createElement('input');
            cartInput.type = 'hidden';
            cartInput.name = 'cart_items';
            cartInput.value = JSON.stringify(cartItems);


            cartForm.appendChild(cartInput);
            cartForm.submit();


            shoppingCart.clearCart();
        });

        displayCart();
    </script>
@endsection
