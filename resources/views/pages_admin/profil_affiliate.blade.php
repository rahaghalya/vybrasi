@extends('layouts.admin')

@section('content')
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
</style>

<div class="wrap">
    <div style="margin-bottom: 15px;">
        <a href="{{ route('admin.affiliate') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Affiliate
        </a>
    </div>

    <h2 class="page-title">PROFIL MITRA: {{ strtoupper($affiliate->full_name) }}</h2>

    @if(session('success'))
        <div class="succ-box"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="err-box">
            <i class="fas fa-triangle-exclamation" style="margin-top: 2px;"></i>
            <ul style="margin: 0; padding-left: 16px;">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    {{-- KARTU KPI KHUSUS AFFILIATE --}}
    <div class="kpi-row mt-18">
        <div class="kpi">
            <div class="kpi-ic"><i class="fa-solid fa-box-open"></i></div>
            <div>
                <p class="kpi-lbl">Pesanan Selesai</p>
                <h3>{{ $stats->total_pesanan }} <span class="unit">Paket</span></h3>
            </div>
        </div>
        <div class="kpi gold-bar">
            <div class="kpi-ic"><i class="fa-solid fa-wallet"></i></div>
            <div>
                <p class="kpi-lbl">Total Komisi</p>
                <h3 class="gold">Rp {{ number_format($stats->total_komisi, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="card mt-18">
        <form action="{{ route('admin.affiliate.update', $affiliate->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="card-head">
                <span><i class="fa-solid fa-user-edit gold"></i> Detail Akun Mitra</span>
            </div>

            <div class="pad">
                <div class="frm-grid">
                    <div class="span2">
                        <label class="lbl">Nama Lengkap Affiliate</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $affiliate->full_name) }}" class="inp" required>
                    </div>

                    <div>
                        <label class="lbl">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $affiliate->email) }}" class="inp" required>
                    </div>

                    <div>
                        <label class="lbl">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $affiliate->phone) }}" class="inp" required>
                    </div>

                    <div>
                        <label class="lbl">Kode Referral Unik</label>
                        <input type="text" value="{{ $affiliate->kode_unik }}" class="inp readonly" readonly>
                        <span class="hint"><i class="fas fa-lock" style="font-size:9px;"></i> Kode permanen tidak dapat diubah.</span>
                    </div>

                    <div>
                        <label class="lbl">Status Akun Saat Ini</label>
                        <select class="inp readonly" style="appearance: none; pointer-events: none;" tabindex="-1">
                            <option value="aktif" selected>🟢 Aktif (Mitra dapat komisi)</option>
                        </select>
                        <span class="hint">Saat ini semua mitra otomatis berstatus aktif.</span>
                    </div>
                </div>

                <div class="act-row mt-18">
                    <a href="{{ route('admin.affiliate') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Perbarui Profil</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.gold{color:#D4A373 !important} .red{color:#ef4444} .mt-18{margin-top:18px}

.btn-back{display:inline-flex;align-items:center;gap:8px;color:#777;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-back:hover{color:#D4A373;transform:translateX(-4px)}
.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}

/* ALERTS */
.err-box{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);color:#ef4444;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;gap:12px;align-items:flex-start}
.succ-box{background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.2);color:#10b981;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;gap:10px;align-items:center;font-weight:600}

/* KPI ROW */
.kpi-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px}
.kpi{background:#111;border:1px solid #1e1e1e;border-radius:12px;padding:20px;display:flex;align-items:center;gap:16px;position:relative;overflow:hidden}
.kpi::before{content:'';position:absolute;left:0;top:0;width:4px;height:100%}
.gold-bar::before{background:#D4A373}
.kpi-ic{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;background:rgba(212,163,115,.1);color:#D4A373;flex-shrink:0}
.kpi-lbl{margin:0 0 4px;font-size:11px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
.kpi h3{margin:0;font-size:22px;font-weight:800;color:#fff}
.unit{font-size:13px;color:#888;font-weight:400}
@media(max-width:768px){.kpi-row{grid-template-columns:1fr}}

/* CARD & GRID */
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}
.card-head{padding:14px 18px;border-bottom:1px solid #1a1a1a;font-size:14px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.pad{padding:25px 20px}
.frm-grid{display:grid;grid-template-columns:1fr 1fr;gap:22px}
.span2{grid-column:1 / -1}
@media(max-width:768px){.frm-grid{grid-template-columns:1fr}}

/* INPUTS */
.lbl{font-size:11px;font-weight:700;color:#666;letter-spacing:1px;margin:0 0 8px;text-transform:uppercase;display:block}
.inp{background:#0a0a0a;border:1px solid #1e1e1e;color:#fff;padding:13px 15px;border-radius:8px;width:100%;font-size:13px;outline:none;transition:.2s;font-family:inherit}
.inp:focus{border-color:#D4A373;box-shadow:0 0 0 2px rgba(212,163,115,.15)}
.inp.readonly{background:#0d0d0d;border-color:#1a1a1a;color:#555;cursor:not-allowed}
.hint{font-size:11px;color:#555;margin-top:6px;display:block;font-style:italic}

/* ACTIONS */
.act-row{display:flex;justify-content:flex-end;gap:12px;border-top:1px dashed #1e1e1e;padding-top:20px;margin-top:30px}
.btn-cancel{background:transparent;border:1px solid #2a2a2a;color:#aaa;padding:11px 22px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-cancel:hover{background:#1a1a1a;color:#fff;border-color:#444}
.btn-submit{background:#D4A373;border:none;color:#111;padding:11px 28px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:.2s}
.btn-submit:hover{background:#b58555;transform:translateY(-2px)}
</style>
@endsection