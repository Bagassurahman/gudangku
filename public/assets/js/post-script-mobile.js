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
    var $tipeHargaSelect = $('.tipe-harga-select');
    var $tipePembayaranSelect = $('.tipe-pembayaran-select');

    $tipeHargaSelect.on('change', function () {
        var tipeHarga = $(this).val();

        $hargaProduk.each(function () {
            var harga = $(this).data('harga-' + tipeHarga);
            $(this).html('Rp ' + harga.toLocaleString('id-ID', { minimumFractionDigits: 0 }));
        });

        $addToCart.each(function () {
            var harga = $(this).data('harga-' + tipeHarga);
            $(this).attr('data-price', harga);
        });

        if (tipeHarga === 'online') {
            $tipePembayaranSelect.val('qris');
        }

        if (tipeHarga === 'online') {
            $tipePembayaranSelect.find('option[value="cash"]').remove();
        }
    });

    // Trigger the change event initially
    $tipeHargaSelect.trigger('change');
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


    obj.getItemCount = function (itemId) {
        var count = 0;

        // Menghitung jumlah item dengan ID produk yang diberikan dalam keranjang
        for (var item in cart) {
            if (cart[item].id === itemId) {
                count += cart[item].count;
            }
        }

        return count;
    };


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

$(document).on("click", ".add-to-cart", function (event) {
    event.preventDefault();

    var addButton = $(this);
    var id = addButton.data('id');
    var name = addButton.data('name');
    var price = Number(addButton.data('price'));

    shoppingCart.addItemToCart(id, name, price, 1);

    displayCart();

    addButton.replaceWith(
        "<div class='d-flex'>" +
        "    <button class='minus-item input-group-addon mr-2' data-id='" + id + "' type='button'>-</button>" +
        "    <input type='number' class='item-count mx-2' data-id='" + id + "' value='1'>" +
        "    <button class='plus-item ml-2' data-id='" + id + "' type='button'>+</button>" +
        "</div>"
    );
});



var originalButtons = [];

// Simpan tombol asli untuk setiap item
$(document).on("click", ".add-to-cart", function () {
    var addButton = $(this);
    var id = addButton.data('id');

    if (!originalButtons[id - 1]) {
        originalButtons[id - 1] = addButton.clone();
    }
});

function minusItem(id, count, newButton) {

    shoppingCart.removeItemFromCart(id);

    displayCart();

    var shoppingCartItemCount = shoppingCart.getItemCount(id);
    if (shoppingCartItemCount > 0) {
        $('.item-count[data-id="' + id + '"]').val(shoppingCartItemCount);
    } else {
        if (newButton) {
            $('.minus-item[data-id="' + id + '"]').parent().replaceWith(newButton);
        }
    }

    return promises;
}
$(document).on("keyup", ".item-count", function (event) {
    var id = $(this).data('id');
    var count = Number($(this).val());
    shoppingCart.setCountForItem(id, count);
    displayCart();
});


$(document).on("click", ".minus-item", function (event) {
    var id = $(this).data('id');
    var clickedButton = $(this);



    shoppingCart.removeItemFromCart(id);
    displayCart();

    var shoppingCartItemCount = shoppingCart.getItemCount(id);
    if (shoppingCartItemCount > 0) {
        clickedButton.parent().replaceWith(
            "<div class='d-flex'>" +
            "<button class='minus-item input-group-addon mr-2' data-id='" + id + "' type='button'>-</button>" +
            "<input type='number' class='item-count mx-2' data-id='" + id + "' value='" + shoppingCartItemCount + "'>" +
            "<button class='plus-item input-group-addon ml-2' data-id='" + id + "' type='button'>+</button>" +
            "</div>"
        );
    } else {
        if (originalButtons[id - 1]) { // Periksa apakah tombol asli tersedia
            clickedButton.parent().replaceWith(originalButtons[id - 1].clone());
        }
    }

});


