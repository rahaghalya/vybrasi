@extends('layouts.admin')

@section('content')

{{-- Override semua background putih dari parent layout --}}
<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] {
    background: #0a0a0a !important;
    background-color: #0a0a0a !important;
}
aside, .sidebar, [class*="sidebar"] {
    background: unset !important;
    background-color: unset !important;
}
</style>

<div class="wrap">

    <div style="margin-bottom: 15px;">
        <a href="{{ route('admin.produk') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>
    </div>

    <h2 class="page-title">EDIT DATA PRODUK</h2>

    {{-- Validasi Error --}}
    @if ($errors->any())
        <div class="err-box">
            <i class="fas fa-triangle-exclamation" style="font-size: 16px; margin-top: 2px;"></i>
            <ul style="margin: 0; padding-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- CARD: INFORMASI DASAR --}}
        <div class="card">
            <div class="card-head">
                <span><i class="fa-solid fa-circle-info gold"></i> Informasi Dasar</span>
            </div>
            <div class="pad">
                <div class="frm-grid">
                    <div class="span2">
                        <label class="lbl">Nama Produk <span class="red">*</span></label>
                        <input type="text" name="nama" class="inp" placeholder="ex: Kopi Arabica Gayo" value="{{ old('nama', $produk->nama ?? '') }}" required>
                    </div>

                    <div>
                        <label class="lbl">Kategori Produk</label>
                        <div style="position: relative;">
                            <select name="kategori" class="inp" style="appearance: none; cursor: pointer;">
                                <option value="" style="color:#000;">Pilih Kategori</option>
                                <option value="biji_kopi" style="color:#000;" {{ old('kategori', $produk->kategori ?? '') == 'biji_kopi' ? 'selected' : '' }}>Biji Kopi (Roasted Beans)</option>
                                <option value="kopi_bubuk" style="color:#000;" {{ old('kategori', $produk->kategori ?? '') == 'kopi_bubuk' ? 'selected' : '' }}>Kopi Bubuk (Ground Coffee)</option>
                            </select>
                            <i class="fas fa-chevron-down" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #555; pointer-events: none; font-size: 12px;"></i>
                        </div>
                    </div>

                    <div>
                        <label class="lbl">Harga Produk (Rp) <span class="red">*</span></label>
                        <input type="number" name="harga" class="inp" placeholder="Contoh: 150000" value="{{ old('harga', $produk->harga ?? 0) }}" required min="0">
                    </div>

                    <div>
                        <label class="lbl">Stok Saat Ini <span class="red">*</span></label>
                        <input type="number" name="stok" class="inp" placeholder="Contoh: 50" value="{{ old('stok', $produk->stok ?? 0) }}" required min="0">
                    </div>

                    <div>
                        <label class="lbl">Berat Bersih (Gram) <span class="red">*</span></label>
                        <input type="number" name="berat_gram" class="inp" placeholder="Contoh: 250" value="{{ old('berat_gram', $produk->berat_gram ?? 0) }}" required min="0">
                    </div>

                    <div class="span2">
                        <label class="lbl">Deskripsi Produk <span class="red">*</span></label>
                        <textarea name="deskripsi" class="inp" placeholder="Tuliskan deskripsi rasa, asal kopi, dan catatan lainnya..." style="min-height: 120px; resize: vertical;" required>{{ old('deskripsi', $produk->deskripsi_singkat ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD: MEDIA PRODUK --}}
        <div class="card mt-18">
            <div class="card-head">
                <span><i class="fa-solid fa-image gold"></i> Media Produk</span>
            </div>
            <div class="pad">
                
                {{-- Preview Foto Saat Ini --}}
                <div class="curr-img-box">
                    <img src="{{ $produk->gambar_utama ?? 'https://placehold.co/80x80/111/FFF?text=Foto' }}" alt="Foto Saat Ini">
                    <div>
                        <span style="display: block; font-weight: 700; color: #D4A373; font-size: 13px; margin-bottom: 2px;">FOTO SAAT INI</span>
                        <small style="color: #666; font-size: 12px;">Digunakan sebagai foto utama produk di etalase.</small>
                    </div>
                </div>

                <label class="lbl">Ganti Foto Produk (Opsional)</label>
                <div class="up-area">
                    {{-- Hapus atribut 'required' karena saat edit foto boleh kosong --}}
                    <input type="file" name="gambar_utama" id="file-upload" accept="image/png, image/jpeg, image/jpg">
                    <div id="upload-icon" class="up-ic"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div id="upload-text" class="up-txt">Klik atau Tarik gambar ke area ini jika ingin mengganti</div>
                    <div class="up-sub">Biarkan kosong jika tidak ingin diubah. Format: JPG, PNG (Maks. 2MB)</div>
                </div>
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        <div class="act-row mt-18">
            <a href="{{ route('admin.produk') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
        </div>

    </form>
</div>

<script>
    // Javascript untuk mengubah tampilan area upload saat gambar dipilih
    document.getElementById('file-upload').addEventListener('change', function (e) {
        if (!e.target.files.length) return;
        const fileName = e.target.files[0].name;
        document.getElementById('upload-text').innerHTML = '<span style="color:#D4A373;">File dipilih:</span> ' + fileName;
        document.getElementById('upload-icon').innerHTML = '<i class="fas fa-check-circle" style="color: #4ade80;"></i>';
    });
</script>

<style>
/* CSS SUPER MINIMALIS & DARK IDENTIK */
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease;font-family:inherit;}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

