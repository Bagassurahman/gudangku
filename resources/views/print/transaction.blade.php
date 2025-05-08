<!DOCTYPE html>
<html>
<head>
    <title>Print Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 2rem;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .receipt {
            width: 350px;
            margin: 0 auto; /* Membuat konten berada di tengah */
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px; /* Menambahkan margin bawah */
        }
        .items {
            margin-top: 2rem;
        }
        .item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .total {
            margin-top: 20px;
        }
        .total-item {
            display: flex;
            justify-content: space-between;
            font-weight: bold; /* Membuat teks total lebih tebal */
        }
        .footer {
            text-align: center;
            margin-top: 20px; /* Menambahkan margin atas */
            margin-bottom: 50px; /* Menambahkan margin bawah */
        }
        /* Menggunakan media query untuk menyembunyikan tombol saat mencetak */
        @media print {
            .btn-back {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h2>
                Gudangku
            </h2>
            <p>Nomor Invoice: {{ $transaction->order_number }}</p>
            <p>Tanggal: {{ $transaction->order_date }}</p>
        </div>
        <div class="items">
            @foreach($transaction->transactionDetails as $detail)
            <div class="item">
                <span>{{ $detail->qty }} x {{ $detail->product->name }}</span>
                <span>Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        <div class="total">
            <div class="total-item">
                <span>Total</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="total-item">
                <span>Pembayaran</span>
                <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
            </div>
            <div class="total-item">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->paid_amount - $transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="total-item">
                <span>Bayar dengan</span>
                <span>{{ $transaction->payment_method }}</span>
            </div>
        </div>
        <div class="footer">
            Terima kasih telah berbelanja di <a href="{{ route('dashboard') }}">Gudangku</a>, daftarkan diri Anda sebagai member untuk mendapatkan poin dan diskon menarik!
        </div>
    </div>
</body>
</html>