$(document).on("click", ".plus-item", function (event) {
    var id = $(this).data('id');
    var clickedButton = $(this);


    shoppingCart.addItemToCart(id);

    displayCart();

    var shoppingCartItemCount = shoppingCart.getItemCount(id);
    clickedButton.parent().replaceWith(
        "<div class='d-flex'>" +
        "<button class='minus-item input-group-addon mr-2' data-id='" + id + "' type='button'>-</button>" +
        "<input type='number' class='item-count mx-2' data-id='" + id + "' value='" + shoppingCartItemCount + "'>" +
        "<button class='plus-item input-group-addon ml-2' data-id='" + id + "' type='button'>+</button>" +
        "</div>"
    );

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


function updateProductStock(productId, warehouseId, outletId) {
    $.ajax({
        url: 'outlet/get-stok?product_id=' + productId + '&outlet_id=' + outletId,
        method: 'GET',
        success: function (response) {
            var stock = response.stockByMaterial;
            $('#product-stock-' + productId).text(stock);
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}

$(document).ready(function () {
    // Mendapatkan stok produk dan memperbarui tampilan
    function updateProductStock(productId, warehouseId, outletId) {
        $.ajax({
            url: 'outlet/get-stok?product_id=' + productId + '&outlet_id=' + outletId,
            method: 'GET',
            success: function (response) {
                var stock = response.stockByMaterial;
                $('#product-stock-' + productId).text(stock);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Mendapatkan stok saat halaman pertama kali dimuat
    $('.add-to-cart').each(function () {
        var productId = $(this).data('id');
        updateProductStock(productId, outletId);
    });
});


function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {
        output += "<div class='mt-3 border-bottom pb-2'>" +
            "<div class='d-flex justify-content-between align-items-center'>" +
            "<div>" +
            "<h6>" + cartArray[i].name + "</h6>" +
            "<h6>" + "Total Item: " + cartArray[i].count + "</h6>" +
            "</div>" +
            "<div>" +
            "<h6>Total: Rp " + cartArray[i].total.toLocaleString() + "</h6>" +
            "</div>" +
            "<button class='delete-item btn btn-danger' data-id='" + cartArray[i].id + "' data-count='" + cartArray[i].count + "' data-name='" + cartArray[i].name + "' data-price='" + cartArray[i].price + "'>X</button>" +
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
    $('.total-count').html(shoppingCart.totalCount() + " Item");

    $('.total-count-price').html(shoppingCart.totalCart().toLocaleString('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }));

    // Show/hide payment type and submit button based on cart items count
    if (cartArray.length === 0) {
        $('#tipe_pembayaran').hide();
        $('#btn-submit').hide();
    } else {
        $('#tipe_pembayaran').show();
        $('#btn-submit').show();
    }

    // <input type="text" class="form-control member-number" name="member_number"
    //     placeholder="Nomor Member" id="member_number" value="">

    // Route:: get('/get-member/{phoneNumber}', [MemberController:: class, 'getMemberByPhoneNumber']);\

    $('#search_member').on('click', function () {
        var memberNumber = $('#member_number').val();

        $.ajax({
            url: '/api/get-member/' + memberNumber,
            method: 'GET',
            success: function (response) {
                // <div id="result-member" class="mt-3"></div>
                $('#result-member').html(
                    "<p>Nama Member: " + response.data.name + "</p>"
                );

                $('.member-number').addClass('is-valid');

                $('.member-id').attr('value', response.data.id);
            },
            error: function (xhr, status, error) {
                console.error(error);
                $('.member-number').removeClass('is-valid');
                $('#result-member').html(
                    "<p class='text-danger'>Member tidak ditemukan</p>"
                );
            }
        });
    });
}

$('.show-cart').on("click", ".delete-item", async function (event) {
    event.preventDefault();
    var id = $(this).data('id');
    var count = $(this).data('count');

    shoppingCart.removeItemFromCartAll(id);


    try {

        displayCart();

        // Mengganti tombol pada daftar produk dengan tombol aslinya
        var newButton = "<button class='add-to-cart default-add-to-cart' data-id='" + id + "' data-name='" + $(this).data('name') + "' data-harga-umum='" + $(this).data('harga-umum') + "' data-harga-member='" + $(this).data('harga-member') + "' data-harga-online='" + $(this).data('harga-online') + "' data-price='" + $(this).data('price') + "' data-tipe-harga='umum'>+</button>";

        $(this).closest('.card-body').find('.d-flex').replaceWith(newButton);
        var shoppingCartItemCount = shoppingCart.getItemCount(id);
        if (shoppingCartItemCount > 0) {
            $('.item-count[data-id="' + id + '"]').val(shoppingCartItemCount);
        } else {
            if (newButton) {
                $('.minus-item[data-id="' + id + '"]').parent().replaceWith(newButton);
            }
        }

    } catch (error) {
        console.log(error);
    }
});


$('.show-cart').on("click", ".minus-item", function (event) {
    var id = $(this).data('id');


    shoppingCart.removeItemFromCart(id);
    displayCart();

});


$('.show-cart').on("click", ".plus-item", function (event) {
    var id = $(this).data('id');

    shoppingCart.addItemToCart(id);

    displayCart();
});

const cartForm = document.querySelector('#cart-form');
const beliBtn = document.querySelector('#btn-submit');

beliBtn.addEventListener('click', function () {

    const cartItems = shoppingCart.listCart();
    const cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cart_items';
    cartInput.value = JSON.stringify(cartItems);

    const selectMemberElement = document.getElementById('tipe_harga');
    const selectedMemberValue = selectMemberElement.value;
    const selectTipeMember = document.createElement('input');
    selectTipeMember.type = 'hidden';
    selectTipeMember.name = 'tipe_harga';
    selectTipeMember.value = selectedMemberValue;

    const selectPaymentElement = document.getElementById('tipe_pembayaran');
    const selectedPaymentValue = selectPaymentElement.value;
    const selectTipePembayaran = document.createElement('input');

    selectTipePembayaran.type = 'hidden';
    selectTipePembayaran.name = 'tipe_pembayaran';
    selectTipePembayaran.value = selectedPaymentValue;


    cartForm.appendChild(selectTipePembayaran);
    cartForm.appendChild(selectTipeMember);
    cartForm.appendChild(cartInput);
    cartForm.submit();


    shoppingCart.clearCart();
});



displayCart();
