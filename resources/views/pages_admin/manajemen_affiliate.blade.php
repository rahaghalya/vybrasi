@extends('layouts.admin')

@section('content')
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
</style>

<div class="wrap">
    <h2 class="page-title">DAFTAR MITRA AFFILIATE</h2>

    {{-- TOOLBAR --}}
    <div class="toolbar mt-18">
        <div class="search-box">
            <i class="fas fa-search" style="color: #888;"></i>
            <input type="text" class="inp-search" id="searchInput" placeholder="Cari Affiliate...">
        </div>
        <a href="{{ route('admin.affiliate.tambah') }}" class="btn-submit" style="text-decoration: none;">
            <i class="fas fa-plus"></i> TAMBAH MITRA/AFFILIATE
        </a>
    </div>

    {{-- FILTER TABS STATUS --}}
    <div class="filter-tabs mt-18">
        <a href="{{ route('admin.affiliate') }}" class="tab {{ request('status') == '' ? 'active' : '' }}">
            Semua
        </a>
        <a href="{{ route('admin.affiliate', ['status' => 'active']) }}" class="tab {{ request('status') == 'active' ? 'active' : '' }}">
            <span class="dot dot-approved"></span> Aktif
        </a>
        <a href="{{ route('admin.affiliate', ['status' => 'inactive']) }}" class="tab {{ request('status') == 'inactive' ? 'active' : '' }}">
            <span class="dot dot-rejected"></span> Nonaktif
        </a>
        <a href="{{ route('admin.affiliate', ['status' => 'suspended']) }}" class="tab {{ request('status') == 'suspended' ? 'active' : '' }}">
            <span class="dot dot-pending"></span> Ditangguhkan
        </a>
    </div>

    {{-- TABEL AFFILIATE --}}
    <div class="card mt-18">
        <table class="dtable" id="affiliateTable">
            <thead>
                <tr>
                    <th>ID Affiliate</th>
                    <th>Nama Lengkap</th>
                    <th>Kode Referral</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($affiliates as $aff)
                <tr class="aff-row">
                    <td style="white-space: nowrap;"><span class="mono">{{ $aff->id }}</span></td>
                    <td class="fw aff-nama" style="white-space: nowrap;">{{ $aff->full_name }}</td>
                    <td class="gold" style="font-size: 13px; white-space: nowrap;">
                        @if($aff->kode_unik)
                            <i class="fas fa-tag"></i> {{ $aff->kode_unik }}
                        @else
                            <span class="mu" style="font-size: 12px;">Belum ada kode</span>
                        @endif
                    </td>
                    <td style="white-space: nowrap; text-align: center;">
                        @if($aff->status_affiliate === 'active')
                            <span class="bdg succ">Aktif</span>
                        @elseif($aff->status_affiliate === 'suspended')
                            <span class="bdg warn">Ditangguhkan</span>
                        @else
                            <span class="bdg dang">Nonaktif</span>
                        @endif
                    </td>
                    <td style="white-space: nowrap; text-align: center;">
                        <a href="{{ route('admin.affiliate.profil', $aff->id) }}" class="btn-ol">Lihat Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty">Belum ada data mitra affiliate yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- POPUP NOTIFIKASI AFFILIATE BARU --}}
