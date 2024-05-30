@if ($isMobile === true)
    <div id="outlet-pos-mobile" class="d-block d-lg-none  ">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('outlet.transaction.store') }}" method="POST" id="cart-form">
                            @csrf
                            <div style="max-height: 200px;overflow-x: auto;padding: 0px;">

                                <table class="show-cart table">

                                </table>
                            </div>
                            <label class="form-control-label active">Tanggal Transaksi<span
                                    class="tx-danger">*</span></label>
                            <input
                                class="form-control @error('order_date')
                                            is-invalid
                                        @enderror"
                                type="date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}">
                            <div class="d-flex justify-content-between mt-3">
                                <h6>Total Harga:
                                </h6>
                                <h6 class="total-cart"></h6>
                            </div>
                            <input type="number" class="form-control total-price mt-3" name="total_price"
                                id="total-price" value="" hidden>
                            <label class="form-label mt-3">Masukan Jumlah Pembayaran</label>
                            <input type="number" class="form-control  paid-amount" name="paid_amount"
                                placeholder="Jumlah Bayar" id="paid_amount" value="">
                            <h6 class="mt-3">Kembalian: <span class="total-change">Rp 0</span></h6>
                            <label class="form-label mt-3">Pilih Metode Pembayaran</label>
                            <select id="tipe_pembayaran" class="tipe-pembayaran tipe-pembayaran-select custom-select">
                                <option value="cash">Cash</option>
                                <option value="qris">Qris</option>
                            </select>

                            <div class="d-flex align-items-center mt-3">
                                <input type="text" class="form-control member-number" name="member_number"
                                    placeholder="Nomor Member" id="member_number" value="">
                                <button type="button" class="btn btn-primary ml-3" id="search_member">Cari
                                    Member</button>
                            </div>

                            <div id="result-member" class="mt-1"></div>
                            <input type="number" class="form-control mt-3 member-id" name="member_id" id="member-id"
                                value="" hidden>
                            <button class="btn btn-success mt-3 w-100 btn-submit" type="submit"
                                id="btn-submit">Beli</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>



        <button type="button"
            class="btn btn-primary btn-cart-mobile d-flex align-items-center p-3 justify-content-between"
            data-toggle="modal" data-target="#exampleModal">
            {{-- <span class="total-count"></span> --}}

            <p class="total-count text-white m-0"></p>
            <div class="d-flex align-items-center">
                <p class="mr-2 text-white m-0 total-count-price"></p>
                <i data-feather="shopping-cart"></i>
            </div>
        </button>
        <div class="pb-3">
            <label class="form-label mt-3">Pilih Jenis Customer</label>
            <select id="tipe_harga" class="tipe-harga-select custom-select pb-3">
                <option value="umum">Umum</option>
                <option value="member">Member</option>
                <option value="online">Online</option>
            </select>
        </div>
        <div class="row list-product">
            @foreach ($products as $product)
                <div class="col-12 ">
                    <div class="card-product ">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="product d-flex align-items-center">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top mr-3 mb-3">
                                @else
                                    <span></span>
                                @endif

                                <div class="price ">
                                    <h6 class="card-title mb-0">{{ $product->name }}</h6>
                                    <p class="mb-0">Stok: <span id="product-stock-{{ $product->id }}"></span></p>
                                    <p style="font-weight: 900"><span class="harga-produk"
                                            data-harga-umum="{{ $product->general_price }}"
                                            data-harga-member="{{ $product->member_price }}"
                                            data-harga-online="{{ $product->online_price }}">
                                            {{ 'Rp ' . number_format($product->general_price, 0, ',', '.') }}

                                        </span>
                                    </p>
                                </div>
                            </div>
                            <button class="add-to-cart default-add-to-cart" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-harga-umum="{{ $product->general_price }}"
                                data-harga-member="{{ $product->member_price }}"
                                data-harga-online="{{ $product->online_price }}"
                                data-price="{{ $product->general_price }}" data-tipe-harga="umum">
                                +
                            </button>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@else
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
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="...">
                            @else
                                <span></span>
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p>Rp <span class="harga-produk" data-harga-umum="{{ $product->general_price }}"
                                        data-harga-member="{{ $product->member_price }}"
                                        data-harga-online="{{ $product->online_price }}">
                                        {{ number_format($product->general_price, 0, ',', '.') }}
                                    </span>
                                </p>

                                <a href="#" class="add-to-cart btn btn-primary w-100 "
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
                    <button class="btn btn-primary mt-3 w-100 btn-submit" type="submit"
                        id="btn-submit">Beli</button>

                </form>
                {{-- <button class="clear-cart btn btn-danger mt-3 w-100">Clear Cart</button> --}}

            </div>
        </div>


    </div>
@endif
