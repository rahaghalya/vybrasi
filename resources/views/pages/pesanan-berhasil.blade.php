@extends('layouts.app')

@section('title', 'Vybrasi - Pesanan Dikonfirmasi')

@section('content')
<div class="success-container">
    <div class="success-card">
        
        <div class="success-header">
            <span class="status-label">PESANAN DIKONFIRMASI</span>
            <h1 class="success-title premium-serif">Terima Kasih !</h1>
            <p class="success-subtitle">Pesanan anda telah kami terima. Kode order :</p>
            <div class="order-badge">#VFD-6346</div>
        </div>

        <div class="transfer-box">
            <p class="bank-name">A a.n. Vybrasi</p>
            <div class="account-row">
                <span class="account-number" id="rekening">09876548576830</span>
                <button class="btn-copy" onclick="copyRekening()">Salin</button>
            </div>
            <p class="transfer-amount">Transfer tepat sesuai total : <span class="fw-bold">Rp 60.000</span></p>
        </div>

        <div class="wa-box">
            <p class="wa-text">Setelah tranfer, konfirmasi via WhatsApp dengan<br>kirim bukti bayar & kode order Anda.</p>
            <a href="https://wa.me/6283546795016" target="_blank" class="btn-wa">
                <i class="fa-brands fa-whatsapp"></i> Kirim Bukti
            </a>
        </div>

        <div class="success-action">
            <a href="{{ route('beranda') }}" class="btn-pesan-lagi">Pesan Lagi</a>
        </div>

    </div>
</div>

<script>
    function copyRekening() {
        var rekeningText = document.getElementById("rekening").innerText;
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
</script>
@endsection