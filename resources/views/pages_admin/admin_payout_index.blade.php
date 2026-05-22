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

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h2 class="page-title">PENGAJUAN KOMISI AFFILIATE</h2>
            <p class="page-sub">Kelola permintaan pencairan komisi dari mitra affiliate</p>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon pending-icon"><i class="fas fa-clock"></i></div>
            <div>
                {{-- Ubah dari $stats['pending'] menjadi $stats->pending --}}
                <div class="stat-num">{{ $stats->pending ?? 0 }}</div>
                <div class="stat-label">Menunggu Review</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon approved-icon"><i class="fas fa-check-circle"></i></div>
            <div>
                {{-- Ubah dari $stats['approved'] menjadi $stats->approved --}}
                <div class="stat-num">{{ $stats->approved ?? 0 }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon rejected-icon"><i class="fas fa-times-circle"></i></div>
            <div>
                {{-- Ubah dari $stats['rejected'] menjadi $stats->rejected --}}
                <div class="stat-num">{{ $stats->rejected ?? 0 }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon total-icon"><i class="fas fa-wallet"></i></div>
            <div>
                {{-- Ubah dari $stats['total_pending_amount'] menjadi $stats->total_pending_amount --}}
                <div class="stat-num">Rp {{ number_format($stats->total_pending_amount ?? 0, 0, ',', '.') }}</div>
                <div class="stat-label">Total Menunggu</div>
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="filter-tabs mt-18">
        <a href="{{ route('admin.payout.index') }}"
           class="tab {{ request('status') == '' ? 'active' : '' }}">
            Semua
        </a>
        <a href="{{ route('admin.payout.index', ['status' => 'pending']) }}"
           class="tab {{ request('status') == 'pending' ? 'active' : '' }}">
            <span class="dot dot-pending"></span> Menunggu
        </a>
        <a href="{{ route('admin.payout.index', ['status' => 'approved']) }}"
           class="tab {{ request('status') == 'approved' ? 'active' : '' }}">
            <span class="dot dot-approved"></span> Disetujui
        </a>
        <a href="{{ route('admin.payout.index', ['status' => 'rejected']) }}"
           class="tab {{ request('status') == 'rejected' ? 'active' : '' }}">
            <span class="dot dot-rejected"></span> Ditolak
        </a>
    </div>

    {{-- TABEL --}}
    <div class="card mt-12">
        <table class="dtable">
            <thead>
                <tr>
                    <th>Affiliate</th>
                    <th>Jumlah Pengajuan</th>
                    <th>Bank / Rekening</th>
                    <th>Tanggal Ajuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payouts as $p)
                <tr class="{{ $p->status === 'pending' ? 'row-pending' : '' }}">
                    <td>
                        <div class="aff-info">
                            <div class="aff-avatar">
                                {{ strtoupper(substr($p->full_name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <div class="aff-name">{{ $p->full_name ?? 'Tanpa Nama' }}</div>
                                <div class="aff-code">
                                    <i class="fas fa-tag" style="font-size:10px;"></i>
                                    {{ $p->kode_unik ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="amount">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <div class="bank-info">
                            <span class="bank-name">{{ $p->nama_bank }}</span>
                            <span class="bank-num">{{ $p->nomor_rekening }}</span>
                            <span class="bank-owner">a/n {{ $p->nama_pemilik_rek }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="date-text">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</span>
                        <span class="time-text">{{ \Carbon\Carbon::parse($p->created_at)->format('H:i') }} WIB</span>
                    </td>
                    <td>
                        @if($p->status === 'pending')
                            <span class="bdg warn"><i class="fas fa-clock"></i> Menunggu</span>
                        @elseif($p->status === 'approved')
                            <span class="bdg succ"><i class="fas fa-check"></i> Disetujui</span>
                        @else
                            <span class="bdg dang"><i class="fas fa-times"></i> Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.payout.detail', $p->id_request) }}" class="btn-review">
                            @if($p->status === 'pending')
                                <i class="fas fa-search"></i> Review
                            @else
                                <i class="fas fa-eye"></i> Detail
                            @endif
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty">
                        <i class="fas fa-inbox" style="font-size:32px; color:#333; display:block; margin-bottom:10px;"></i>
                        Belum ada pengajuan komisi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($payouts->hasPages())
        <div class="pagination-wrap">
            {{ $payouts->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

<style>
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.mt-18{margin-top:18px}.mt-12{margin-top:12px}

.page-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px}
.page-title{margin:0 0 4px;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}
.page-sub{margin:0;color:#666;font-size:13px;padding-left:16px}

/* STAT CARDS */
.stat-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px}
.stat-card{background:#111;border:1px solid #1e1e1e;border-radius:12px;padding:18px 20px;display:flex;align-items:center;gap:16px;transition:.2s}
.stat-card:hover{border-color:#2a2a2a;transform:translateY(-2px)}
.stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.pending-icon{background:rgba(251,191,36,.1);color:#fbbf24;border:1px solid rgba(251,191,36,.2)}
.approved-icon{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.2)}
.rejected-icon{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.2)}
.total-icon{background:rgba(212,163,115,.1);color:#D4A373;border:1px solid rgba(212,163,115,.2)}
.stat-num{font-size:20px;font-weight:800;color:#fff;line-height:1.2}
.stat-label{font-size:12px;color:#666;margin-top:2px}

/* FILTER TABS */
.filter-tabs{display:flex;gap:8px;flex-wrap:wrap}
.tab{padding:8px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;color:#666;background:#111;border:1px solid #1e1e1e;transition:.2s;display:flex;align-items:center;gap:6px}
.tab:hover{color:#fff;border-color:#333}
.tab.active{background:rgba(212,163,115,.1);color:#D4A373;border-color:rgba(212,163,115,.3)}
.dot{width:7px;height:7px;border-radius:50%;display:inline-block}
.dot-pending{background:#fbbf24}
.dot-approved{background:#4ade80}
.dot-rejected{background:#f87171}

/* TABLE */
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}
.dtable{width:100%;border-collapse:collapse}
.dtable th{background:#0d0d0d;color:#D4A373;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:14px 18px;text-align:left;border-bottom:1px solid #1a1a1a;white-space:nowrap}
.dtable td{padding:14px 18px;border-bottom:1px solid #161616;vertical-align:middle}
.dtable tbody tr:hover{background:#141414}
.row-pending{border-left:3px solid #fbbf24}
.empty{text-align:center;color:#666;padding:50px;font-style:italic}

/* AFFILIATE INFO */
.aff-info{display:flex;align-items:center;gap:10px}
.aff-avatar{width:36px;height:36px;border-radius:50%;background:rgba(212,163,115,.15);border:1px solid rgba(212,163,115,.3);color:#D4A373;font-size:14px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.aff-name{color:#fff;font-weight:600;font-size:14px}
.aff-code{color:#666;font-size:12px;margin-top:2px}

/* AMOUNT */
.amount{color:#fff;font-weight:700;font-size:15px}

/* BANK INFO */
.bank-info{display:flex;flex-direction:column;gap:2px}
.bank-name{color:#D4A373;font-weight:700;font-size:13px}
.bank-num{color:#ccc;font-family:monospace;font-size:13px}
.bank-owner{color:#666;font-size:12px}

/* DATE */
.date-text{display:block;color:#ccc;font-size:13px}
.time-text{display:block;color:#555;font-size:11px;margin-top:2px}

/* BADGES */
.bdg{padding:5px 12px;border-radius:20px;font-size:11px;font-weight:700;display:inline-flex;align-items:center;gap:5px}
.succ{background:rgba(16,185,129,.1);color:#4ade80;border:1px solid rgba(16,185,129,.3)}
.warn{background:rgba(251,191,36,.1);color:#fbbf24;border:1px solid rgba(251,191,36,.3)}
.dang{background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.3)}

/* BUTTONS */
.btn-review{background:rgba(212,163,115,.08);border:1px solid rgba(212,163,115,.3);color:#D4A373;padding:7px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;transition:.2s;display:inline-flex;align-items:center;gap:5px}
.btn-review:hover{background:#D4A373;color:#111}

/* PAGINATION */
.pagination-wrap{padding:16px 18px;border-top:1px solid #161616}
</style>
@endsection