.gold{color:#D4A373}
.red{color:#ef4444}
.mt-18{margin-top:18px}

.btn-back{display:inline-flex;align-items:center;gap:8px;color:#777;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-back:hover{color:#D4A373;transform:translateX(-4px)}

.page-title{margin:0 0 25px 0;font-size:20px;font-weight:800;color:#fff;border-left:4px solid #D4A373;padding-left:12px;letter-spacing:1px}

/* ALERT ERROR */
.err-box{background:rgba(239,68,68,.06);border:1px solid rgba(239,68,68,.2);color:#ef4444;padding:14px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;display:flex;gap:12px;align-items:flex-start}

/* CARD SYSTEM */
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}
.card-head{padding:14px 18px;border-bottom:1px solid #1a1a1a;font-size:14px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.pad{padding:20px}

/* FORM GRID */
.frm-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.span2{grid-column:1 / -1}
@media(max-width:768px){.frm-grid{grid-template-columns:1fr}}

/* INPUTS */
.lbl{font-size:11px;font-weight:700;color:#666;letter-spacing:1px;margin:0 0 8px;text-transform:uppercase;display:block}
.inp{background:#0a0a0a;border:1px solid #1e1e1e;color:#fff;padding:12px 15px;border-radius:8px;width:100%;font-size:13px;outline:none;transition:.2s;font-family:inherit}
.inp:focus{border-color:#D4A373;box-shadow:0 0 0 2px rgba(212,163,115,.15)}
.inp::placeholder{color:#444}

/* CURRENT IMAGE BOX */
.curr-img-box{display:flex;gap:15px;align-items:center;background:#0a0a0a;border:1px solid #1e1e1e;padding:15px;border-radius:10px;margin-bottom:20px}
.curr-img-box img{width:65px;height:65px;object-fit:cover;border-radius:8px;border:1px solid #333}

/* UPLOAD AREA */
.up-area{background:#0a0a0a;border:1px dashed #2a2a2a;border-radius:10px;padding:35px 20px;text-align:center;cursor:pointer;position:relative;transition:.2s}
.up-area:hover{border-color:#D4A373;background:rgba(212,163,115,.03)}
.up-area input[type="file"]{position:absolute;top:0;left:0;width:100%;height:100%;opacity:0;cursor:pointer}
.up-ic{font-size:32px;color:#444;margin-bottom:10px;transition:.2s}
.up-area:hover .up-ic{color:#D4A373}
.up-txt{font-size:14px;color:#ccc;font-weight:600;margin-bottom:5px}
.up-sub{font-size:12px;color:#555}

/* ACTIONS */
.act-row{display:flex;justify-content:flex-end;gap:12px}
.btn-cancel{background:transparent;border:1px solid #2a2a2a;color:#aaa;padding:11px 22px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;transition:.2s}
.btn-cancel:hover{background:#1a1a1a;color:#fff;border-color:#444}
.btn-submit{background:#D4A373;border:none;color:#111;padding:11px 28px;border-radius:8px;font-size:13px;font-weight:800;cursor:pointer;display:inline-flex;align-items:center;gap:8px;transition:.2s}
.btn-submit:hover{background:#b58555;transform:translateY(-2px)}
</style>
@endsection