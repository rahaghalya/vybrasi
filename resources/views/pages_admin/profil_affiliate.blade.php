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
                <h3>{{ $stats->total_pesanan ?? 0 }} <span class="unit">Paket</span></h3>
            </div>
        </div>
        <div class="kpi gold-bar">
            <div class="kpi-ic"><i class="fa-solid fa-wallet"></i></div>
            <div>
                <p class="kpi-lbl">Total Saldo Komisi Saat Ini</p>
                <h3 class="gold">Rp {{ number_format($affiliate->total_komisi ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- TABEL PROFIL UTAMA --}}
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
                        {{-- FIX: Select diaktifkan agar bisa diubah admin --}}
                        <select name="status_affiliate" class="inp" style="cursor: pointer;">
                            <option value="active" {{ ($affiliate->status_affiliate ?? '') == 'active' ? 'selected' : '' }}>🟢 Aktif (Mitra dapat komisi)</option>
                            <option value="suspended" {{ ($affiliate->status_affiliate ?? '') == 'suspended' ? 'selected' : '' }}>🟠 Ditangguhkan (Penyalahgunaan)</option>
                            <option value="inactive" {{ ($affiliate->status_affiliate ?? '') == 'inactive' ? 'selected' : '' }}>🔴 Nonaktif (Akun ditutup)</option>
                        </select>
                        <span class="hint">Ubah status ini jika mitra melanggar aturan.</span>
                    </div>
                </div>

                <div class="act-row mt-18">
                    <a href="{{ route('admin.affiliate') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Perbarui Profil</button>
                </div>
            </div>
        </form>
    </div>

    {{-- RIWAYAT PENGAJUAN PENCAIRAN (PAYOUT) --}}
    <div class="card mt-18">
        <div class="card-head">
            <span><i class="fas fa-money-bill-transfer gold"></i> Riwayat Pengajuan Pencairan (Payout)</span>
        </div>
        <div class="pad">
            <div class="info-note mb-15">
                <i class="fas fa-mobile-alt"></i>
                <div>
                    <strong>Prosedur Pencairan Komisi</strong><br>
                    Sesuai alur sistem, pengajuan pencairan dana hanya dapat dilakukan oleh affiliate melalui <b>Aplikasi Mobile</b>. Admin di sini bertugas meninjau data rekening, menerima/menolak, dan mencatat bukti transfer manual.
                </div>
            </div>

            <table class="dtable" style="margin-top: 15px;">
                <thead>
                    <tr>
                        <th>Tanggal Ajuan</th>
                        <th>Jumlah</th>
                        <th>Rekening Tujuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payoutHistory ?? [] as $ph)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($ph->created_at)->format('d M Y') }}<br>
                            <small style="color: #666;">{{ \Carbon\Carbon::parse($ph->created_at)->format('H:i') }} WIB</small>
                        </td>
                        <td class="fw gold">Rp {{ number_format($ph->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <strong style="color: #fff;">{{ $ph->nama_bank }}</strong><br>
                            <span style="font-family: monospace; color: #ccc;">{{ $ph->nomor_rekening }}</span><br>
                            <small style="color: #888;">a/n {{ $ph->nama_pemilik_rek }}</small>
                        </td>
                        <td>
                            @if($ph->status === 'pending')
                                <span class="bdg warn">Menunggu</span>
                            @elseif($ph->status === 'approved')
                                <span class="bdg succ">Berhasil</span>
                            @else
                                <span class="bdg dang">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.payout.detail', $ph->id_request) }}" class="btn-ol">Lihat Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty">Mitra ini belum pernah mengajukan pencairan komisi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- RIWAYAT KOMISI MASUK --}}
    <div class="card mt-18">
        <div class="card-head">
            <span><i class="fas fa-arrow-down gold"></i> Riwayat Pendapatan Komisi</span>
        </div>
        <div class="pad">
            <table class="dtable">
                <thead>
                    <tr>
                        <th>Tanggal Transaksi</th>
                        <th>No. Invoice</th>
                        <th>Status Transaksi</th>
                        <th>Komisi Didapat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($komisiHistori ?? [] as $kh)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($kh->created_at)->format('d M Y, H:i') }}</td>
                        <td class="mono" style="color: #fff;">{{ $kh->no_invoice }}</td>
                        <td><span class="bdg succ">Selesai</span></td>
                        <td class="fw" style="color: #4ade80;">+ Rp {{ number_format($kh->jumlah_komisi, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty">Belum ada komisi masuk dari transaksi referral.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.gold{color:#D4A373 !important} .red{color:#ef4444} .mt-18{margin-top:18px} .mb-15{margin-bottom:15px}

.btn-back{display:inline-flex;align-items:center;gap:8px;color:#777;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-back:hover{color:#D4A373;transform:translateX(-4px)}
.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}

/* ALERTS & NOTES */
.err-box{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);color:#ef4444;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;gap:12px;align-items:flex-start}
.succ-box{background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.2);color:#10b981;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;gap:10px;align-items:center;font-weight:600}
.info-note{background:#0a0a0a;border:1px solid #1e1e1e;border-left:3px solid #D4A373;border-radius:8px;padding:14px 18px;font-size:13px;color:#ccc;line-height:1.6;display:flex;gap:12px;align-items:flex-start}
.info-note i{color:#D4A373;font-size:18px;margin-top:2px}

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

/* TABLE */
.dtable{width:100%;border-collapse:collapse}
.dtable th{background:#0d0d0d;color:#D4A373;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:14px 18px;text-align:left;border-bottom:1px solid #1a1a1a;white-space:nowrap}
.dtable td{padding:14px 18px;border-bottom:1px solid #161616;vertical-align:middle;font-size:13px;}
.dtable tbody tr:hover{background:#141414}
.empty{text-align:center;color:#666;padding:30px;font-style:italic}
.fw{font-weight:600}
.mono{font-family:monospace;letter-spacing:1px}

/* ACTIONS & BADGES */
.act-row{display:flex;justify-content:flex-end;gap:12px;border-top:1px dashed #1e1e1e;padding-top:20px;margin-top:30px}
.btn-cancel{background:transparent;border:1px solid #2a2a2a;color:#aaa;padding:11px 22px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-cancel:hover{background:#1a1a1a;color:#fff;border-color:#444}
.btn-submit{background:#D4A373;border:none;color:#111;padding:11px 28px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:.2s}
.btn-submit:hover{background:#b58555;transform:translateY(-2px)}
.btn-ol{background:rgba(212,163,115,.05);border:1px solid rgba(212,163,115,.3);color:#D4A373;padding:6px 12px;border-radius:6px;font-size:11px;font-weight:600;text-decoration:none;transition:.2s;display:inline-block;}
.btn-ol:hover{background:#D4A373;color:#fff}

.bdg{padding:4px 10px;border-radius:20px;font-size:10px;font-weight:700;display:inline-flex;align-items:center;gap:4px}
.succ{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.3)}
.warn{background:rgba(251,191,36,.1);color:#fbbf24;border:1px solid rgba(251,191,36,.3)}
.dang{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.3)}
</style>
@endsection