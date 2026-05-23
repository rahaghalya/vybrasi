@extends('layouts.app')

@section('title', 'Vybrasi - Pesanan Dikonfirmasi')

@section('content')
<div class="vy-luxury-success-wrapper">
    <div class="editorial-success-container fade-in-up">

        {{-- HEADER SECTION --}}
        <div class="success-header-editorial">
            <span class="badge-serif">Pesanan Dikonfirmasi</span>
            <h1 class="editorial-page-title">Terima<br><i class="serif-accent">Kasih.</i></h1>
            <p class="success-subtitle-hairline">Pesanan Anda telah kami terima. Kode order:</p>
            <div class="order-badge-luxury">#{{ $orderId }}</div>
            <div class="editorial-hairline" style="margin: 30px auto;"></div>
        </div>

        {{-- LOGIKA TAMPILAN PEMBAYARAN DINAMIS --}}
        @if($paymentMethod == 'qris')
            
            {{-- TAMPILAN QRIS --}}
            <div class="transfer-box-luxury" style="text-align: center;">
                <h3 class="bank-name-editorial">Scan QRIS (A.n. Vybrasi Coffee)</h3>
                <div class="qris-wrapper">
                    {{-- Ganti src dengan gambar QRIS asli milik tokomu nanti --}}
                    <img src="https://placehold.co/200x200?text=GAMBAR+QRIS+ASLI" alt="QRIS Vybrasi" class="qris-image">
                </div>
                <p class="transfer-instruction">Buka aplikasi e-wallet (Gopay/OVO/Dana) lalu scan kode di atas.</p>
                <p class="transfer-amount">Bayar tepat sesuai total: <br>
                    <span class="amount-highlight">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                </p>
            </div>

        @else

            {{-- TAMPILAN TRANSFER BANK --}}
            <div class="transfer-box-luxury">
                @if($paymentMethod == 'bca')
                    <h3 class="bank-name-editorial">Bank BCA a.n. Vybrasi Coffee</h3>
                    <div class="account-row-luxury">
                        <span class="account-number" id="rekening">8732019992</span>
                        <button class="btn-copy" onclick="copyRekening()">Salin</button>
                    </div>
                @elseif($paymentMethod == 'bri')
                    <h3 class="bank-name-editorial">Bank BRI a.n. Vybrasi Coffee</h3>
                    <div class="account-row-luxury">
                        <span class="account-number" id="rekening">001122334455667</span>
                        <button class="btn-copy" onclick="copyRekening()">Salin</button>
                    </div>
                @endif
                <p class="transfer-amount">Transfer tepat sesuai total: <br>
                    <span class="amount-highlight">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                </p>
            </div>

        @endif

        {{-- WA KONFIRMASI BOX --}}
        <div class="wa-box-luxury">
            <p class="wa-text-editorial">Setelah bayar, konfirmasi via WhatsApp dengan mengirimkan bukti transfer & kode order Anda.</p>
            
            {{-- Tombol WA Dinamis --}}
            <a href="https://wa.me/6283114459227?text=Halo%20Admin%20Vybrasi,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20Order%20ID:%20%23{{ $orderId }}" target="_blank" class="btn-wa-luxury">
                <i class="fa-brands fa-whatsapp" style="font-size: 16px;"></i> Konfirmasi via WhatsApp
            </a>
        </div>

        {{-- ACTION BUTTON --}}
        <div class="success-actions">
            <a href="{{ route('beranda') }}" class="btn-checkout-pill" style="text-align: center; text-decoration: none; display: block;">
                Kembali ke Beranda
            </a>
        </div>

    </div>
</div>

<script>
    function copyRekening() {
        var rekeningEl = document.getElementById("rekening");
        if(rekeningEl) {
            var rekeningText = rekeningEl.innerText;
            navigator.clipboard.writeText(rekeningText).then(function() {
                var btn = document.querySelector('.btn-copy');
                btn.innerText = 'Tersalin!';
                btn.classList.add('copied'); // Menggunakan class CSS agar lebih rapi
                
                // Kembalikan tulisan setelah 2 detik
                setTimeout(function() {
                    btn.innerText = 'Salin';
                    btn.classList.remove('copied');
                }, 2000);
            });
        }
    }
</script>
@endsection