@if(session('affiliate_baru'))
@php $baru = session('affiliate_baru'); @endphp
<div class="popup-overlay" id="popupAffiliate">
    <div class="popup-box">
        <div class="popup-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3 class="popup-title">Mitra Berhasil Ditambahkan!</h3>
        <p class="popup-sub">Berikut informasi akun yang perlu diberikan ke mitra:</p>

        <div class="popup-info">
            <div class="info-row">
                <span class="info-label"><i class="fas fa-user"></i> Nama</span>
                <span class="info-val">{{ $baru['nama'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                <span class="info-val">{{ $baru['email'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-lock"></i> Password</span>
                <span class="info-val pw-val" id="pwValue">{{ $baru['password'] }}</span>
                <button class="copy-btn" onclick="copyText('pwValue', this)" title="Salin password">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="fas fa-tag"></i> Kode Referral</span>
                <span class="info-val">{{ $baru['kode'] }}</span>
            </div>
        </div>

        <div class="popup-warn">
            <i class="fas fa-triangle-exclamation"></i>
            Simpan dan kirimkan informasi ini ke mitra. Password tidak akan ditampilkan lagi.
        </div>

        <button class="popup-close-btn" onclick="tutupPopup()">
            <i class="fas fa-check"></i> Sudah Dicatat, Tutup
        </button>
    </div>
</div>
@endif

{{-- NOTIFIKASI PENGAJUAN DANA BARU --}}
<div id="payoutNotify" class="payout-toast" style="display:none;">
    <div class="p-icon"><i class="fas fa-bell"></i></div>
    <div class="p-text">
        <strong>Pengajuan Komisi Baru!</strong>
        <p id="p-msg">Ada mitra baru mengajukan penarikan dana.</p>
    </div>
    <a href="{{ route('admin.payout.index') }}" class="p-btn">Lihat</a>
</div>

<script>
// Search filter lokal
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.aff-row').forEach(row => {
        const nama = row.querySelector('.aff-nama')?.textContent.toLowerCase() ?? '';
        row.style.display = nama.includes(q) ? '' : 'none';
    });
});

function tutupPopup() { document.getElementById('popupAffiliate').style.display = 'none'; }

function copyText(elId, btn) {
    const text = document.getElementById(elId).textContent.trim();
    navigator.clipboard.writeText(text).then(() => {
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.style.color = '#4ade80';
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-copy"></i>';
            btn.style.color = '';
        }, 2000);
    });
}

document.getElementById('popupAffiliate')?.addEventListener('click', function(e) {
    if (e.target === this) tutupPopup();
});

// Pengecekan Payout Notifikasi
function checkPayout() {
    fetch('/admin/api/check-payout-pending')
        .then(response => response.ok ? response.json() : null)
        .then(data => {
            if (data && data.has_new) {
                let match = data.message.match(/\d+/);
                let currentCount = match ? parseInt(match[0]) : 1;
                let lastNotifiedCount = parseInt(localStorage.getItem('vyb_payout_count')) || 0;

                if (currentCount > lastNotifiedCount) {
                    document.getElementById('p-msg').innerText = data.message;
                    document.getElementById('payoutNotify').style.display = 'flex';
                    localStorage.setItem('vyb_payout_count', currentCount);
                    setTimeout(() => { document.getElementById('payoutNotify').style.display = 'none'; }, 10000);
                } else if (currentCount < lastNotifiedCount) {
                    localStorage.setItem('vyb_payout_count', currentCount);
                }
            } else {
                localStorage.setItem('vyb_payout_count', 0);
            }
        });
}

setTimeout(checkPayout, 3000);
setInterval(checkPayout, 30000);
</script>

<style>
/* CORE */
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.mt-18{margin-top:18px}
.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}

