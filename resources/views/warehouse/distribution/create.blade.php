@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-8">
            <div class="main-card">
                <div class="header">
                    Distribusikan Data
                </div>

                <form method="POST" action="{{ route('warehouse.distribusi.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="body">
                        <div class="mb-3">
                            <label for="outlet_id" class="text-xs required">Pilih Outlet</label>
                            <div class="form-group">
                                <select name="outlet_id" id="outlet_id"
                                    class="form-control {{ $errors->has('outlet_id') ? ' ' : '' }}">
                                    <option value="">Pilih Outlet</option>
                                    @foreach ($outlets as $outlet)
                                        <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('outlet_id'))
                                <p class="invalid-feedback">{{ $errors->first('outlet_id') }}</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="distribution_date" class="text-xs required">Tanggal Distribusi</label>
                            <div class="form-group">
                                <input type="date" id="distribution_date" name="distribution_date"
                                    class="{{ $errors->has('distribution_date') ? ' ' : '' }}"
                                    value="{{ old('distribution_date') }}" required>
                            </div>
                            @if ($errors->has('distribution_date'))
                                <p class="invalid-feedback">{{ $errors->first('distribution_date') }}</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="fee" class="text-xs required">Biaya Kirim</label>
                            <div class="form-group">
                                <input type="text" id="fee" name="fee"
                                    class="{{ $errors->has('fee') ? ' ' : '' }}" value="{{ old('fee') }}" required>
                            </div>
                            @if ($errors->has('fee'))
                                <p class="invalid-feedback">{{ $errors->first('fee') }}</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="items" class="text-xs required">Data yang akan didistribusikan</label>
                            <div class="row">
                                @foreach ($materials as $material)
                                    <div class="col-3">
                                        <div class="material main-card">
                                            <div class="header">
                                                {{ $material->material->name }}
                                            </div>
                                            <div class="body">
                                                <p>Stok: {{ $material->qty }}</p>
                                                <div class="form-group">
                                                    <input type="number" min="1" value="1"
                                                        id="qty-{{ $material->id }}">
                                                </div>
                                                <button type="button" class="btn-full btn-blue mt-3 w-100"
                                                    onclick="addToCart({{ $material->id }}, '{{ $material->material->name }}', parseInt(document.getElementById('qty-{{ $material->id }}').value))">Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
        <div class="col-4">
            <div class="main-card">
                <div class="cart">
                    <div class="header">
                        Keranjang
                    </div>
                    <div class="body">
                        <ul id="cart-items">
                        </ul>

                        <div class="mb-3">
                            <label for="total-fee" class="text-xs required">Total Biaya</label>
                            <div class="form-group">
                                <input type="text" id="total-fee" name="total_fee"
                                    class="{{ $errors->has('total_fee') ? ' ' : '' }}" value="{{ old('total_fee') }}"
                                    readonly required>
                            </div>
                            @if ($errors->has('total_fee'))
                                <p class="invalid-feedback">{{ $errors->first('total_fee') }}</p>
                            @endif
                        </div>

                        <button type="button" class="btn-full btn-blue mt-3 w-100" onclick="calculateTotal()">Hitung
                            Total</button>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addToCart(id, name, qty) {
            var cartItem = '<li>' + name + ' - ' + qty +
                ' <button onclick="removeFromCart(this)" >Hapus</button><input type="hidden" name="items[]" value="' + id +
                ':' + qty + '"></li>';
            document.getElementById('cart-items').insertAdjacentHTML('beforeend', cartItem);
        }

        function removeFromCart(item) {
            item.parentElement.remove();
        }

        function calculateTotal() {
            var total = 0;
            var items = document.getElementsByName('items[]');
            var fee = parseFloat(document.getElementById('fee').value);
            for (var i = 0; i < items.length; i++) {
                var item = items[i].value.split(':');
                var id = item[0];
                var qty = parseInt(item[1]);
                var price = parseFloat(document.getElementById('price-' + id).value);
                total += qty * price;
            }
            total += fee;
            document.getElementById('total-fee').value = total;
        }
    </script>
@endsection
