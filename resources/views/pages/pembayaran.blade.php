@extends('layouts.app')

@section('title', 'Vybrasi - Pilih Pembayaran')

@section('content')
<div class="vy-luxury-pembayaran-wrapper">
    <div class="editorial-container fade-in-up">
        
        <div class="pembayaran-header-editorial">
            <span class="badge-serif">Finalisasi Transaksi</span>
            <h1 class="editorial-page-title">Pilih Metode<br><i class="serif-accent">Pembayaran.</i></h1>
            <div class="editorial-hairline"></div>
        </div>

        <form action="{{ route('pembayaran.proses') }}" method="POST" id="form-pembayaran">
            @csrf
            
            <div class="payment-list">
                {{-- QRIS --}}
                <label class="payment-option">
                    <input type="radio" name="metode_pembayaran" value="qris" checked onchange="closeBankDropdown()">
                    <div class="payment-content">
                        <div class="payment-icon"><i class="fa-solid fa-qrcode"></i></div>
                        <div class="payment-text">
                            <h4>QRIS Instant</h4>
                            <p>Gopay, OVO, Dana, LinkAja</p>
                        </div>
                        <span class="radio-circle"></span>
                    </div>
                </label>

                {{-- ACCORDION BANK --}}
                <div class="payment-accordion">
                    <div class="accordion-header" id="btn-toggle-bank" onclick="toggleBankDropdown()">
                        <div class="header-left">
                            <div class="payment-icon"><i class="fa-solid fa-building-columns"></i></div>
                            <div class="payment-text">
                                <h4>Transfer Bank</h4>
                                <p>Virtual Account Otomatis</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down accordion-arrow" id="arrow-bank"></i>
                    </div>

                    <div class="accordion-body" id="dropdown-bank" style="display: none;">
                        <label class="payment-option sub-option">
                            <input type="radio" name="metode_pembayaran" value="bca">
                            <div class="payment-content">
                                <div class="payment-text">
                                    <h4>Bank BCA</h4>
                                    <p>Verifikasi Otomatis</p>
                                </div>
                                <span class="radio-circle"></span>
                            </div>
                        </label>
                        <label class="payment-option sub-option">
                            <input type="radio" name="metode_pembayaran" value="bri">
                            <div class="payment-content">
                                <div class="payment-text">
                                    <h4>Bank BRI</h4>
                                    <p>Verifikasi Otomatis</p>
                                </div>
                                <span class="radio-circle"></span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pembayaran-actions">
                <a href="{{ route('checkout') }}" class="btn-kembali">Kembali</a>
                <button type="submit" class="btn-review">Review Pesanan <i class="fa-solid fa-arrow-right-long"></i></button>
            </div>
        </form>
    </div>
</div>

<script>
    const dropdownBank = document.getElementById('dropdown-bank');
    const arrowBank = document.getElementById('arrow-bank');
    
    function toggleBankDropdown() {
        const isHidden = dropdownBank.style.display === "none";
        dropdownBank.style.display = isHidden ? "block" : "none";
        arrowBank.classList.toggle("open", isHidden);
    }

    function closeBankDropdown() {
        dropdownBank.style.display = "none";
        arrowBank.classList.remove("open");
    }

    document.querySelectorAll('input[value="bca"], input[value="bri"]').forEach(radio => {
        radio.addEventListener('change', () => {
            dropdownBank.style.display = "block";
            arrowBank.classList.add("open");
        });
    });
</script>
@endsection