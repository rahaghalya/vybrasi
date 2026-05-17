@extends('layouts.admin')

@section('content')
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
</style>

<div class="pesanan-baru-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h2 class="page-title" style="margin: 0; font-size: 20px; font-weight: 800; color: #fff; border-left: 4px solid #D4A373; padding-left: 12px;">KITCHEN DISPLAY (KANBAN)</h2>
        <span style="font-size: 12px; color: #888; background: #111; padding: 5px 10px; border-radius: 20px; border: 1px solid #222;">
            <i class="fas fa-sync-alt fa-spin" style="margin-right: 5px; color: #D4A373;"></i> Auto-update aktif
        </span>
    </div>

    <div class="kanban-board">
        
        {{-- KOLOM 1: PESANAN BARU MASUK --}}
        <div class="kanban-column" id="col-masuk">
            <div class="kanban-header">
                <h3>PESANAN BARU</h3>
                <span class="order-count" id="count-masuk">{{ count($masuk) }}</span>
            </div>
            <div class="kanban-body">
                @foreach($masuk->sortByDesc('created_at') as $trx)
                    <div class="receipt-card" id="order-{{ $trx->id_transaksi }}">
                        <div class="receipt-header">
                            <span class="order-id">{{ $trx->no_invoice }}</span>
                            <span class="order-timer"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($trx->created_at)->diffForHumans() }}</span>
                        </div>
                        
                        <div class="receipt-customer text-white-force">
                            <i class="fas fa-user-circle" style="color: #D4A373; font-size: 18px;"></i> 
                            {{ $trx->nama_pelanggan }}
                        </div>

                        <div class="receipt-items">
                            @foreach($trx->items as $item)
                                <div class="item-row">
                                    <span class="item-qty" style="color:#D4A373">{{ $item->jumlah }}x</span>
                                    <span class="item-name" style="color:#ccc">{{ current(explode(' ', $item->nama_produk)) }}...</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="aksi-buttons" id="action-{{ $trx->id_transaksi }}">
                            {{-- UBAH: Panggil Modal Upload Bukti --}}
                            <button class="btn-terima" onclick="bukaModalBukti('{{ $trx->id_transaksi }}')">PROSES SEKARANG</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- KOLOM 2: SEDANG DISIAPKAN --}}
        <div class="kanban-column" id="col-racik">
            <div class="kanban-header" style="border-bottom-color: #f59e0b;">
                <h3>SEDANG DISIAPKAN</h3>
                <span class="order-count" style="background: rgba(245,158,11,.1); color: #f59e0b;">{{ count($racik) }}</span>
            </div>
            <div class="kanban-body">
                @foreach($racik->sortByDesc('created_at') as $trx)
                    <div class="receipt-card status-processing" id="order-{{ $trx->id_transaksi }}">
                        <div class="receipt-header">
                            <span class="order-id">{{ $trx->no_invoice }}</span>
                            <span class="order-timer"><i class="fas fa-fire" style="color: #f59e0b;"></i> Diramu</span>
                        </div>
                        
                        <div class="receipt-customer text-white-force">
                            <i class="fas fa-user-circle" style="color: #f59e0b; font-size: 18px;"></i> 
                            {{ $trx->nama_pelanggan }}
                        </div>

                        <div class="receipt-items">
                            @foreach($trx->items as $item)
                                <div class="item-row">
                                    <span class="item-qty" style="color:#f59e0b">{{ $item->jumlah }}x</span>
                                    <span class="item-name" style="color:#ccc">{{ current(explode(' ', $item->nama_produk)) }}...</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="aksi-buttons" id="action-{{ $trx->id_transaksi }}">
                            {{-- UBAH: Panggil Modal Cetak Barcode --}}
                            <button class="btn-terima" style="background:#f59e0b;" onclick="bukaModalBarcode('{{ $trx->id_transaksi }}')"><i class="fas fa-barcode"></i> GENERATE BARCODE</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- KOLOM 3: SIAP DIKIRIM / SELESAI --}}
        <div class="kanban-column" id="col-siap">
            <div class="kanban-header" style="border-bottom-color: #10b981;">
                <h3>SIAP KIRIM / SELESAI</h3>
                <span class="order-count" style="background: rgba(16,185,129,.1); color: #10b981;">{{ count($siap) }}</span>
            </div>
            <div class="kanban-body">
                @foreach($siap->sortByDesc('created_at') as $trx)
                    <div class="receipt-card status-ready" id="order-{{ $trx->id_transaksi }}">
                        <div class="receipt-header">
                            <span class="order-id" style="color: #10b981;">{{ $trx->no_invoice }}</span>
                            <span class="order-timer"><i class="fas fa-check-circle" style="color: #10b981;"></i> Selesai</span>
                        </div>
                        
                        <div class="receipt-customer text-white-force">
                            <i class="fas fa-check-circle" style="color: #10b981; font-size: 18px;"></i> 
                            {{ $trx->nama_pelanggan }}
                        </div>

                        <div class="aksi-buttons">
                            <span style="font-size:12px; color:#888;">Lihat di menu Pengiriman</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- MODAL 1: UPLOAD BUKTI PEMBAYARAN --}}
