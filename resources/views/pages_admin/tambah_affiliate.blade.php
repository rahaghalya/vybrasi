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

    <h2 class="page-title">TAMBAH MITRA BARU</h2>

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

    <div class="card">
        <form action="{{ route('admin.affiliate.store') }}" method="POST">
            @csrf
            
            <div class="card-head">
                <span><i class="fa-solid fa-user-tie gold"></i> Data Identitas Mitra</span>
            </div>

            <div class="pad">
                <div class="frm-grid">
                    <div class="span2">
                        <label class="lbl">Nama Lengkap Affiliate <span class="red">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" class="inp" placeholder="Masukkan nama lengkap mitra..." required>
                    </div>

                    <div>
                        <label class="lbl">Alamat Email <span class="red">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="inp" placeholder="email@contoh.com" required>
                    </div>

                    <div>
                        <label class="lbl">Nomor Telepon / WhatsApp <span class="red">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="inp" placeholder="0812xxxx" required>
                    </div>

                    {{-- TAMBAHAN: INPUT PASSWORD --}}
                    <div>
                        <label class="lbl">Password (Opsional)</label>
                        <input type="password" name="password" class="inp" placeholder="Ketik jika ingin buat password manual...">
                        <span class="hint">Kosongkan untuk default: <b>Nama Depan + 4 Digit Akhir No. HP</b></span>
                    </div>

                    <div>
                        <label class="lbl">Kode Referral Unik</label>
                        <input type="text" name="kode_unik" class="inp readonly" value="{{ 'AF-' . strtoupper(\Illuminate\Support\Str::random(5)) }}" readonly>
                        <span class="hint">Kode ini di-generate otomatis oleh sistem.</span>
                    </div>

                    <div class="span2">
                        <label class="lbl">Status Role</label>
                        <select name="role" class="inp readonly" style="appearance: none; pointer-events: none;" tabindex="-1">
                            <option value="affiliate" selected>Affiliate / Mitra</option>
                        </select>
                    </div>
                </div>

                <div class="act-row mt-18">
                    <a href="{{ route('admin.affiliate') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Mitra</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.gold{color:#D4A373} .red{color:#ef4444} .mt-18{margin-top:18px}

.btn-back{display:inline-flex;align-items:center;gap:8px;color:#777;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-back:hover{color:#D4A373;transform:translateX(-4px)}
.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}

/* ALERTS */
.err-box{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);color:#ef4444;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;gap:12px;align-items:flex-start}
.succ-box{background:rgba(16,185,129,.06);border:1px solid rgba(16,185,129,.2);color:#10b981;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;gap:10px;align-items:center;font-weight:600}

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