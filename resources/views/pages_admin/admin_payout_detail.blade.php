@extends('layouts.admin')

@section('content')
<style>
body, .admin-container, .main-content, .content-body, section.content-body,
main.main-content, .content-wrapper, .page-wrapper, .main-wrapper,
.inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] {
    background: #0a0a0a !important; background-color: #0a0a0a !important;
}
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }
</style>

<div class="wrap">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-row">
        <a href="{{ route('admin.payout.index') }}" class="bc-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pengajuan
        </a>
    </div>

    <div class="page-grid">

        {{-- KOLOM KIRI: Info Pengajuan --}}
        <div class="left-col">

            {{-- STATUS BANNER --}}
            @if($payout->status === 'pending')
            <div class="status-banner pending-banner">
                <i class="fas fa-clock"></i>
                <div>
                    <strong>Menunggu Verifikasi</strong>
                    <p>Periksa data rekening affiliate sebelum menyetujui pengajuan ini.</p>
                </div>
            </div>
            @elseif($payout->status === 'approved')
            <div class="status-banner approved-banner">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Pengajuan Disetujui</strong>
                    <p>Diproses oleh {{ $payout->reviewer?->full_name ?? 'Admin' }} pada {{ \Carbon\Carbon::parse($payout->reviewed_at)->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
            @else
            <div class="status-banner rejected-banner">
                <i class="fas fa-times-circle"></i>
                <div>
                    <strong>Pengajuan Ditolak</strong>
                    <p>Diproses oleh {{ $payout->reviewer?->full_name ?? 'Admin' }} pada {{ \Carbon\Carbon::parse($payout->reviewed_at)->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
            @endif

            {{-- DETAIL PENGAJUAN --}}
            <div class="card">
                <div class="card-head">
                    <i class="fas fa-file-invoice-dollar"></i>
                    Detail Pengajuan
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <span class="detail-label">ID Request</span>
                        <span class="mono">{{ $payout->id_request }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Pengajuan</span>
                        <span>{{ \Carbon\Carbon::parse($payout->created_at)->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jumlah Dicairkan</span>
                        <span class="amount-big">Rp {{ number_format($payout->jumlah, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Saldo Komisi Saat Ini</span>
                        <span style="color:#ccc;">Rp {{ number_format($affiliate->total_komisi ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- DATA REKENING (DIISI AFFILIATE) --}}
            <div class="card mt-16">
                <div class="card-head">
                    <i class="fas fa-university"></i>
                    Data Rekening yang Diajukan
                </div>
                <div class="card-body">
                    <div class="bank-display">
                        <div class="bank-logo-wrap">
                            <i class="fas fa-building-columns"></i>
                        </div>
                        <div class="bank-detail-grid">
                            <div class="bank-field">
                                <span class="bf-label">Nama Bank</span>
                                <span class="bf-value bank-highlight">{{ $payout->nama_bank }}</span>
                            </div>
                            <div class="bank-field">
                                <span class="bf-label">Nomor Rekening</span>
                                <span class="bf-value" style="font-family:monospace;letter-spacing:2px;font-size:16px;">
                                    {{ $payout->nomor_rekening }}
                                </span>
                            </div>
                            <div class="bank-field">
                                <span class="bf-label">Atas Nama</span>
                                <span class="bf-value">{{ $payout->nama_pemilik_rek }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATA AFFILIATE (REFERENSI VERIFIKASI) --}}
            <div class="card mt-16">
                <div class="card-head">
                    <i class="fas fa-user-check"></i>
                    Data Affiliate (Referensi Sistem)
                    <span class="head-note">Cocokkan dengan data di atas</span>
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <span class="detail-label">ID Affiliate</span>
                        <span class="mono">{{ $payout->id_affiliate }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nama Lengkap</span>
                        <span style="color:#fff;font-weight:600;">{{ $affiliate->full_name ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Kode Referral</span>
                        <span class="gold"><i class="fas fa-tag"></i> {{ $affiliate->kode_unik ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email</span>
                        <span style="color:#ccc;">{{ $affiliate->email ?? '-' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">No. Telepon</span>
                        <span style="color:#ccc;">{{ $affiliate->phone ?? '-' }}</span>
                    </div>

                    {{-- CHECKLIST VERIFIKASI --}}
                    @if($payout->status === 'pending')
                    <div class="verify-check-wrap">
                        <div class="verify-title"><i class="fas fa-tasks"></i> Checklist Verifikasi Admin</div>
                        <label class="chk-item">
                            <input type="checkbox" id="chk1">
                            <span>ID Affiliate sesuai dengan sistem</span>
                        </label>
                        <label class="chk-item">
                            <input type="checkbox" id="chk2">
                            <span>Nama pemilik rekening sesuai dengan nama affiliate</span>
                        </label>
                        <label class="chk-item">
                            <input type="checkbox" id="chk3">
                            <span>Nama bank dan nomor rekening valid</span>
                        </label>
                        <label class="chk-item">
                            <input type="checkbox" id="chk4">
                            <span>Saldo komisi mencukupi untuk dicairkan</span>
                        </label>
                    </div>
                    @endif
                </div>
            </div>

            {{-- BUKTI TRANSFER (jika sudah approved) --}}
            @if($payout->status === 'approved' && $payout->bukti_transfer)
            <div class="card mt-16">
                <div class="card-head">
                    <i class="fas fa-receipt"></i>
                    Bukti Transfer
                </div>
                <div class="card-body" style="text-align:center;">
                    <img src="{{ $payout->bukti_transfer }}" alt="Bukti Transfer"
                         style="max-width:100%;border-radius:8px;border:1px solid #333;">
                </div>
            </div>
            @endif

        </div>

        {{-- KOLOM KANAN: Panel Aksi --}}
        <div class="right-col">

            @if($payout->status === 'pending')

            {{-- FORM SETUJU --}}
            <div class="action-card approve-card">
                <div class="ac-head">
                    <i class="fas fa-check-circle" style="color:#4ade80;"></i>
                    Setujui Pengajuan
                </div>
                <p class="ac-desc">Pastikan semua data rekening sudah diverifikasi sebelum menyetujui. Setelah disetujui, lakukan transfer manual ke rekening affiliate.</p>
                <form id="approveForm" action="{{ route('admin.payout.approve', $payout->id_request) }}" method="POST"
                      enctype="multipart/form-data" onsubmit="confirmApprove(event)">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Keterangan untuk Affiliate <span style="color:#666;">(opsional)</span></label>
                        <textarea name="keterangan_admin" class="inp-area"
                                  placeholder="Contoh: Komisi telah kami transfer. Silakan cek rekening Anda dalam 1x24 jam..."
                                  rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Upload Bukti Transfer <span style="color:#f87171;">*</span></label>
                        <div class="upload-area" onclick="document.getElementById('bukti_file').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Klik untuk upload struk / screenshot transfer</span>
                            <small>JPG, PNG, PDF — Maks 5MB</small>
                        </div>
                        <input type="file" id="bukti_file" name="bukti_transfer"
                               accept="image/*,.pdf" style="display:none;"
                               onchange="showFileName(this)">
                        <div id="file-name" class="file-name-preview" style="display:none;"></div>
                    </div>
                    <button type="submit" class="btn-approve" id="btn-approve">
                        <i class="fas fa-check"></i> SETUJUI & TANDAI SELESAI
                    </button>
                </form>
            </div>

            {{-- FORM TOLAK --}}
            <div class="action-card reject-card mt-16">
                <div class="ac-head">
                    <i class="fas fa-times-circle" style="color:#f87171;"></i>
                    Tolak Pengajuan
                </div>
                <p class="ac-desc">Berikan alasan yang jelas agar affiliate dapat memperbaiki data dan mengajukan ulang.</p>
                <form id="rejectForm" action="{{ route('admin.payout.reject', $payout->id_request) }}" method="POST"
                      onsubmit="confirmReject(event)">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Alasan Penolakan <span style="color:#f87171;">*</span></label>
                        <textarea name="keterangan_admin" class="inp-area" required
                                  placeholder="Contoh: Data rekening tidak sesuai. Nama pemilik rekening berbeda dengan nama yang terdaftar di sistem..."
                                  rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn-reject">
                        <i class="fas fa-times"></i> TOLAK PENGAJUAN
                    </button>
                </form>
            </div>

            @else

            {{-- INFO KETERANGAN ADMIN (sudah diproses) --}}
            <div class="action-card info-card">
                <div class="ac-head">
                    <i class="fas fa-comment-alt" style="color:#D4A373;"></i>
                    Keterangan Admin
                </div>
                <div class="keterangan-box">
                    {{ $payout->keterangan_admin ?? 'Tidak ada keterangan tambahan.' }}
                </div>
                @if($payout->reviewed_at)
                <p style="color:#555;font-size:12px;margin:12px 0 0;">
                    Diproses: {{ \Carbon\Carbon::parse($payout->reviewed_at)->format('d M Y, H:i') }} WIB
                </p>
                @endif
            </div>

            @endif

            {{-- RIWAYAT PENGAJUAN AFFILIATE INI --}}
            <div class="action-card history-card mt-16">
                <div class="ac-head">
                    <i class="fas fa-history" style="color:#D4A373;"></i>
                    Riwayat Pengajuan Affiliate Ini
                </div>
                @forelse($payoutHistory as $hist)
                <div class="hist-item">
                    <div class="hist-left">
                        <span class="hist-amount">Rp {{ number_format($hist->jumlah, 0, ',', '.') }}</span>
                        <span class="hist-date">{{ \Carbon\Carbon::parse($hist->created_at)->format('d M Y') }}</span>
                    </div>
                    @if($hist->status === 'approved')
                        <span class="bdg succ" style="font-size:10px;"><i class="fas fa-check"></i> Disetujui</span>
                    @elseif($hist->status === 'rejected')
                        <span class="bdg dang" style="font-size:10px;"><i class="fas fa-times"></i> Ditolak</span>
                    @else
                        <span class="bdg warn" style="font-size:10px;"><i class="fas fa-clock"></i> Pending</span>
                    @endif
                </div>
                @empty
                <p style="color:#555;font-size:13px;text-align:center;padding:16px 0;">Belum ada riwayat lainnya.</p>
                @endforelse
            </div>

        </div>

    </div>

</div>

{{-- MODAL CUSTOM ERROR & CONFIRM --}}
<div id="customAlertModal" class="custom-modal">
    <div class="modal-content-card border-err">
        <div class="modal-header" style="border-bottom: none; padding-bottom: 0;">
            <h3 style="color: #f87171; display: flex; align-items: center; gap: 8px; margin: 0;">
                <i class="fas fa-exclamation-triangle"></i> Peringatan
            </h3>
        </div>
        <div class="modal-body" style="padding: 15px 0;">
            <p id="alertMessage" style="color: #ccc; margin: 0; font-size: 14px; line-height: 1.5;"></p>
        </div>
        <div class="modal-footer" style="border-top: none; padding-top: 0; justify-content: flex-end;">
            <button type="button" class="btn-cancel" onclick="closeAlertModal()">Mengerti</button>
        </div>
    </div>
</div>

<div id="customConfirmModal" class="custom-modal">
    <div class="modal-content-card border-succ">
        <div class="modal-header" style="border-bottom: none; padding-bottom: 0;">
            <h3 style="color: #4ade80; display: flex; align-items: center; gap: 8px; margin: 0;">
                <i class="fas fa-question-circle"></i> Konfirmasi Persetujuan
            </h3>
        </div>
        <div class="modal-body" style="padding: 15px 0;">
            <p id="confirmMessage" style="color: #ccc; margin: 0; font-size: 14px; line-height: 1.5;"></p>
        </div>
        <div class="modal-footer" style="border-top: none; padding-top: 0;">
            <button type="button" class="btn-cancel" onclick="closeConfirmModal()">Batal</button>
            <button type="button" class="btn-approve" onclick="proceedApprove()" style="width: auto; margin-top: 0; padding: 11px 22px;">Setujui Sekarang</button>
        </div>
    </div>
</div>

<div id="customRejectModal" class="custom-modal">
    <div class="modal-content-card border-err">
        <div class="modal-header" style="border-bottom: none; padding-bottom: 0;">
            <h3 style="color: #f87171; display: flex; align-items: center; gap: 8px; margin: 0;">
                <i class="fas fa-times-circle"></i> Konfirmasi Penolakan
            </h3>
        </div>
        <div class="modal-body" style="padding: 15px 0;">
            <p style="color: #ccc; margin: 0; font-size: 14px; line-height: 1.5;">Apakah Anda yakin ingin <strong>MENOLAK</strong> pengajuan pencairan komisi ini?</p>
        </div>
        <div class="modal-footer" style="border-top: none; padding-top: 0;">
            <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
            <button type="button" class="btn-reject" onclick="proceedReject()" style="width: auto; margin-top: 0; padding: 11px 22px; border: none; background: #ef4444; color: #fff;">Tolak Sekarang</button>
        </div>
    </div>
</div>

<script>
function confirmApprove(event) {
    // Mencegah form langsung tersubmit
    event.preventDefault();

    const file = document.getElementById('bukti_file').files.length;
    
    // Jika belum upload bukti
    if (!file) {
        document.getElementById('alertMessage').innerText = 'Harap upload struk atau screenshot bukti transfer terlebih dahulu sebelum menyetujui pengajuan ini.';
        document.getElementById('customAlertModal').style.display = 'flex';
        return false;
    }

    // Jika sudah upload, tampilkan konfirmasi
    document.getElementById('confirmMessage').innerText = 'Apakah Anda yakin ingin MENYETUJUI pengajuan ini? Pastikan transfer manual ke rekening mitra sudah benar-benar berhasil dilakukan.';
    document.getElementById('customConfirmModal').style.display = 'flex';
}

function proceedApprove() {
    // Submit form secara manual via JS setelah dikonfirmasi
    document.getElementById('approveForm').submit();
}

function confirmReject(event) {
    event.preventDefault();
    document.getElementById('customRejectModal').style.display = 'flex';
}

function proceedReject() {
    document.getElementById('rejectForm').submit();
}

function closeAlertModal() { document.getElementById('customAlertModal').style.display = 'none'; }
function closeConfirmModal() { document.getElementById('customConfirmModal').style.display = 'none'; }
function closeRejectModal() { document.getElementById('customRejectModal').style.display = 'none'; }

function showFileName(input) {
    if (input.files && input.files[0]) {
        const preview = document.getElementById('file-name');
        preview.textContent = '✓ ' + input.files[0].name;
        preview.style.display = 'block';
    }
}

// Tutup modal jika user klik area luar pop-up
window.onclick = function(event) {
    let alertModal = document.getElementById('customAlertModal');
    let confirmModal = document.getElementById('customConfirmModal');
    let rejectModal = document.getElementById('customRejectModal');
    
    if (event.target == alertModal) { alertModal.style.display = "none"; }
    if (event.target == confirmModal) { confirmModal.style.display = "none"; }
    if (event.target == rejectModal) { rejectModal.style.display = "none"; }
}
</script>

<style>
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.mt-16{margin-top:16px}

.breadcrumb-row{margin-bottom:20px}
.bc-link{color:#666;font-size:13px;text-decoration:none;display:inline-flex;align-items:center;gap:8px;transition:.2s}
.bc-link:hover{color:#D4A373}

/* GRID LAYOUT */
.page-grid{display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start}
@media(max-width:900px){.page-grid{grid-template-columns:1fr}}

/* STATUS BANNERS */
.status-banner{display:flex;align-items:flex-start;gap:14px;padding:16px;border-radius:10px;margin-bottom:16px;font-size:14px;line-height:1.5}
.status-banner i{font-size:22px;flex-shrink:0;margin-top:1px}
.status-banner strong{display:block;font-size:15px;margin-bottom:4px}
.status-banner p{margin:0;opacity:.8;font-size:13px}
.pending-banner{background:rgba(251,191,36,.08);border:1px solid rgba(251,191,36,.25);color:#fbbf24}
.approved-banner{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);color:#4ade80}
.rejected-banner{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#f87171}

/* CARDS */
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}
.card-head{background:#0d0d0d;padding:14px 18px;color:#D4A373;font-size:13px;font-weight:700;display:flex;align-items:center;gap:8px;border-bottom:1px solid #1a1a1a;text-transform:uppercase;letter-spacing:.5px}
.head-note{margin-left:auto;font-size:11px;color:#555;font-weight:400;text-transform:none;letter-spacing:0}
.card-body{padding:18px}

/* DETAIL ROWS */
.detail-row{display:flex;justify-content:space-between;align-items:center;padding:11px 0;border-bottom:1px solid #161616;font-size:14px}
.detail-row:last-child{border-bottom:none}
.detail-label{color:#666;font-size:13px}
.mono{background:#0a0a0a;border:1px solid #333;padding:4px 8px;border-radius:6px;font-family:monospace;color:#ccc;font-size:11px;word-break:break-all}
.amount-big{color:#D4A373;font-size:20px;font-weight:800}
.gold{color:#D4A373}

/* BANK DISPLAY */
.bank-display{display:flex;gap:16px;align-items:flex-start}
.bank-logo-wrap{width:50px;height:50px;background:rgba(212,163,115,.1);border:1px solid rgba(212,163,115,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#D4A373;font-size:20px;flex-shrink:0}
.bank-detail-grid{flex:1;display:flex;flex-direction:column;gap:12px}
.bank-field{}
.bf-label{display:block;font-size:11px;color:#666;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px}
.bf-value{display:block;color:#fff;font-size:15px;font-weight:600}
.bank-highlight{color:#D4A373;font-size:18px;font-weight:800}

/* VERIFY CHECKLIST */
.verify-check-wrap{background:#0a0a0a;border:1px solid #1a1a1a;border-radius:8px;padding:14px;margin-top:16px}
.verify-title{font-size:12px;color:#D4A373;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;display:flex;align-items:center;gap:6px}
.chk-item{display:flex;align-items:center;gap:10px;padding:8px 0;font-size:13px;color:#999;cursor:pointer;border-bottom:1px solid #151515}
.chk-item:last-child{border-bottom:none}
.chk-item input[type=checkbox]{accent-color:#D4A373;width:15px;height:15px;cursor:pointer}
.chk-item:has(input:checked) span{color:#fff}

/* ACTION CARDS */
.action-card{background:#111;border:1px solid #1e1e1e;border-radius:12px;padding:20px}
.approve-card{border-color:rgba(16,185,129,.2)}
.reject-card{border-color:rgba(239,68,68,.2)}
.info-card{border-color:rgba(212,163,115,.2)}
.history-card{}
.ac-head{font-size:14px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px;margin-bottom:10px}
.ac-desc{font-size:13px;color:#666;line-height:1.6;margin:0 0 16px}

/* FORMS */
.form-group{margin-bottom:14px}
.form-label{display:block;font-size:12px;color:#888;font-weight:600;margin-bottom:6px;text-transform:uppercase;letter-spacing:.4px}
.inp-area{width:100%;background:#0a0a0a;border:1px solid #333;border-radius:8px;padding:10px 12px;color:#fff;font-size:13px;resize:vertical;outline:none;font-family:inherit;transition:.2s}
.inp-area:focus{border-color:#D4A373}
.inp-area::placeholder{color:#555}

/* UPLOAD */
.upload-area{border:2px dashed #333;border-radius:8px;padding:20px;text-align:center;cursor:pointer;transition:.2s;color:#666;display:flex;flex-direction:column;align-items:center;gap:6px}
.upload-area:hover{border-color:#D4A373;color:#D4A373}
.upload-area i{font-size:28px;margin-bottom:4px}
.upload-area span{font-size:13px;font-weight:600}
.upload-area small{font-size:11px}
.file-name-preview{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.3);color:#4ade80;font-size:12px;padding:8px 12px;border-radius:6px;margin-top:8px}

/* BUTTONS */
.btn-approve{width:100%;background:#4ade80;border:none;color:#0a0a0a;padding:13px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s;margin-top:4px}
.btn-approve:hover{background:#22c55e;transform:translateY(-1px)}
.btn-reject{width:100%;background:transparent;border:1px solid rgba(239,68,68,.4);color:#f87171;padding:12px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s}
.btn-reject:hover{background:rgba(239,68,68,.1)}
.btn-cancel{background:transparent;border:1px solid #333;color:#ccc;padding:10px 18px;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:.2s}
.btn-cancel:hover{background:#222;color:#fff}

/* KETERANGAN BOX */
.keterangan-box{background:#0a0a0a;border:1px solid #1a1a1a;border-radius:8px;padding:14px;color:#ccc;font-size:14px;line-height:1.7}

/* HISTORY */
.hist-item{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #161616}
.hist-item:last-child{border-bottom:none}
.hist-left{display:flex;flex-direction:column;gap:3px}
.hist-amount{color:#fff;font-weight:600;font-size:14px}
.hist-date{color:#666;font-size:12px}
.bdg{padding:5px 10px;border-radius:20px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:4px}
.succ{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.3)}
.warn{background:rgba(251,191,36,.1);color:#fbbf24;border:1px solid rgba(251,191,36,.3)}
.dang{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.3)}

/* CUSTOM MODAL POP-UP */
.custom-modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); backdrop-filter: blur(5px); align-items: center; justify-content: center; }
.modal-content-card { background: #111; border: 1px solid #222; border-radius: 12px; width: 100%; max-width: 420px; padding: 25px; animation: modalFi .3s ease; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
.border-err { border-top: 4px solid #ef4444; }
.border-succ { border-top: 4px solid #10b981; }
.modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 15px; }
@keyframes modalFi { from{opacity:0; transform: scale(0.95) translateY(10px)} to{opacity:1; transform: scale(1) translateY(0)} }
</style>
@endsection