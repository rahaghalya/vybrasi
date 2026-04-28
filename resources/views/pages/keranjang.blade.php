@extends('layouts.app')

@section('title', 'Vybrasi - Keranjang Saya')

@section('content')
<div class="keranjang-container">
    <h1 class="page-title">Keranjang Saya</h1>

    <div class="keranjang-card-main">
        
        <div class="cart-item">
            <label class="cart-checkbox">
                <input type="checkbox" name="item[]" value="1">
                <span class="checkmark-circle"></span>
            </label>

            <div class="cart-img-wrapper">
                <img src="{{ asset('images/kopi-arabica.png') }}" alt="Kopi Arabica">
            </div>

            <div class="cart-info">
                <h3>Kopi Arabica</h3>
                <p>250gr - Premium Roast</p>
                <div class="cart-price" data-price="50000">Rp 50.000</div>
            </div>

            <div class="cart-qty-wrapper">
                <button type="button" class="qty-btn minus"><i class="fa-solid fa-minus"></i></button>
                <span class="qty-num">1</span>
                <button type="button" class="qty-btn plus"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>

        <div class="cart-item">
            <label class="cart-checkbox">
                <input type="checkbox" name="item[]" value="2">
                <span class="checkmark-circle"></span>
            </label>

            <div class="cart-img-wrapper">
                <img src="{{ asset('images/kopi-arabica.png') }}" alt="Kopi Arabica">
            </div>

            <div class="cart-info">
                <h3>Kopi Arabica</h3>
                <p>250gr - Premium Roast</p>
                <div class="cart-price" data-price="100000">Rp 100.000</div>
            </div>

            <div class="cart-qty-wrapper">
                <button type="button" class="qty-btn minus"><i class="fa-solid fa-minus"></i></button>
                <span class="qty-num">2</span>
                <button type="button" class="qty-btn plus"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>

        <div class="cart-action">
            <a href="{{ route('checkout') }}" class="btn-checkout" style="text-decoration: none; text-align: center;">CheckOut</a>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua tombol minus dan plus di halaman
        const minusBtns = document.querySelectorAll('.qty-btn.minus');
        const plusBtns = document.querySelectorAll('.qty-btn.plus');

        // Logika untuk tombol Minus (-)
        minusBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                // Cari elemen angka (qty-num) yang berada di sebelah tombol ini
                const qtySpan = this.parentElement.querySelector('.qty-num');
                let currentQty = parseInt(qtySpan.textContent);

                // Pastikan angka tidak bisa kurang dari 1
                if (currentQty > 1) {
                    currentQty--;
                    qtySpan.textContent = currentQty;
                }
            });
        });

        // Logika untuk tombol Plus (+)
        plusBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                // Cari elemen angka (qty-num) yang berada di sebelah tombol ini
                const qtySpan = this.parentElement.querySelector('.qty-num');
                let currentQty = parseInt(qtySpan.textContent);

                // Tambahkan 1 ke angka saat ini
                currentQty++;
                qtySpan.textContent = currentQty;
            });
        });
    });
</script>
@endsection