/* FILTER TABS (NEW) */
.filter-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:15px;}
.tab{padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;color:#666;background:#111;border:1px solid #1e1e1e;transition:.2s;display:flex;align-items:center;gap:6px}
.tab:hover{color:#fff;border-color:#333}
.tab.active{background:rgba(212,163,115,.1);color:#D4A373;border-color:rgba(212,163,115,.3)}
.dot{width:7px;height:7px;border-radius:50%;display:inline-block}
.dot-pending{background:#fbbf24}
.dot-approved{background:#4ade80}
.dot-rejected{background:#f87171}

.text-white-force{color:#fff!important;font-weight:700!important;opacity:1!important}
.text-gold-force{color:#D4A373!important;font-weight:700!important;opacity:1!important}

/* TOOLBAR */
.toolbar{display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap}
.search-box{display:flex;align-items:center;background:#111;border:1px solid #333;border-radius:8px;padding:10px 15px;width:100%;max-width:300px}
.inp-search{background:transparent;border:none;color:#fff;outline:none;width:100%;margin-left:10px;font-size:14px;font-family:inherit}
.inp-search::placeholder{color:#666}

/* TABLE */
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}
.dtable{width:100%;border-collapse:collapse}
.dtable th{background:#0d0d0d;color:#D4A373;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:15px 20px;text-align:left;border-bottom:1px solid #1a1a1a}
.dtable td{padding:15px 20px;border-bottom:1px solid #161616;vertical-align:middle}
.dtable tbody tr:hover{background:#141414}
.mono{background:#0a0a0a;border:1px solid #333;padding:4px 8px;border-radius:6px;font-family:monospace;color:#ccc;font-size:13px}
.empty{text-align:center;color:#888;padding:40px;font-style:italic}

/* BADGES & BUTTONS */
.btn-submit{background:#D4A373;border:none;color:#111;padding:11px 20px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:.2s;box-shadow:0 4px 10px rgba(212,163,115,0.2)}
.btn-submit:hover{background:#b58555;transform:translateY(-2px)}
.btn-ol{background:rgba(212,163,115,.05);border:1px solid rgba(212,163,115,.3);color:#D4A373;padding:7px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;transition:.2s}
.btn-ol:hover{background:#D4A373;color:#fff}
.bdg{padding:6px 12px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block}
.succ{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.3)}
.warn{background:rgba(251,191,36,.1);color:#fbbf24;border:1px solid rgba(251,191,36,.3)}
.dang{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.3)}
.fw { color: #ffffff !important; font-weight: 600 !important; }
.gold { color: #D4A373 !important; }
.mu { color: #aaaaaa !important; font-style: italic; }

/* POPUP STYLES */
.popup-overlay{position:fixed;inset:0;background:rgba(0,0,0,.75);backdrop-filter:blur(4px);z-index:9999;display:flex;align-items:center;justify-content:center;padding:20px;animation:fadeIn .3s ease}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
.popup-box{background:#111;border:1px solid rgba(212,163,115,.3);border-radius:16px;padding:32px 28px;max-width:460px;width:100%;text-align:center;animation:slideUp .3s ease;position:relative}
@keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.popup-icon{width:64px;height:64px;background:rgba(16,185,129,.1);border:2px solid rgba(16,185,129,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px;color:#4ade80}
.popup-title{margin:0 0 6px;font-size:20px;font-weight:800;color:#fff}
.popup-sub{margin:0 0 20px;color:#666;font-size:13px}
.popup-info{background:#0a0a0a;border:1px solid #1e1e1e;border-radius:10px;padding:16px;margin-bottom:16px;text-align:left}
.info-row{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #161616;font-size:13px}
.info-row:last-child{border-bottom:none}
.info-label{color:#666;min-width:110px;display:flex;align-items:center;gap:6px;flex-shrink:0}
.info-val{color:#fff;font-weight:600;flex:1;word-break:break-all}
.pw-val{font-family:monospace;color:#D4A373;font-size:15px;letter-spacing:1px}
.copy-btn{background:rgba(212,163,115,.1);border:1px solid rgba(212,163,115,.2);color:#D4A373;width:28px;height:28px;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:12px;transition:.2s;flex-shrink:0}
.copy-btn:hover{background:#D4A373;color:#111}
.popup-warn{background:rgba(251,191,36,.06);border:1px solid rgba(251,191,36,.2);color:#fbbf24;border-radius:8px;padding:12px 14px;font-size:12px;text-align:left;display:flex;gap:8px;align-items:flex-start;margin-bottom:20px;line-height:1.5}
.popup-warn i{flex-shrink:0;margin-top:1px}
.popup-close-btn{width:100%;background:#D4A373;border:none;color:#111;padding:13px;border-radius:8px;font-size:14px;font-weight:800;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s}
.popup-close-btn:hover{background:#b58555}

/* TOAST NOTIFICATION */
.payout-toast{position:fixed;bottom:30px;right:30px;background:#111;border:1px solid rgba(212,163,115,.4);padding:16px 20px;border-radius:12px;display:flex;align-items:center;gap:15px;z-index:9999;box-shadow:0 10px 25px rgba(0,0,0,0.8);animation:slideLeft .4s ease}
@keyframes slideLeft{from{opacity:0;transform:translateX(50px)}to{opacity:1;transform:translateX(0)}}
.p-icon{width:40px;height:40px;background:rgba(212,163,115,.1);border-radius:50%;color:#D4A373;font-size:18px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.p-text strong{color:#fff;display:block;font-size:14px;margin-bottom:3px}
.p-text p{color:#aaa;margin:0;font-size:12px}
.p-btn{background:#D4A373;color:#111;padding:8px 16px;border-radius:6px;text-decoration:none;font-weight:700;font-size:12px;transition:.2s;margin-left:10px}
.p-btn:hover{background:#b58555;color:#fff}
</style>
@endsection