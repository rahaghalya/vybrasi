@extends('layouts.app')

@section('title', 'Vybrasi - Pilih Pembayaran')

@section('content')
<div class="pembayaran-container">
    <div class="pembayaran-card">
        
        <h2 class="pembayaran-title">Pilih Pembayaran</h2>

        {{-- PERUBAHAN: Form Action menuju pembayaran.proses menggunakan POST --}}
        <form action="{{ route('pembayaran.proses') }}" method="POST" class="pembayaran-form" id="form-pembayaran">
            @csrf
            
            <div class="payment-list">
                
                <label class="payment-option">
                    <input type="radio" name="metode_pembayaran" value="qris" checked onchange="closeBankDropdown()">
                    <div class="payment-content">
                        <div class="payment-icon" style="background: #eef2f5; color: #333;">
                            <i class="fa-solid fa-qrcode"></i>
                        </div>
                        <div class="payment-text">
                            <h4>QRIS (Gopay, OVO, Dana, LinkAja)</h4>
                            <p>Bayar instan menggunakan aplikasi e-wallet pilihanmu.</p>
                        </div>
                        <div class="payment-radio">
                            <span class="radio-circle"></span>
                        </div>
                    </div>
                </label>

                <div class="payment-accordion">
                    <div class="accordion-header" onclick="toggleBankDropdown()" id="btn-toggle-bank">
                        <div class="header-left">
                            <div class="payment-icon">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <div class="payment-text">
                                <h4>Transfer Bank</h4>
                                <p>Pilih bank untuk melihat instruksi pembayaran.</p>
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
                                    <p>Pengecekan otomatis via Virtual Account</p>
                                </div>
                                <div class="payment-radio">
                                    <span class="radio-circle"></span>
                                </div>
                            </div>
                        </label>

                        <label class="payment-option sub-option">
                            <input type="radio" name="metode_pembayaran" value="bri">
                            <div class="payment-content">
                                <div class="payment-text">
                                    <h4>Bank BRI</h4>
                                    <p>Pengecekan otomatis via Virtual Account</p>
                                </div>
                                <div class="payment-radio">
                                    <span class="radio-circle"></span>
                                </div>
                            </div>
                        </label>

                    </div>
                </div>

            </div>

            <div class="pembayaran-actions" style="margin-top: 30px; display: flex; justify-content: space-between; gap: 15px;">
                <a href="{{ route('checkout') }}" class="btn-kembali" style="padding: 12px 24px; border: 1px solid #333; color: #333; text-decoration: none; border-radius: 8px; display: flex; align-items: center;">
                    <i class="fa-solid fa-arrow-left-long" style="margin-right: 8px;"></i> Kembali
                </a>
                
                {{-- PERUBAHAN: Button tipe Submit --}}
                <button type="submit" class="btn-review" style="background: #D4A373; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; font-size: 16px; font-weight: bold; width: 100%; justify-content: center;">
                    Review Pesanan <i class="fa-solid fa-arrow-right-long" style="margin-left: 8px;"></i>
                </button>
            </div>

        </form>
    </div>
</div>

<style>
    .payment-accordion {
        border: 1px solid #eaeaea; border-radius: 12px; overflow: hidden; margin-top: 15px; transition: all 0.3s ease;
    }
    .accordion-header {
        display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #fff; cursor: pointer; transition: background 0.3s;
    }
    .accordion-header:hover { background: #fcfcfc; }
    .header-left { display: flex; align-items: center; gap: 15px; }
    .accordion-arrow { color: #888; transition: transform 0.3s ease; }
    .accordion-arrow.open { transform: rotate(180deg); }
    .accordion-body { background: #fafafa; border-top: 1px solid #eaeaea; padding: 10px 20px 20px 20px; }
    .sub-option { margin-top: 10px; background: #fff; border: 1px solid #ddd; }
</style>

<script>
    const dropdownBank = document.getElementById('dropdown-bank');
    const arrowBank = document.getElementById('arrow-bank');
    const radioBanks = document.querySelectorAll('input[value="bca"], input[value="bri"]');

    function toggleBankDropdown() {
        if (dropdownBank.style.display === "none") {
            dropdownBank.style.display = "block";
            arrowBank.classList.add("open");
        } else {
            dropdownBank.style.display = "none";
            arrowBank.classList.remove("open");
        }
    }

    function closeBankDropdown() {
        dropdownBank.style.display = "none";
        arrowBank.classList.remove("open");
    }

    radioBanks.forEach(radio => {
        radio.addEventListener('change', function() {
            dropdownBank.style.display = "block";
            arrowBank.classList.add("open");
        });
    });
</script>
@endsection