@extends('layouts.app')

@section('title', 'Vybrasi - Pesanan Dikonfirmasi')

@section('content')
<div class="success-container">
    <div class="success-card">
        
        <div class="success-header">
            <span class="status-label">PESANAN DIKONFIRMASI</span>
            <h1 class="success-title premium-serif">Terima Kasih !</h1>
            <p class="success-subtitle">Pesanan anda telah kami terima. Kode order :</p>
            <div class="order-badge">#{{ $orderId }}</div>
        </div>

        {{-- LOGIKA TAMPILAN PEMBAYARAN DINAMIS --}}
        @if($paymentMethod == 'qris')
            
            {{-- TAMPILAN JIKA MEMILIH QRIS --}}
            <div class="transfer-box" style="text-align: center;">
                <p class="bank-name">Scan QRIS (A.n. Vybrasi Coffee)</p>
                <div class="qris-wrapper" style="margin: 15px 0;">
                    {{-- Ganti src dengan gambar QRIS asli milik tokomu nanti --}}
                    <img src="https://placehold.co/200x200?text=GAMBAR+QRIS+ASLI" alt="QRIS Vybrasi" style="width: 200px; height: 200px; border-radius: 12px; border: 2px solid #eaeaea;">
                </div>
                <p style="font-size: 14px; color: #666; margin-bottom: 10px;">Buka aplikasi e-wallet (Gopay/OVO/Dana) lalu scan kode di atas.</p>
                <p class="transfer-amount">Bayar tepat sesuai total : <span class="fw-bold">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span></p>
            </div>

        @else

            {{-- TAMPILAN JIKA MEMILIH BANK (BCA / BRI) --}}
            <div class="transfer-box">
                @if($paymentMethod == 'bca')
                    <p class="bank-name">Bank BCA a.n. Vybrasi Coffee</p>
                    <div class="account-row">
                        <span class="account-number" id="rekening">8732019992</span>
                        <button class="btn-copy" onclick="copyRekening()">Salin</button>
                    </div>
                @elseif($paymentMethod == 'bri')
                    <p class="bank-name">Bank BRI a.n. Vybrasi Coffee</p>
                    <div class="account-row">
                        <span class="account-number" id="rekening">001122334455667</span>
                        <button class="btn-copy" onclick="copyRekening()">Salin</button>
                    </div>
                @endif
                <p class="transfer-amount">Transfer tepat sesuai total : <span class="fw-bold">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span></p>
            </div>

        @endif

        <div class="wa-box">
            <p class="wa-text">Setelah bayar, konfirmasi via WhatsApp dengan<br>kirim bukti transfer & kode order Anda.</p>
            
            {{-- Tombol WA Dinamis: Pesan otomatis terisi kode order --}}
            <a href="https://wa.me/6283114459227?text=Halo%20Admin%20Vybrasi,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20Order%20ID:%20%23{{ $orderId }}" target="_blank" class="btn-wa">
                <i class="fa-brands fa-whatsapp"></i> Kirim Bukti
            </a>
        </div>

        <div class="success-action">
            <a href="{{ route('beranda') }}" class="btn-pesan-lagi">Kembali ke Beranda</a>
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
                btn.style.backgroundColor = '#D4A373';
                btn.style.color = '#FFF';
                
                // Kembalikan tulisan setelah 2 detik
                setTimeout(function() {
                    btn.innerText = 'Salin';
                    btn.style.backgroundColor = 'transparent';
                    btn.style.color = '#D4A373';
                }, 2000);
            });
        }
    }
</script>
@endsection