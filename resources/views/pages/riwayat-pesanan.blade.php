@extends('layouts.app')

@section('title', 'Vybrasi - Riwayat Pesanan')

@section('content')
<div class="riwayat-container">
    <h1 class="page-title">Riwayat Pesanan</h1>

    <div class="riwayat-card-main">
        
        <div class="order-item">
            <div class="order-img-wrapper">
                <img src="{{ asset('images/kopi-arabica.png') }}" alt="Kopi Arabica">
            </div>
            <div class="order-content">
                <div class="order-header">
                    <div class="order-info">
                        <h3>Kopi Arabica</h3>
                        <p>250gr - Premium Roast</p>
                    </div>
                    <div class="order-qty">X 1</div>
                </div>
                
                <div class="order-price-details">
                    <div class="order-price">Rp 50.000</div>
                    <div class="order-total">Total: Rp 60.000</div>
                </div>

                <div class="order-actions">
                    <button class="btn-ulasan">Kirim Ulasan</button>
                    <button class="btn-beli">Beli Lagi</button>
                </div>
            </div>
        </div>

        <div class="order-item">
            <div class="order-img-wrapper">
                <img src="{{ asset('images/kopi-arabica.png') }}" alt="Kopi Arabica">
            </div>
            <div class="order-content">
                <div class="order-header">
                    <div class="order-info">
                        <h3>Kopi Arabica</h3>
                        <p>250gr - Premium Roast</p>
                    </div>
                    <div class="order-qty">X 2</div>
                </div>
                
                <div class="order-price-details">
                    <div class="order-price">Rp 100.000</div>
                    <div class="order-total">Total: Rp 210.000</div>
                </div>

                <div class="order-actions">
                    <button class="btn-ulasan">Kirim Ulasan</button>
                    <button class="btn-beli">Beli Lagi</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection