$('#paid_amount').on('keyup', function () {
    // Mengambil nilai total dan nilai yang dibayarkan dari input
    var total = parseInt($('#total-price').val()) || 0;
    var paid = parseInt($(this).val()) || 0;

    // Menghitung sisa pembayaran
    var due = paid - total;

    // Menampilkan sisa pembayaran dengan format mata uang
    $('.total-change').html(due.toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }));

    // Menampilkan atau menyembunyikan tombol submit berdasarkan sisa pembayaran
    if (due >= 0) {
        $('#btn-submit').show();
    } else {
        $('#btn-submit').hide();
    }
});




$(document).ready(function () {
    // Simpan elemen DOM dalam variabel lokal
    var $hargaProduk = $('.harga-produk');
    var $addToCart = $('.add-to-cart');

    $('.tipe-harga-select').on('change', function () {
        var tipeHarga = $(this).val();

        // Loop melalui elemen harga produk dan ubah konten
        $hargaProduk.each(function () {
            var harga = $(this).data('harga-' + tipeHarga);
            $(this).html(harga);
        });

        // Loop melalui elemen tambah ke keranjang dan ubah atribut data-price
        $addToCart.each(function () {
            var harga = $(this).data('harga-' + tipeHarga);
            $(this).attr('data-price', harga);
        });
    });
});


