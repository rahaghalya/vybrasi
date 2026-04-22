@extends('layouts.app')

@section('title', 'Vybrasi - Pilih Pembayaran')

@section('content')
<div class="pembayaran-container">
    <div class="pembayaran-card">
        
        <h2 class="pembayaran-title">Pilih Pembayaran</h2>

        <form action="#" method="POST" class="pembayaran-form">
            @csrf
            
            <div class="payment-list">
                <label class="payment-option">
                    <input type="radio" name="bank" value="bank_a" checked>
                    <div class="payment-content">
                        <div class="payment-icon">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="payment-text">
                            <h4>Transfer Bank A</h4>
                            <p>TERSEDIA 24 JAM, KONFIRMASI MANUAL</p>
                        </div>
                        <div class="payment-radio">
                            <span class="radio-circle"></span>
                        </div>
                    </div>
                </label>

                <label class="payment-option">
                    <input type="radio" name="bank" value="bank_b">
                    <div class="payment-content">
                        <div class="payment-icon">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="payment-text">
                            <h4>Transfer Bank B</h4>
                            <p>TERSEDIA 24 JAM, KONFIRMASI MANUAL</p>
                        </div>
                        <div class="payment-radio">
                            <span class="radio-circle"></span>
                        </div>
                    </div>
                </label>

                <label class="payment-option">
                    <input type="radio" name="bank" value="bank_c">
                    <div class="payment-content">
                        <div class="payment-icon">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="payment-text">
                            <h4>Transfer Bank C</h4>
                            <p>TERSEDIA 24 JAM, KONFIRMASI MANUAL</p>
                        </div>
                        <div class="payment-radio">
                            <span class="radio-circle"></span>
                        </div>
                    </div>
                </label>

                <label class="payment-option">
                    <input type="radio" name="bank" value="bank_d">
                    <div class="payment-content">
                        <div class="payment-icon">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="payment-text">
                            <h4>Transfer Bank D</h4>
                            <p>TERSEDIA 24 JAM, KONFIRMASI MANUAL</p>
                        </div>
                        <div class="payment-radio">
                            <span class="radio-circle"></span>
                        </div>
                    </div>
                </label>
            </div>

            <div class="pembayaran-actions">
                <a href="{{ route('checkout') }}" class="btn-kembali">
                    <i class="fa-solid fa-arrow-left-long"></i> Kembali
                </a>
                <a href="{{ route('pesanan.review') }}" class="btn-review" style="text-decoration: none; justify-content: center;">
                    Review Pesanan <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>

        </form>
    </div>
</div>
@endsection