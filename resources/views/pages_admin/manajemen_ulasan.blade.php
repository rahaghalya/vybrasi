@extends('layouts.admin')

@section('content')
<style>
/* --- BASE LAYOUT --- */
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { 
    background: #0a0a0a !important; background-color: #0a0a0a !important; padding: 0 !important; margin: 0 !important; 
}
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
.inbox-wrapper { display: flex; height: 100vh; background: #0a0a0a; border-top: 1px solid #1a1a1a; overflow: hidden; }

/* --- SIDEBAR LIST --- */
.inbox-sidebar { width: 350px; background: #0d0d0d; border-right: 1px solid #1a1a1a; display: flex; flex-direction: column; height: 100vh; flex-shrink: 0; }
.inbox-header { padding: 20px; border-bottom: 1px solid #1a1a1a; }
.inbox-title { margin: 0; font-size: 18px; font-weight: 800; color: #fff; border-left: 3px solid #D4A373; padding-left: 10px; }
.badge-count { background: #ef4444; color: #fff; font-size: 11px; font-weight: bold; padding: 3px 8px; border-radius: 20px; }
.inbox-tabs { display: flex; padding: 10px 20px; gap: 8px; border-bottom: 1px solid #1a1a1a; }
.tab-btn { background: transparent; border: none; color: #666; font-size: 10px; font-weight: 700; text-transform: uppercase; cursor: pointer; padding: 6px 10px; border-radius: 20px; transition: .2s; }
.tab-btn.active { background: rgba(212,163,115,.1); color: #D4A373; }
.inbox-list-container { flex: 1; overflow-y: auto; }
.inbox-item { padding: 20px; border-bottom: 1px solid #161616; display: flex; gap: 15px; cursor: pointer; transition: .2s; position: relative; }
.inbox-item:hover { background: #111; }
.inbox-item.active { background: #1a1a1a; border-left: 3px solid #D4A373; }
.unread-dot { width: 8px; height: 8px; background: #ef4444; border-radius: 50%; position: absolute; top: 25px; right: 20px; }
.star-btn { font-size: 14px; color: #333; margin-top: 2px; }
.star-btn.starred { color: #D4A373; }

/* --- PANEL DETAIL --- */
.inbox-content { flex: 1; background: #0a0a0a; display: flex; flex-direction: column; height: 100vh; overflow: hidden; }
.empty-state { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
.message-view-wrapper { display: none; height: 100%; flex-direction: column; }
.message-header { padding: 30px 40px; border-bottom: 1px solid #1a1a1a; flex-shrink: 0; }
.message-body { flex: 1; padding: 30px 40px; font-size: 16px; color: #ccc; line-height: 1.8; overflow-y: auto; }

/* --- FOOTER AKSI --- */
.message-action-box { padding: 20px 40px 40px 40px; border-top: 1px solid #1a1a1a; background: #0d0d0d; display: flex; gap: 15px; justify-content: flex-end; flex-shrink: 0; }
.btn-action { padding: 12px 25px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; transition: .3s; display: flex; align-items: center; gap: 8px; border: none; }
.btn-publish { background: #D4A373; color: #111; }
.btn-hide { background: #222; color: #999; border: 1px solid #444; }
.btn-delete { background: transparent; color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); }
.btn-delete:hover { background: rgba(239, 68, 68, 0.1); border-color: #ef4444; }

/* --- CSS TOAST & MODAL --- */
#vyb-toast { 
    position: fixed !important; bottom: -100px; left: 50% !important; transform: translateX(-50%) !important; 
    background: #D4A373 !important; color: #111 !important; padding: 16px 35px !important; 
    border-radius: 50px !important; font-weight: 800 !important; z-index: 999999 !important; 
    box-shadow: 0 15px 50px rgba(0,0,0,0.8) !important; display: flex !important; align-items: center !important; gap: 12px !important;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) !important; visibility: hidden; opacity: 0;
}
#vyb-toast.show { bottom: 60px !important; visibility: visible !important; opacity: 1 !important; }
.toast-dark { background: #333 !important; color: #fff !important; border: 1px solid #444 !important; }

.vyb-modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(5px);
    display: flex; align-items: center; justify-content: center;
    z-index: 9999999; opacity: 0; visibility: hidden; transition: 0.3s;
}
.vyb-modal-overlay.show { opacity: 1; visibility: visible; }
.vyb-modal-box {
    background: #111; border: 1px solid #333; border-radius: 16px; padding: 30px;
    width: 400px; max-width: 90%; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    transform: scale(0.9); transition: 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}
.vyb-modal-overlay.show .vyb-modal-box { transform: scale(1); }
.vyb-modal-icon { font-size: 50px; color: #ef4444; margin-bottom: 15px; }
.vyb-modal-title { color: #fff; font-size: 20px; font-weight: 800; margin: 0 0 10px; }
.vyb-modal-text { color: #888; font-size: 14px; margin: 0 0 25px; line-height: 1.5; }
.vyb-modal-actions { display: flex; gap: 10px; justify-content: center; }
.btn-modal-cancel { background: #222; color: #ccc; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; flex: 1; transition: 0.2s; }
.btn-modal-cancel:hover { background: #333; color: #fff; }
.btn-modal-confirm { background: #ef4444; color: #fff; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 700; cursor: pointer; flex: 1; transition: 0.2s; }
.btn-modal-confirm:hover { background: #dc2626; }
</style>

<div class="inbox-wrapper">
    {{-- SIDEBAR LIST ULASAN --}}
    <div class="inbox-sidebar">
        <div class="inbox-header">
            <h2 class="inbox-title">Ulasan Produk</h2>
            <span id="unread-badge" class="badge-count" style="display: none;">0</span>
        </div>
        <div class="inbox-tabs">
            <button class="tab-btn active" onclick="filterMessages('semua', this)">Semua</button>
            <button class="tab-btn" onclick="filterMessages('belum_dibaca', this)">Baru</button>
            <button class="tab-btn" onclick="filterMessages('testimoni', this)">Live</button>
        </div>
        <div class="inbox-list-container">
            @forelse($ulasans as $ulasan)
                @php 
                    $safeId = $ulasan->id_ulasan; 
                    // Logika dibalik: Jika is_hidden false, berarti tampil (live)
                    $isTampil = !($ulasan->is_hidden ?? false);
                @endphp
                <div class="inbox-item {{ $isTampil ? 'is-testimony' : '' }}" id="msg-{{ $safeId }}" onclick="viewMessage('{{ $safeId }}')">
                    <div class="unread-dot" id="dot-{{ $safeId }}"></div>
                    <i class="fas fa-star star-btn {{ $isTampil ? 'starred' : '' }}" id="star-{{ $safeId }}"></i>
                    <div class="item-content">
                        <div class="item-name" style="color: #fff; font-weight: 700; font-size: 14px;">{{ $ulasan->nama_pelanggan ?? 'Pengguna' }}</div>
                        <div style="font-size: 11px; color: #D4A373; margin-bottom: 4px; font-weight: 600;">
                            <i class="fa-solid fa-box" style="font-size: 9px; margin-right:3px;"></i> 
                            {{ $ulasan->nama_produk ?? 'Produk Dihapus' }}
                        </div>
                        <div style="font-size: 12px; color: #888;">{{ Str::limit($ulasan->komentar, 35) }}</div>
                    </div>
                </div>
                
                {{-- Data Tersembunyi untuk JS --}}
                <div id="data-{{ $safeId }}" style="display: none;">
                    <div class="d-nama">{{ $ulasan->nama_pelanggan ?? 'Pengguna' }}</div>
                    <div class="d-produk">{{ $ulasan->nama_produk ?? 'Produk Tidak Ditemukan' }}</div>
                    <div class="d-tanggal">{{ isset($ulasan->created_at) ? \Carbon\Carbon::parse($ulasan->created_at)->translatedFormat('d F Y, H:i') : '' }}</div>
                    <div class="d-rating">{{ $ulasan->rating ?? 5 }}</div>
                    <div class="d-judul">{{ $ulasan->judul ?? 'Ulasan' }}</div>
                    <div class="d-komentar">{{ $ulasan->komentar }}</div>
                    <div class="d-is-tampil">{{ $isTampil ? '1' : '0' }}</div>
                </div>
            @empty
                <p style="text-align: center; color: #555; padding: 40px;">Belum ada ulasan produk.</p>
            @endforelse
        </div>
    </div>

    {{-- KONTEN DETAIL ULASAN --}}
    <div class="inbox-content">
        <div id="empty-view" class="empty-state">
            <i class="fas fa-star-half-alt" style="font-size: 48px; color: #D4A373; margin-bottom: 15px;"></i>
            <h4 style="color: #fff;">Pilih Ulasan</h4>
            <p style="color: #666; font-size: 14px;">Klik ulasan di samping untuk melihat detail dan melakukan moderasi.</p>
        </div>
        
        <div id="message-view" class="message-view-wrapper">
            <div class="message-header">
                <h3 id="view-nama" style="color: #fff; font-size: 22px; font-weight: 800; margin-bottom: 5px;">Nama</h3>
                <div style="color: #D4A373; font-size: 13px; font-weight: 600; margin-bottom: 10px;">
                    <i class="fa-solid fa-box-open" style="margin-right: 5px;"></i> <span id="view-produk">Produk</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span id="view-rating" style="color: #f59e0b; font-size: 14px;"></span>
                    <p style="margin: 0; color: #666; font-size: 13px;">&bull; <span id="view-tanggal"></span></p>
                </div>
            </div>
            
            <div class="message-body">
                <strong id="view-judul" style="color: #fff; display: block; margin-bottom: 10px; font-size: 18px;"></strong>
                <span id="view-komentar"></span>
            </div>
            
            <div class="message-action-box">
                <button class="btn-action btn-delete" onclick="konfirmasiHapus()"><i class="fas fa-trash-alt"></i> Hapus Ulasan</button>
                <button id="btn-toggle-status" class="btn-action" onclick="toggleUlasan()"></button>
            </div>
        </div>
    </div>
</div>

{{-- HTML TOAST & MODAL --}}
<div id="vyb-toast">
    <i id="toast-icon" class="fas fa-check-circle"></i>
    <span id="toast-text">Berhasil!</span>
</div>

<div id="custom-modal" class="vyb-modal-overlay">
    <div class="vyb-modal-box">
        <div class="vyb-modal-icon"><i class="fas fa-exclamation-circle"></i></div>
        <h3 class="vyb-modal-title">Hapus Ulasan?</h3>
        <p class="vyb-modal-text">Ulasan ini akan dihapus secara permanen dari database dan produk.</p>
        <div class="vyb-modal-actions">
            <button class="btn-modal-cancel" onclick="tutupModal()">Batal</button>
            <button class="btn-modal-confirm" id="btn-confirm-delete">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    let currentMessageId = null;

    function viewMessage(id) {
        document.getElementById('empty-view').style.display = 'none';
        document.getElementById('message-view').style.display = 'flex';
        document.querySelectorAll('.inbox-item').forEach(i => i.classList.remove('active'));
        document.getElementById('msg-' + id).classList.add('active');
        
        const data = document.getElementById('data-' + id);
        document.getElementById('view-nama').innerText = data.querySelector('.d-nama').innerText;
        document.getElementById('view-produk').innerText = data.querySelector('.d-produk').innerText;
        document.getElementById('view-tanggal').innerText = data.querySelector('.d-tanggal').innerText;
        document.getElementById('view-judul').innerText = data.querySelector('.d-judul').innerText;
        document.getElementById('view-komentar').innerText = data.querySelector('.d-komentar').innerText;
        
        const r = parseInt(data.querySelector('.d-rating').innerText);
        let h = ''; for(let i=1; i<=5; i++) h += (i <= r) ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
        document.getElementById('view-rating').innerHTML = h;

        currentMessageId = id;
        updateToggleBtnUI(data.querySelector('.d-is-tampil').innerText === '1');
        
        const dot = document.getElementById('dot-' + id);
        if(dot) dot.style.display = 'none';
        
        markAsRead(id);
    }

    function updateToggleBtnUI(isTampil) {
        const btn = document.getElementById('btn-toggle-status');
        if (isTampil) {
            btn.className = 'btn-action btn-hide';
            btn.innerHTML = '<i class="fas fa-eye-slash"></i> Sembunyikan dari Web';
        } else {
            btn.className = 'btn-action btn-publish';
            btn.innerHTML = '<i class="fas fa-star"></i> Tampilkan di Web';
        }
    }

    function toggleUlasan() {
        if (!currentMessageId) return;
        fetch(`/admin/ulasan/toggle/${currentMessageId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const star = document.getElementById('star-' + currentMessageId);
                const dataBox = document.getElementById('data-' + currentMessageId);
                
                // Karena data.is_hidden dibalik
                const isSekarangTampil = !data.is_hidden;
                dataBox.querySelector('.d-is-tampil').innerText = isSekarangTampil ? '1' : '0';
                
                if (isSekarangTampil) {
                    star.classList.add('starred');
                    showToast('Ulasan LIVE di Halaman Produk!', 'fas fa-globe', false);
                } else {
                    star.classList.remove('starred');
                    showToast('Ulasan disembunyikan', 'fas fa-eye-slash', true);
                }
                updateToggleBtnUI(isSekarangTampil);
            }
        });
    }

    function konfirmasiHapus() {
        if (!currentMessageId) return;
        document.getElementById('custom-modal').classList.add('show');
        document.getElementById('btn-confirm-delete').onclick = function() { eksekusiHapus(); };
    }

    function tutupModal() {
        document.getElementById('custom-modal').classList.remove('show');
    }

    function eksekusiHapus() {
        const btnConfirm = document.getElementById('btn-confirm-delete');
        btnConfirm.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
        btnConfirm.disabled = true;

        fetch(`/admin/ulasan/hapus/${currentMessageId}`, {
            method: 'DELETE', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const item = document.getElementById('msg-' + currentMessageId);
                if(item) item.remove();
                document.getElementById('message-view').style.display = 'none';
                document.getElementById('empty-view').style.display = 'flex';
                tutupModal();
                showToast('Ulasan Dihapus Permanen', 'fas fa-trash-alt', true);
                currentMessageId = null;
                updateUnreadCount();
            }
        })
        .catch(error => {
            tutupModal();
            showToast('Gagal Menghapus (Error Server)', 'fas fa-exclamation-triangle', true);
        })
        .finally(() => {
            btnConfirm.innerHTML = 'Ya, Hapus';
            btnConfirm.disabled = false;
        });
    }

    function showToast(txt, icon, isDark) {
        const t = document.getElementById('vyb-toast');
        document.getElementById('toast-text').innerText = txt;
        document.getElementById('toast-icon').className = icon;
        if(isDark) t.classList.add('toast-dark'); else t.classList.remove('toast-dark');
        t.classList.add('show');
        setTimeout(() => { t.classList.remove('show'); }, 3000);
    }

    function markAsRead(id) {
        let read = JSON.parse(localStorage.getItem('vyb_ulasan_read')) || [];
        if (!read.includes(id)) { read.push(id); localStorage.setItem('vyb_ulasan_read', JSON.stringify(read)); }
        updateUnreadCount();
    }

    function updateUnreadCount() {
        let c = 0; 
        document.querySelectorAll('.unread-dot').forEach(d => {
            if (window.getComputedStyle(d).display !== 'none') { 
                c++; 
                d.closest('.inbox-item').classList.add('is-unread'); 
            } else { 
                d.closest('.inbox-item').classList.remove('is-unread'); 
            }
        });
        
        const b = document.getElementById('unread-badge'); 
        if(b) { b.innerText = c; b.style.display = c > 0 ? 'inline-block' : 'none'; }
    }

    function filterMessages(type, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.inbox-item').forEach(item => {
            if (type === 'semua') item.style.display = 'flex';
            else if (type === 'testimoni') item.style.display = item.classList.contains('is-testimony') ? 'flex' : 'none';
            else if (type === 'belum_dibaca') item.style.display = item.classList.contains('is-unread') ? 'flex' : 'none';
        });
    }

    document.addEventListener("DOMContentLoaded", () => {
        let read = JSON.parse(localStorage.getItem('vyb_ulasan_read')) || [];
        document.querySelectorAll('.inbox-item').forEach(item => {
            if (read.includes(item.id.replace('msg-', ''))) {
                let d = document.getElementById('dot-' + item.id.replace('msg-', ''));
                if (d) d.style.display = 'none';
            }
        });
        updateUnreadCount();
    });
</script>
@endsection