var shoppingCart = (function () {
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
    obj.addItemToCart = function (id, name, price, count) {
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
    obj.setCountForItem = function (id, count) {
        for (var i in cart) {
            if (cart[i].id === id) {
                cart[i].count = count;
                break;
            }
        }
    };
    // Remove item from cart
    obj.removeItemFromCart = function (id) {
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
    obj.removeItemFromCartAll = function (id) {
        var removedItemIndex;

        cart.forEach(function (item, index) {
            if (item.id === id) {
                removedItemIndex = index;

                $.get('outlet/detail-produk', {
                    id: id
                }, function (materials) {
                    materials.forEach(function (material) {
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
    obj.clearCart = function () {
        cart = [];
        saveCart();
    }

    // Count cart
    obj.totalCount = function () {
        var totalCount = 0;
        for (var item in cart) {
            totalCount += cart[item].count;
        }
        return totalCount;
    }

    // Total cart
    obj.totalCart = function () {
        var totalCart = 0;
        for (var item in cart) {
            totalCart += cart[item].price * cart[item].count;
        }
        return Number(totalCart);
    }

    // List cart
    obj.listCart = function () {
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

    return obj;
})();

$('.add-to-cart').click(function (event) {
    event.preventDefault();

    var addButton = $(this); // Store reference to 'this'

    var id = addButton.data('id');
    var name = addButton.data('name');
    var price = Number(addButton.data('price'));

    $.get('outlet/detail-produk', {
        id: id
    }).then(async function (materials) {
        var allMaterialsAvailable = true;
        for (var i = 0; i < materials.length; i++) {
            var material = materials[i];
            var availableStock = await getProductStockByMaterial(material.material_id);

            // Memeriksa ketersediaan stok material
            if (availableStock < material.dose) {
                alert('Persediaan ' + material.material_name + ' tidak cukup!');
                allMaterialsAvailable = false;
                break;
            }
        }

        if (allMaterialsAvailable) {
            shoppingCart.addItemToCart(id, name, price, 1);
            for (var i = 0; i < materials.length; i++) {
                var material = materials[i];
                reduceProductStockByMaterial(material.material_id, material.dose);
            }

            displayCart();

            addButton.replaceWith(
                "<div class='input-group'>" +
                "    <button class='minus-item input-group-addon btn btn-primary mr-2' data-id='" + id + "' type='button'>-</button>" +
                "    <input type='number' class='item-count form-control mx-2' data-id='" + name + "' value='1'>" +
                "    <button class='plus-item btn btn-primary ml-2' data-id='" + id + "' type='button'>+</button>" +
                "</div>"
            );


        }
    });
});

$(document).on("click", ".minus-item", function (event) {
    var id = $(this).data('id');

    // membuat array promise untuk setiap bahan pada produk
    var promises = [];

    $.get('outlet/detail-produk', {
        id: id
    }, function (materials) {
        for (var i = 0; i < materials.length; i++) {
            var material = materials[i];
            var materialId = material.material_id;
            var dose = material.dose;

            // menambahkan promise untuk setiap bahan pada produk
            promises.push(increaseProductStockByMaterial(materialId, dose));
        }
    });

    // menunggu semua promise selesai
    Promise.all(promises).then(function () {
        shoppingCart.removeItemFromCart(id);
        displayCart();

        $(this).replaceWith(
            "<div class='input-group'>" +
            "<button class='add-to-cart btn btn-primary w-100' data-id='" + id + "' data-name='" + name + "' data-price='" + price + "' data-tipe-harga='" + tipeHarga + "'>" +
            "Tambah" +
            "</button>" +
            "</div>"
        );
    }).catch(function (error) {
        console.log(error);
    });
});


$(document).on("click", ".plus-item", function (event) {
    var id = $(this).data('id');

    $.get('outlet/detail-produk', {
        id: id
    })
        .then(function (materials) {
            var allMaterialsAvailable = true;

            // memeriksa apakah persediaan cukup untuk setiap bahan pada produk
            var promises = materials.map(function (material) {
                var materialId = material.material_id;
                var dose = material.dose;

                return getProductStockByMaterial(materialId)
                    .then(function (availableStock) {
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
            Promise.all(promises).then(function () {
                if (allMaterialsAvailable) {
                    shoppingCart.addItemToCart(id);

                    materials.forEach(function (material) {
                        var materialId = material.material_id;
                        var dose = material.dose;

                        reduceProductStockByMaterial(materialId, dose);
                    });

                    displayCart();

                    $(this).replaceWith(
                        "<div class='input-group'>" +
                        "<button class='minus-item input-group-addon btn btn-primary' data-id='" + id + "' type='button'>-</button>" +
                        "<input type='number' class='item-count form-control' data-id='" + name + "' value='1'>" +
                        "<button class='plus-item btn btn-primary input-group-addon' data-id='" + id + "' type='button'>+</button>" +
                        "</div>"
                    );
                }
            }).catch(function (error) {
                console.error(error);
            });
        });
});



function getProductStockByMaterial(materialId) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: 'outlet/stok-produk',
            data: {
                material_id: materialId
            },
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
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
            success: function (data) {
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            }
        });
    });
}

function increaseProductStockByMaterial(materialId, dose) {
    return new Promise(function (resolve, reject) {
        $.ajax({
            url: 'outlet/increase-stok-produk',
            async: false,
            data: {
                material_id: materialId,
                dose: dose
            },
            success: function (data) {
                resolve(data);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {
        output += "<div class='card mt-3'>" +
            "<div class='card-body'>" +
            "<div>" +
            "<p>" + cartArray[i].name + "</p>" +
            "<p>Total: " + cartArray[i].total + "</p>" +
            "</div>" +
            "<div class='d-flex'>" +
            "<div class='input-group'>" +
            "<button class='minus-item input-group-addon btn btn-primary' data-id=" +
            cartArray[i].id + " type='button'>-</button>" +
            "<input type='number' class='item-count form-control' data-id='" + cartArray[i].name +
            "' value='" + cartArray[i].count + "'>" +
            "<button class='plus-item btn btn-primary input-group-addon' data-id=" + cartArray[i].id +
            " type='button'>+</button>" +
            "</div>" +
            "<button class='delete-item btn btn-danger' data-id=" + cartArray[i].id +
            " >X</button>" +
            "</div>" +
            "</div>" +
            "</div>";
    }

    // Render the cart items on the page
    $('.show-cart').html(output);

    // Update the total amount and count in the cart
    $('.total-cart').html(shoppingCart.totalCart().toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }));
    $('#paid_amount').attr('value', shoppingCart.totalCart());
    $('#total-price').val(shoppingCart.totalCart());
    $('#total-price').attr('value', shoppingCart.totalCart());
    $('.total-count').html(shoppingCart.totalCount());

    // Show/hide payment type and submit button based on cart items count
    if (cartArray.length === 0) {
        $('#tipe_pembayaran').hide();
        $('#btn-submit').hide();
    } else {
        $('#tipe_pembayaran').show();
        $('#btn-submit').show();
    }
}

$('.show-cart').on("click", ".delete-item", function (event) {
    event.preventDefault();
    var id = $(this).data('id');

    shoppingCart.removeItemFromCartAll(id);

    displayCart();

})

$('.show-cart').on("click", ".minus-item", function (event) {
    var id = $(this).data('id');

    // membuat array promise untuk setiap bahan pada produk
    var promises = [];

    $.get('outlet/detail-produk', {
        id: id
    }, function (materials) {
        for (var i = 0; i < materials.length; i++) {
            var material = materials[i];
            var materialId = material.material_id;
            var dose = material.dose;

            // menambahkan promise untuk setiap bahan pada produk
            promises.push(increaseProductStockByMaterial(materialId, dose));
        }
    });

    // menunggu semua promise selesai
    Promise.all(promises).then(function () {
        shoppingCart.removeItemFromCart(id);
        displayCart();
    }).catch(function (error) {
        console.log(error);
    });
});


$('.show-cart').on("click", ".plus-item", function (event) {
    var id = $(this).data('id');

    $.get('outlet/detail-produk', {
        id: id
    })
        .then(function (materials) {
            var allMaterialsAvailable = true;

            // memeriksa apakah persediaan cukup untuk setiap bahan pada produk
            var promises = materials.map(function (material) {
                var materialId = material.material_id;
                var dose = material.dose;

                return getProductStockByMaterial(materialId)
                    .then(function (availableStock) {
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
            Promise.all(promises).then(function () {
                if (allMaterialsAvailable) {
                    shoppingCart.addItemToCart(id);

                    materials.forEach(function (material) {
                        var materialId = material.material_id;
                        var dose = material.dose;

                        reduceProductStockByMaterial(materialId, dose);
                    });

                    displayCart();
                }
            }).catch(function (error) {
                console.error(error);
            });
        });
});




displayCart();