<div id="modalBuktiBayar" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head">
            <h3 style="margin:0; color:#D4A373;"><i class="fas fa-file-invoice-dollar"></i> Validasi Pembayaran</h3>
            <button onclick="tutupModal('modalBuktiBayar')" class="btn-close">&times;</button>
        </div>
        <div class="modal-body">
            <p style="color: #aaa; font-size: 13px; margin-top: 0;">Silakan unggah bukti transfer/pembayaran dari WhatsApp sebelum memproses pesanan ini ke Dapur.</p>
            <input type="hidden" id="trx-id-bukti">
            <div style="background: #0a0a0a; padding: 15px; border-radius: 8px; border: 1px dashed #333; text-align: center;">
                <input type="file" id="fileBuktiBayar" accept="image/*" style="color: #fff; font-size: 12px;">
            </div>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button onclick="tutupModal('modalBuktiBayar')" style="flex:1; background: transparent; color: #888; border: 1px solid #333; border-radius: 6px; padding: 10px; cursor:pointer;">Batal</button>
                <button onclick="prosesDenganBukti()" style="flex:1; background: #D4A373; color: #111; border: none; border-radius: 6px; padding: 10px; font-weight: bold; cursor:pointer;">Lanjutkan Proses</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 2: GENERATE BARCODE / CETAK RESI --}}
<div id="modalGenerateBarcode" class="modal-overlay">
    <div class="modal-box" style="text-align: center;">
        <div class="modal-head" style="justify-content: center;">
            <h3 style="margin:0; color:#f59e0b;"><i class="fas fa-print"></i> Generate & Cetak Label</h3>
        </div>
        <div class="modal-body">
            <p style="color: #aaa; font-size: 13px; margin-top: 0;">Pesanan selesai diramu! Anda wajib mencetak Barcode Pengiriman sebelum pesanan dipindah ke Siap Kirim.</p>
            <input type="hidden" id="trx-id-barcode">
            
            <i class="fas fa-barcode" style="font-size: 60px; color: #fff; margin: 20px 0;"></i>

            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button onclick="tutupModal('modalGenerateBarcode')" style="flex:1; background: transparent; color: #888; border: 1px solid #333; border-radius: 6px; padding: 10px; cursor:pointer;">Batal</button>
                <button onclick="cetakLaluPindah()" style="flex:2; background: #f59e0b; color: #111; border: none; border-radius: 6px; padding: 10px; font-weight: bold; cursor:pointer;"><i class="fas fa-print"></i> Cetak Resi & Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

{{-- TOAST NOTIFIKASI PESANAN BARU --}}
<div id="kds-toast" class="kds-toast-box"><i class="fas fa-bell ringing-bell" style="font-size: 20px;"></i><div style="display: flex; flex-direction: column;"><span style="font-size: 15px;">Pesanan Baru Masuk!</span><span style="font-size: 12px; font-weight: 500; color: #333;">Segera cek kolom Pesanan Baru.</span></div></div>

<script>
    // --- FUNGSI MODAL ---
    function bukaModalBukti(id) {
        document.getElementById('trx-id-bukti').value = id;
        document.getElementById('modalBuktiBayar').classList.add('show');
    }

    function bukaModalBarcode(id) {
        document.getElementById('trx-id-barcode').value = id;
        document.getElementById('modalGenerateBarcode').classList.add('show');
    }

    function tutupModal(id) {
        document.getElementById(id).classList.remove('show');
    }

    // --- LOGIKA TOMBOL MODAL ---
    function prosesDenganBukti() {
        const file = document.getElementById('fileBuktiBayar').files[0];
        if(!file) {
            alert("Harap masukkan foto bukti pembayaran terlebih dahulu!");
            return;
        }
        // Jika file ada, lanjutkan ke kolom racik
        let id = document.getElementById('trx-id-bukti').value;
        tutupModal('modalBuktiBayar');
        pindahStatus(id, 'shipped', 'col-racik');
    }

    function cetakLaluPindah() {
        let id = document.getElementById('trx-id-barcode').value;
        // Buka tab baru untuk print barcode
        window.open(`/admin/pengiriman/cetak-resi/${id}`, '_blank');
        
        // Pindah status ke Siap Kirim
        tutupModal('modalGenerateBarcode');
        pindahStatus(id, 'delivered', 'col-siap');
    }

    // --- FUNGSI ASLI PINDAH STATUS ---
    function pindahStatus(idTransaksi, statusBaru, targetKolomId) {
        const card = document.getElementById('order-' + idTransaksi);
        const targetBody = document.querySelector(`#${targetKolomId} .kanban-body`);
        card.style.opacity = '0.5';

        fetch(`/admin/pesanan-baru/update-status/${idTransaksi}/${statusBaru}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                targetBody.appendChild(card);
                card.style.opacity = '1';
                location.reload(); 
            }
        });
    }

    // Auto Refresh KDS
    document.addEventListener("DOMContentLoaded", function() {
        let currentPendingCount = parseInt(document.getElementById('count-masuk').innerText);
        let previousPendingCount = localStorage.getItem('vyb_pending_orders_count');
        if (previousPendingCount !== null && currentPendingCount > parseInt(previousPendingCount)) {
            const toast = document.getElementById('kds-toast');
            toast.classList.add('show');
            setTimeout(() => { toast.classList.remove('show'); }, 6000);
        }
        localStorage.setItem('vyb_pending_orders_count', currentPendingCount);
        setTimeout(() => { window.location.reload(); }, 30000);
    });
</script>

<style>
/* CSS SUPER KANBAN DARK (Tetap dipertahankan) */
*,*::before,*::after{box-sizing:border-box}
.pesanan-baru-container{padding:20px 28px;color:#fff;animation:fi .4s ease;height: 100vh;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.text-white-force { color: #ffffff !important; font-weight: 700 !important; opacity: 1 !important; text-shadow: 0 0 1px rgba(255,255,255,0.2); }
.kanban-board{display:grid;grid-template-columns:repeat(3, 1fr);gap:20px;height:calc(100vh - 120px);}
.kanban-column{background:#0d0d0d;border:1px solid #1a1a1a;border-radius:12px;display:flex;flex-direction:column;overflow:hidden}
.kanban-header{padding:15px 20px;background:#111;border-bottom:2px solid #D4A373;display:flex;justify-content:space-between;align-items:center}
.kanban-header h3{margin:0;font-size:14px;text-transform:uppercase;letter-spacing:1px;font-weight:800;color:#fff}
.order-count{background:rgba(212,163,115,.1);color:#D4A373;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:bold}
.kanban-body{padding:15px;flex:1;overflow-y:auto;display:flex;flex-direction:column;gap:15px}
.kanban-body::-webkit-scrollbar{width:4px}
.kanban-body::-webkit-scrollbar-thumb{background:#333;border-radius:10px}
.receipt-card{background:#111;border:1px solid #222;border-radius:10px;padding:15px;box-shadow:0 4px 10px rgba(0,0,0,.2);border-left:4px solid #D4A373;transition:.3s; animation: munculCard .5s ease;}
@keyframes munculCard { from{opacity:0; transform:scale(0.95)} to{opacity:1; transform:scale(1)} }
.receipt-card.status-processing{border-left-color:#f59e0b}
.receipt-card.status-ready{border-left-color:#10b981; opacity: 0.7;}
.receipt-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;border-bottom:1px dashed #333;padding-bottom:10px}
.order-id{font-family:monospace;font-weight:bold;font-size:14px;color:#D4A373}
.order-timer{font-size:11px;color:#888;display:flex;align-items:center;gap:4px}
.receipt-customer{font-size:15px;margin-bottom:12px;display:flex;align-items:center;gap:8px}
.item-row{display:flex;gap:10px;font-size:13px;margin-bottom:5px}
.item-qty{font-weight:700}
.aksi-buttons{display:flex;gap:10px;margin-top:15px;padding-top:15px;border-top:1px dashed #333}
.btn-terima{flex:1;background:#D4A373;color:#111;border:none;padding:8px;border-radius:6px;font-size:12px;font-weight:bold;cursor:pointer;transition:.2s}
.btn-terima:hover{opacity:0.8}

/* MODAL KHUSUS KANBAN */
.modal-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;z-index:9999}
.modal-overlay.show{display:flex}
.modal-box{background:#111;border:1px solid #333;width:90%;max-width:400px;border-radius:12px;overflow:hidden;animation:pop .3s ease}
@keyframes pop{from{transform:scale(.9);opacity:0}to{transform:scale(1);opacity:1}}
.modal-head{padding:15px 20px;border-bottom:1px solid #222;display:flex;justify-content:space-between;align-items:center}
.modal-body{padding:20px}
.btn-close{background:none;border:none;color:#fff;font-size:24px;cursor:pointer}

/* TOAST KDS NOTIFIKASI */
.kds-toast-box { position: fixed; top: 30px; right: -350px; background: #D4A373; color: #111; padding: 15px 25px; border-radius: 12px; font-weight: bold; font-size: 14px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); display: flex; align-items: center; gap: 15px; transition: right 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); z-index: 9999; }
.kds-toast-box.show { right: 30px; }
.ringing-bell { animation: ring 1s ease-in-out infinite; }
@keyframes ring { 0%, 100% { transform: rotate(0deg); } 25% { transform: rotate(15deg); } 75% { transform: rotate(-15deg); } }
</style>
@endsection