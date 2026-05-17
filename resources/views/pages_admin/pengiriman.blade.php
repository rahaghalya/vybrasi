@extends('layouts.admin')

@section('content')
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
</style>

<div class="wrap">
    <h2 class="page-title">LIST PENGIRIMAN PAKET</h2>

    <div class="kpi-row">
        <div class="kpi amber-bar"><div class="kpi-ic amber"><i class="fa-solid fa-box"></i></div><div><p class="kpi-lbl">Siap Kirim</p><h3>{{ $countSiap }} <span class="unit">Pesanan</span></h3></div></div>
        <div class="kpi blue-bar"><div class="kpi-ic blue"><i class="fa-solid fa-truck-fast"></i></div><div><p class="kpi-lbl">Dalam Perjalanan</p><h3>{{ $countJalan }} <span class="unit">Paket</span></h3></div></div>
        <div class="kpi green-bar"><div class="kpi-ic green"><i class="fa-solid fa-house-chimney-check"></i></div><div><p class="kpi-lbl">Tiba di Tujuan</p><h3>{{ $countTiba }} <span class="unit">Selesai</span></h3></div></div>
    </div>

    <div class="toolbar mt-18">
        <form action="{{ route('admin.pengiriman') }}" method="GET" style="display: flex; gap: 15px; width: 100%;">
            <div class="search-box"><i class="fas fa-search mu"></i><input type="text" name="search" class="inp-search" placeholder="Cari No. Invoice..." value="{{ request('search') }}"></div>
            <div class="search-box" style="width: auto;">
                <select name="status" class="inp-search" style="margin-left:0; cursor:pointer;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Siap Kirim</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Perjalanan</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Tiba</option>
                </select>
            </div>
        </form>
    </div>

    <div class="card mt-18">
        <table class="dtable">
            <thead>
                <tr><th>Invoice</th><th>Penerima</th><th>Alamat Tujuan</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($allPengiriman as $p)
                @php
                    $penerima = 'User'; $alamat = '-';
                    if (preg_match('/Penerima:\s*([^|]+)/', $p->catatan, $m)) $penerima = trim($m[1]);
                    if (preg_match('/Alamat:\s*(.+)/', $p->catatan, $m)) $alamat = trim($m[1]);
                @endphp
                <tr>
                    <td><span class="mono">{{ $p->no_invoice }}</span></td>
                    <td class="fw text-white-force">{{ $penerima }}</td>
                    <td class="mu" style="max-width: 250px; line-height: 1.4;">{{ Str::limit($alamat, 60) }}</td>
                    <td>
                        @if($p->status == 'pending') <span class="bdg warn">Siap Kirim</span>
                        @elseif($p->status == 'shipped') <span class="bdg info">Dikirim</span>
                        @else <span class="bdg succ">Tiba</span> @endif
                    </td>
                    <td>
                        {{-- Simpan html barcode tersembunyi agar bisa dilempar ke Javascript Modal --}}
                        <div id="barcode-html-{{ $p->id_transaksi }}" style="display:none;">{!! DNS1D::getBarcodeHTML($p->no_invoice, 'C39', 1.5, 30) !!}</div>
                        <button type="button" class="btn-ol" onclick="openEditModal('{{ $p->id_transaksi }}', '{{ $p->no_invoice }}', '{{ $penerima }}', '{{ $alamat }}', '{{ $p->status }}')">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="empty">Tidak ada pengiriman aktif.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-head"><h3 class="gold"><i class="fas fa-truck-fast"></i> UPDATE PENGIRIMAN</h3><button onclick="closeEditModal()" type="button" class="btn-close">&times;</button></div>
        <form action="{{ route('admin.pengiriman.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id_transaksi" id="m-id">
                <input type="hidden" name="status_pengiriman" id="m-status">
                
                <div class="track-info">
                    <p>Invoice: <strong id="m-invoice" class="gold"></strong></p>
                    <p>Tujuan: <strong id="m-penerima"></strong></p>
                    <p class="mu" id="m-alamat" style="font-size: 12px; margin-bottom: 10px;"></p>
                    
                    {{-- AREA BARCODE DI DALAM MODAL --}}
                    <div style="background: #fff; padding: 10px; text-align: center; border-radius: 6px;">
                        <div id="m-barcode-container" style="display: inline-block;"></div>
                    </div>
                </div>
                
                <div class="timeline mt-18">
                    <p class="kpi-lbl" style="margin-bottom: 15px;">Pilih Status Pengiriman:</p>
                    <div class="tl-item clickable-tl" id="tl-shipped" onclick="pilihStatus('shipped')"><div class="tl-dot"></div><div><p class="fw">Dalam Perjalanan (Dikirim)</p><span class="mu">Kurir sedang menuju lokasi pelanggan</span></div></div>
                    <div class="tl-item clickable-tl" id="tl-delivered" onclick="pilihStatus('delivered')"><div class="tl-dot"></div><div><p class="fw">Tiba di Tujuan (Selesai)</p><span class="mu">Pesanan telah diterima oleh pelanggan</span></div></div>
                </div>

                <div class="mt-18" style="background: #0a0a0a; padding: 15px; border-radius: 10px; border: 1px solid #1e1e1e;">
                    <label class="kpi-lbl"><i class="fas fa-camera"></i> Upload Bukti Pengiriman (Opsional)</label>
                    <input type="file" name="bukti_pengiriman" accept="image/*" class="inp-search" style="width: 100%; margin-left:0; margin-top:8px; padding: 0; cursor: pointer;">
                    <p style="font-size: 11px; color:#555; margin-top: 8px; margin-bottom: 0;">*Format: JPG/PNG. Maks 2MB.</p>
                </div>

                <div class="mt-18" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeEditModal()" class="btn-ol" style="border-color: #333; color: #888;">Batal</button>
                    <button type="submit" class="btn-ol" style="background: #D4A373; color: #111; border: none;"><i class="fas fa-save"></i> Simpan Status</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* CSS IDENTIK BERANDA & PENGIRIMAN */
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}
.gold{color:#D4A373 !important} .mu{color:#777 !important} .fw{color:#fff;font-weight:600;margin:0 0 3px 0;} .mt-18{margin-top:18px}
.text-white-force{color:#fff !important}
.kpi-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:18px}
.kpi{background:#111;border:1px solid #1e1e1e;border-radius:12px;padding:18px;display:flex;align-items:center;gap:14px;position:relative;overflow:hidden}
.kpi::before{content:'';position:absolute;left:0;top:0;width:4px;height:100%}
.amber-bar::before{background:#f59e0b}.blue-bar::before{background:#3b82f6}.green-bar::before{background:#10b981}
.kpi-ic{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;background:rgba(212,163,115,.1);color:#D4A373}
.kpi-ic.amber{background:rgba(245,158,11,.1);color:#f59e0b}.kpi-ic.blue{background:rgba(59,130,246,.1);color:#3b82f6}.kpi-ic.green{background:rgba(16,185,129,.1);color:#10b981}
.kpi-lbl{margin:0 0 4px;font-size:11px;color:#888;font-weight:700;text-transform:uppercase}
.kpi h3{margin:0;font-size:19px;font-weight:800} .unit{font-size:12px;color:#666}
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}
.dtable{width:100%;border-collapse:collapse}
.dtable th{background:#0d0d0d;color:#D4A373;font-size:11px;font-weight:700;text-transform:uppercase;padding:15px 20px;text-align:left;border-bottom:1px solid #1a1a1a}
.dtable td{padding:15px 20px;border-bottom:1px solid #161616;font-size:14px;vertical-align:middle}
.mono{background:#0a0a0a;border:1px solid #333;padding:4px 8px;border-radius:6px;font-family:monospace;color:#D4A373}
.bdg{padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700}
.warn{background:rgba(245,158,11,.1);color:#f59e0b;border:1px solid rgba(245,158,11,.2)}
.info{background:rgba(59,130,246,.1);color:#3b82f6;border:1px solid rgba(59,130,246,.2)}
.succ{background:rgba(16,185,129,.1);color:#10b981;border:1px solid rgba(16,185,129,.2)}
.modal-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.8);display:none;align-items:center;justify-content:center;z-index:9999}
.modal-overlay.show{display:flex}
.modal-box{background:#111;border:1px solid #333;width:90%;max-width:450px;border-radius:16px;overflow:hidden;animation:pop .3s ease}
@keyframes pop{from{transform:scale(.9);opacity:0}to{transform:scale(1);opacity:1}}
.modal-head{padding:20px;border-bottom:1px solid #222;display:flex;justify-content:space-between;align-items:center}
.modal-body{padding:20px}
.track-info{background:#0a0a0a;padding:15px;border-radius:10px;border:1px solid #1e1e1e}
.track-info p{margin:0 0 5px;font-size:13px}
.btn-close{background:none;border:none;color:#fff;font-size:24px;cursor:pointer}
.btn-ol{background:transparent;border:1px solid #D4A373;color:#D4A373;padding:7px 14px;border-radius:6px;font-size:12px;font-weight:600;cursor:pointer;transition:.2s}
.btn-ol:hover{background:#D4A373;color:#111}
.search-box{background:#0a0a0a;border:1px solid #2a2a2a;padding:10px 15px;border-radius:8px;display:flex;align-items:center;gap:10px;width:300px}
.inp-search{background:transparent;border:none;color:#fff;outline:none;width:100%;font-size:13px;font-family:inherit}
.inp-search option { background: #111; color: #fff; }
.timeline { position: relative; padding-left: 10px; }
.tl-item { display: flex; gap: 15px; margin-bottom: 20px; position: relative; }
.clickable-tl { cursor: pointer; padding: 10px; border-radius: 8px; transition: 0.3s; border: 1px solid transparent; }
.clickable-tl:hover { background: #1a1a1a; }
.tl-dot { width: 12px; height: 12px; background: #222; border-radius: 50%; margin-top: 5px; flex-shrink: 0; z-index: 2; transition: 0.3s; }
.tl-item::before { content: ''; position: absolute; left: 15.5px; top: 25px; bottom: -25px; width: 1px; background: #222; z-index: 1; transition: 0.3s; }
.tl-item:last-child::before { display: none; }
.tl-item.active .tl-dot { background: #D4A373; box-shadow: 0 0 8px #D4A373; }
.tl-item.active::before { background: #D4A373; } 
.tl-item.current .tl-dot { background: #3b82f6; box-shadow: 0 0 8px #3b82f6; }
.tl-item.current { background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.3); }
.tl-item.done .tl-dot { background: #10b981; box-shadow: 0 0 8px #10b981; }
.tl-item.done { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); }
</style>

<script>
    function openEditModal(id_transaksi, inv, nama, alamat, status) {
        document.getElementById('m-id').value = id_transaksi;
        document.getElementById('m-invoice').innerText = inv;
        document.getElementById('m-penerima').innerText = nama;
        document.getElementById('m-alamat').innerText = alamat;
        
        // Panggil barcode dari div yang tersembunyi
        let barcodeHtml = document.getElementById('barcode-html-' + id_transaksi).innerHTML;
        document.getElementById('m-barcode-container').innerHTML = barcodeHtml;

        let setStatus = status === 'pending' ? 'shipped' : status;
        pilihStatus(setStatus);
        document.getElementById('editModal').classList.add('show');
    }

    function closeEditModal() { document.getElementById('editModal').classList.remove('show'); }

    function pilihStatus(status) {
        document.getElementById('m-status').value = status;
        const tlShipped = document.getElementById('tl-shipped');
        const tlDelivered = document.getElementById('tl-delivered');
        tlShipped.classList.remove('active', 'current', 'done');
        tlDelivered.classList.remove('active', 'current', 'done');
        if (status === 'shipped') { tlShipped.classList.add('current'); } 
        else if (status === 'delivered') { tlShipped.classList.add('active'); tlDelivered.classList.add('done'); }
    }
</script>
@endsection