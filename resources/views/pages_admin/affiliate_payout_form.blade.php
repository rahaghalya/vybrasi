@extends('layouts.affiliate')

@section('content')

<div class="af-wrap">

    {{-- HEADER SALDO --}}
    <div class="saldo-card">
        <div class="saldo-label">Saldo Komisi Tersedia</div>
        <div class="saldo-amount">Rp {{ number_format($affiliate->total_komisi ?? 0, 0, ',', '.') }}</div>
        <div class="saldo-min">
            Minimum pencairan:
            <strong>Rp {{ number_format($affiliate->minimum_payout ?? 100000, 0, ',', '.') }}</strong>
        </div>
        @php
            $canRequest = ($affiliate->total_komisi ?? 0) >= ($affiliate->minimum_payout ?? 100000);
            $hasPending = $pendingRequest ?? false;
        @endphp
    </div>

    {{-- ALERT PENDING --}}
    @if($hasPending)
    <div class="alert-box alert-warn">
        <i class="fas fa-clock"></i>
        <div>
            <strong>Ada Pengajuan Sedang Diproses</strong>
            <p>Anda memiliki pengajuan aktif sebesar <strong>Rp {{ number_format($pendingRequest->jumlah, 0, ',', '.') }}</strong>. Tunggu hingga diproses admin sebelum mengajukan yang baru.</p>
        </div>
    </div>
    @endif

    {{-- SESSION FLASH MESSAGES --}}
    @if(session('success'))
    <div class="alert-box alert-succ">
        <i class="fas fa-check-circle"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif
    @if(session('error'))
    <div class="alert-box alert-err">
        <i class="fas fa-exclamation-circle"></i>
        <div>{{ session('error') }}</div>
    </div>
    @endif

    @if(isset($errors) && $errors->any())
    <div class="alert-box alert-err">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:16px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- FORM PENGAJUAN --}}
    @if(!$hasPending)
    <div class="section-title">
        <i class="fas fa-paper-plane"></i> Ajukan Pencairan Komisi
    </div>

    <form action="{{ route('affiliate.payout.store') }}" method="POST" id="payoutForm">
        @csrf

        {{-- JUMLAH --}}
        <div class="form-card">
            <label class="label">Jumlah yang Dicairkan</label>
            <div class="input-wrap">
                <span class="input-prefix">Rp</span>
                <input type="number" name="jumlah" id="jumlah" class="inp"
                       placeholder="0"
                       min="{{ $affiliate->minimum_payout ?? 100000 }}"
                       max="{{ $affiliate->total_komisi ?? 0 }}"
                       value="{{ old('jumlah') }}"
                       @if(!$canRequest) disabled @endif
                       required>
            </div>
            <div class="input-hint">
                Min: <strong>Rp {{ number_format($affiliate->minimum_payout ?? 100000, 0, ',', '.') }}</strong>
                — Maks: <strong>Rp {{ number_format($affiliate->total_komisi ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="quick-btns">
                <button type="button" class="quick-btn" onclick="setAmount({{ ($affiliate->minimum_payout ?? 100000) }})">
                    Min
                </button>
                <button type="button" class="quick-btn" onclick="setAmount({{ intval(($affiliate->total_komisi ?? 0) * 0.5) }})">
                    50%
                </button>
                <button type="button" class="quick-btn" onclick="setAmount({{ intval($affiliate->total_komisi ?? 0) }})">
                    Semua
                </button>
            </div>
        </div>

        {{-- DATA REKENING --}}
        <div class="section-title" style="margin-top:20px;">
            <i class="fas fa-university"></i> Data Rekening Tujuan
        </div>
        <div class="info-note">
            <i class="fas fa-info-circle"></i>
            Pastikan nama rekening sesuai persis dengan nama Anda yang terdaftar di sistem. Data ini akan diverifikasi oleh admin.
        </div>

        <div class="form-card">
            <label class="label">Nama Bank</label>
            <select name="nama_bank" class="inp-select" @if(!$canRequest) disabled @endif required>
                <option value="" disabled selected>-- Pilih Bank --</option>
                @foreach(['BCA','BRI','BNI','Mandiri','BSI (Bank Syariah Indonesia)','CIMB Niaga','Danamon','Permata Bank','BTN','Jenius (BTPN)','SeaBank','GoPay','OVO','Dana','ShopeePay'] as $bank)
                    <option value="{{ $bank }}" {{ old('nama_bank') == $bank ? 'selected' : '' }}>
                        {{ $bank }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-card">
            <label class="label">Nomor Rekening / Akun</label>
            <input type="text" name="nomor_rekening" class="inp"
                   placeholder="Contoh: 1234567890"
                   value="{{ old('nomor_rekening') }}"
                   inputmode="numeric"
                   @if(!$canRequest) disabled @endif
                   required>
        </div>

        <div class="form-card">
            <label class="label">Nama Pemilik Rekening</label>
            <input type="text" name="nama_pemilik_rek" class="inp"
                   placeholder="Nama sesuai buku tabungan / KTP"
                   value="{{ old('nama_pemilik_rek', $affiliate->full_name ?? '') }}"
                   @if(!$canRequest) disabled @endif
                   required>
            <div class="input-hint">
                Nama terdaftar di sistem: <strong style="color:#D4A373;">{{ $affiliate->full_name ?? '-' }}</strong>
            </div>
        </div>

        {{-- SUBMIT --}}
        @if($canRequest)
        <button type="submit" class="btn-submit" id="submitBtn" onclick="return confirmSubmit()">
            <i class="fas fa-paper-plane"></i>
            AJUKAN PENCAIRAN KOMISI
        </button>
        @else
        <div class="alert-box alert-warn" style="margin-top:16px;">
            <i class="fas fa-lock"></i>
            <div>
                Saldo komisi belum mencukupi minimum pencairan
                (Rp {{ number_format($affiliate->minimum_payout ?? 100000, 0, ',', '.') }}).
            </div>
        </div>
        @endif

    </form>
    @endif

    {{-- RIWAYAT PENGAJUAN --}}
    <div class="section-title" style="margin-top:28px;">
        <i class="fas fa-history"></i> Riwayat Pengajuan
    </div>

    @forelse($payoutHistory as $p)
    <div class="hist-card {{ $p->status }}">
        <div class="hist-top">
            <span class="hist-amount">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</span>
            @if($p->status === 'pending')
                <span class="bdg warn"><i class="fas fa-clock"></i> Menunggu</span>
            @elseif($p->status === 'approved')
                <span class="bdg succ"><i class="fas fa-check"></i> Disetujui</span>
            @else
                <span class="bdg dang"><i class="fas fa-times"></i> Ditolak</span>
            @endif
        </div>
        <div class="hist-bank">
            {{ $p->nama_bank }} — {{ $p->nomor_rekening }}
            <span style="color:#555;">a/n {{ $p->nama_pemilik_rek }}</span>
        </div>
        <div class="hist-date">
            {{ \Carbon\Carbon::parse($p->created_at)->diffForHumans() }}
            · {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
        </div>

        {{-- KETERANGAN ADMIN --}}
        @if($p->keterangan_admin)
        <div class="admin-note {{ $p->status === 'rejected' ? 'note-err' : 'note-ok' }}">
            <i class="fas fa-comment-alt"></i>
            <div>
                <strong>Pesan dari Admin:</strong><br>
                {{ $p->keterangan_admin }}
            </div>
        </div>
        @endif

        {{-- BUKTI TRANSFER --}}
        @if($p->status === 'approved' && $p->bukti_transfer)
        <a href="{{ $p->bukti_transfer }}" target="_blank" class="bukti-link">
            <i class="fas fa-receipt"></i> Lihat Bukti Transfer
        </a>
        @endif
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>Belum ada riwayat pengajuan komisi.</p>
    </div>
    @endforelse

</div>

<script>
function setAmount(val) {
    const input = document.getElementById('jumlah');
    if (input && !input.disabled) input.value = val;
}
function confirmSubmit() {
    const jumlah = document.getElementById('jumlah').value;
    if (!jumlah || jumlah <= 0) {
        alert('Masukkan jumlah yang valid.');
        return false;
    }
    const fmt = parseInt(jumlah).toLocaleString('id-ID');
    return confirm(`Ajukan pencairan komisi sebesar Rp ${fmt}?\n\nPastikan data rekening sudah benar. Admin akan memverifikasi dalam 1–3 hari kerja.`);
}
</script>

<style>
*,*::before,*::after{box-sizing:border-box}
.af-wrap{padding:16px;max-width:480px;margin:0 auto;color:#fff;font-family:inherit;padding-bottom:80px}

/* SALDO CARD */
.saldo-card{background:linear-gradient(135deg,#1a1200 0%,#2d1e00 50%,#1a1200 100%);border:1px solid rgba(212,163,115,.3);border-radius:16px;padding:24px 20px;text-align:center;margin-bottom:20px;position:relative;overflow:hidden}
.saldo-card::before{content:'';position:absolute;inset:0;background:radial-gradient(circle at 60% 40%,rgba(212,163,115,.08) 0%,transparent 70%)}
.saldo-label{font-size:12px;color:#9a7a4a;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px}
.saldo-amount{font-size:32px;font-weight:900;color:#D4A373;line-height:1.2;position:relative;z-index:1}
.saldo-min{font-size:12px;color:#9a7a4a;margin-top:8px}

/* ALERTS */
.alert-box{display:flex;align-items:flex-start;gap:12px;padding:14px;border-radius:10px;margin-bottom:14px;font-size:13px;line-height:1.6}
.alert-box i{font-size:16px;flex-shrink:0;margin-top:1px}
.alert-box strong{display:block;margin-bottom:4px}
.alert-box p{margin:0;opacity:.85}
.alert-box ul{margin:0}
.alert-warn{background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.25);color:#fbbf24}
.alert-succ{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);color:#4ade80}
.alert-err{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#f87171}

/* SECTION TITLE */
.section-title{font-size:13px;font-weight:700;color:#D4A373;text-transform:uppercase;letter-spacing:.5px;display:flex;align-items:center;gap:8px;margin-bottom:12px}

/* INFO NOTE */
.info-note{background:#0f0f0f;border:1px solid #1e1e1e;border-left:3px solid #D4A373;border-radius:8px;padding:12px 14px;font-size:12px;color:#888;line-height:1.6;display:flex;gap:8px;margin-bottom:12px}
.info-note i{color:#D4A373;flex-shrink:0;margin-top:1px}

/* FORM CARDS */
.form-card{background:#111;border:1px solid #1e1e1e;border-radius:10px;padding:14px;margin-bottom:10px}
.label{display:block;font-size:11px;color:#666;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.input-wrap{display:flex;align-items:center;gap:8px}
.input-prefix{font-size:14px;color:#D4A373;font-weight:700}
.inp{width:100%;background:#0a0a0a;border:1px solid #2a2a2a;border-radius:8px;padding:12px;color:#fff;font-size:15px;outline:none;font-family:inherit;transition:.2s;-moz-appearance:textfield}
.inp::-webkit-outer-spin-button,.inp::-webkit-inner-spin-button{-webkit-appearance:none}
.inp:focus{border-color:#D4A373}
.inp::placeholder{color:#444}
.inp:disabled{opacity:.4;cursor:not-allowed}
.inp-select{width:100%;background:#0a0a0a;border:1px solid #2a2a2a;border-radius:8px;padding:12px;color:#fff;font-size:14px;outline:none;font-family:inherit;cursor:pointer;transition:.2s}
.inp-select:focus{border-color:#D4A373}
.inp-select:disabled{opacity:.4;cursor:not-allowed}
.input-hint{font-size:11px;color:#555;margin-top:6px}

/* QUICK BUTTONS */
.quick-btns{display:flex;gap:8px;margin-top:10px}
.quick-btn{flex:1;background:#0a0a0a;border:1px solid #333;border-radius:6px;padding:7px;color:#999;font-size:12px;font-weight:600;cursor:pointer;transition:.2s}
.quick-btn:hover{border-color:#D4A373;color:#D4A373}

/* SUBMIT */
.btn-submit{width:100%;background:#D4A373;border:none;color:#0a0a0a;padding:15px;border-radius:10px;font-size:14px;font-weight:900;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s;margin-top:16px;letter-spacing:.5px;box-shadow:0 4px 20px rgba(212,163,115,.25)}
.btn-submit:hover{background:#b58555;transform:translateY(-1px)}
.btn-submit:active{transform:translateY(0)}

/* HISTORY */
.hist-card{background:#111;border:1px solid #1e1e1e;border-radius:10px;padding:14px;margin-bottom:10px}
.hist-card.pending{border-left:3px solid #fbbf24}
.hist-card.approved{border-left:3px solid #4ade80}
.hist-card.rejected{border-left:3px solid #f87171}
.hist-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.hist-amount{font-size:17px;font-weight:700;color:#fff}
.hist-bank{font-size:13px;color:#999;margin-bottom:4px;display:flex;flex-direction:column;gap:2px}
.hist-date{font-size:11px;color:#555}
.admin-note{display:flex;gap:10px;padding:10px 12px;border-radius:8px;margin-top:10px;font-size:12px;line-height:1.6}
.admin-note i{flex-shrink:0;margin-top:1px}
.note-ok{background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.2);color:#4ade80}
.note-err{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);color:#f87171}
.bukti-link{display:inline-flex;align-items:center;gap:6px;margin-top:8px;font-size:12px;color:#D4A373;text-decoration:none;background:rgba(212,163,115,.08);border:1px solid rgba(212,163,115,.2);padding:6px 12px;border-radius:6px}

/* BADGES */
.bdg{padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:4px}
.succ{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.3)}
.warn{background:rgba(251,191,36,.1);color:#fbbf24;border:1px solid rgba(251,191,36,.3)}
.dang{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.3)}

/* EMPTY */
.empty-state{text-align:center;padding:40px 20px;color:#555}
.empty-state i{font-size:36px;display:block;margin-bottom:10px}
.empty-state p{margin:0;font-size:14px}
</style>
@endsection