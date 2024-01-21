<div id="outlet-pos" class="row justify-content-between d-none d-md-flex">
    <div class="col-12 pb-3">
        <label class="form-label mt-3">Pilih Jenis Customer</label>
        <select id="tipe_harga" class="tipe-harga-select custom-select">
            <option value="umum">Umum</option>
            <option value="member">Member</option>
            <option value="online">Online</option>
        </select>
    </div>
    <div class="col-xl-7 col-md-6">
        <div class="row list-product">
            @foreach ($products as $product)
                <div class="col-xl-4 mt-3 col-md-6">
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

                            <a href="#" class="add-to-cart btn btn-primary w-100" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-harga-umum="{{ $product->general_price }}"
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
    <div class="col-xl-5 col-md-6">

        <div class="card p-2">
            <form action="{{ route('outlet.transaction.store') }}" method="POST" id="cart-form">
                @csrf
                <div style="max-height: 340px;overflow-x: auto;padding: 0px;">
                    <table class="show-cart table">

                    </table>
                </div>

                <h6>Total Harga: <span class="total-cart"></span></h6>
                <input type="number" class="form-control total-price mt-3" name="total_price" id="total-price"
                    value="" hidden>
                <input type="number" class="form-control mt-3 paid-amount" name="paid_amount"
                    placeholder="Jumlah Bayar" id="paid_amount" value="">
                <h6 class="mt-3">Kembalian: <span class="total-change">Rp 0</span></h6>
                <label class="form-label mt-3">Pilih Metode Pembayaran</label>
                <select id="tipe_pembayaran" class="tipe-pembayaran tipe-pembayaran-select custom-select">
                    <option value="cash">Cash</option>
                    <option value="qris">Qris</option>
                </select>
                <button class="btn btn-primary mt-3 w-100 btn-submit" type="submit" id="btn-submit">Beli</button>

            </form>
            <button class="clear-cart btn btn-danger mt-3 w-100">Clear Cart</button>

        </div>
    </div>
    {{-- <script>
        alert('dekstop')
    </script> --}}

</div>
