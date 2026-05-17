@extends('layouts.admin')

@section('content')
{{-- Override Background Putih Parent --}}
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
</style>

<div class="wrap">
    <h2 class="page-title">DAFTAR MITRA AFFILIATE</h2>

    {{-- TOP 3 AFFILIATE CARDS --}}
    <div class="top-grid">
        @foreach($topAffiliates as $index => $top)
            <div class="top-card rank-{{ $index + 1 }}">
                <div class="rank-bg">#{{ $index + 1 }}</div>
                <div style="position: relative; z-index: 2;">
                    <h4 class="text-white-force" style="margin: 0 0 5px; font-size: 16px;">
                        {{ $top->full_name ?? $top->username ?? 'Tanpa Nama' }}
                    </h4>
                    <p class="text-gold-force" style="margin: 0 0 15px;">
                        <i class="fas fa-tag"></i> {{ $top->kode_unik ?? '-' }}
                    </p>
                    <div class="top-sales">
                        <span style="color: #aaa;">Total Komisi:</span>
                        <strong class="text-gold-force" style="font-size: 15px;">Rp {{ number_format($top->total_komisi ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- TOOLBAR --}}
    <div class="toolbar mt-18">
        <div class="search-box">
            <i class="fas fa-search" style="color: #888;"></i>
            <input type="text" class="inp-search" placeholder="Cari Affiliate...">
        </div>
        <a href="{{ route('admin.affiliate.tambah') }}" class="btn-submit" style="text-decoration: none;">
            <i class="fas fa-plus"></i> TAMBAH MITRA/AFFILIATE
        </a>
    </div>

    {{-- TABEL AFFILIATE --}}
    <div class="card mt-18">
        <table class="dtable">
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
                @forelse ($affiliates as $af)
                <tr>
                    <td>
                        <span class="mono">AF-{{ strtoupper(substr($af->id, 0, 5)) }}</span>
                    </td>
                    
                    {{-- DIJAMIN PUTIH TERANG --}}
                    <td class="text-white-force" style="font-size: 15px;">
                        {{ $af->full_name ?? $af->username ?? $af->email ?? 'Nama Belum Diisi' }}
                    </td>
                    
                    {{-- DIJAMIN EMAS TERANG --}}
                    <td class="text-gold-force" style="font-size: 14px;">
                        <i class="fas fa-tag" style="font-size: 11px; margin-right: 6px; color: #888;"></i>{{ $af->kode_unik ?? 'Belum ada kode' }}
                    </td>
                    
                    <td><span class="bdg succ">Aktif</span></td>
                    <td>
                        <a href="{{ route('admin.affiliate.profil', $af->id) }}" class="btn-ol">Lihat Profil</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty">Belum ada data mitra affiliate.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
/* CORE CSS */
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.mt-18{margin-top:18px}
.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}

/* KELAS PAKSAAN (FORCE) AGAR TEKS TIDAK GELAP */
.text-white-force { color: #ffffff !important; font-weight: 700 !important; opacity: 1 !important; text-shadow: 0 0 1px rgba(255,255,255,0.5); }
.text-gold-force { color: #D4A373 !important; font-weight: 700 !important; opacity: 1 !important; }

/* TOP 3 CARDS */
.top-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;margin-bottom:25px}
.top-card{background:#111;border:1px solid #1e1e1e;border-radius:12px;padding:20px;position:relative;overflow:hidden;transition:.3s}
.top-card:hover{transform:translateY(-4px);border-color:#333}
.top-card::before{content:'';position:absolute;left:0;top:0;width:4px;height:100%}
.top-card.rank-1::before{background:#FFD700;box-shadow:0 0 10px rgba(255,215,0,.5)}
.top-card.rank-2::before{background:#C0C0C0;box-shadow:0 0 10px rgba(192,192,192,.5)}
.top-card.rank-3::before{background:#CD7F32;box-shadow:0 0 10px rgba(205,127,50,.5)}
.rank-bg{position:absolute;right:15px;top:10px;font-size:48px;font-weight:900;color:rgba(255,255,255,.03);line-height:1;z-index:1}
.top-sales{background:#0a0a0a;padding:10px 15px;border-radius:8px;border:1px solid #1a1a1a;display:flex;justify-content:space-between;align-items:center}

/* TOOLBAR */
.toolbar{display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap}
.search-box{display:flex;align-items:center;background:#111;border:1px solid #333;border-radius:8px;padding:10px 15px;width:100%;max-width:300px}
.inp-search{background:transparent;border:none;color:#fff;outline:none;width:100%;margin-left:10px;font-size:14px;font-family:inherit}
.inp-search::placeholder{color:#666}

/* TABLE & CARD */
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}
.dtable{width:100%;border-collapse:collapse}
.dtable th{background:#0d0d0d;color:#D4A373;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:15px 20px;text-align:left;border-bottom:1px solid #1a1a1a}
.dtable td{padding:15px 20px;border-bottom:1px solid #161616;vertical-align:middle}
.dtable tbody tr:hover{background:#141414}
.mono{background:#0a0a0a;border:1px solid #333;padding:4px 8px;border-radius:6px;font-family:monospace;color:#ccc;font-size:13px}
.empty{text-align:center;color:#888;padding:40px;font-style:italic}

/* BUTTONS & BADGES */
.btn-submit{background:#D4A373;border:none;color:#111;padding:11px 20px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:.2s;box-shadow: 0 4px 10px rgba(212,163,115,0.2);}
.btn-submit:hover{background:#b58555;transform:translateY(-2px)}
.btn-ol{background:rgba(212,163,115,.05);border:1px solid rgba(212,163,115,.3);color:#D4A373;padding:7px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;transition:.2s}
.btn-ol:hover{background:#D4A373;color:#fff}
.bdg{padding:6px 12px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block}
.succ{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.3)}
</style>
@endsection