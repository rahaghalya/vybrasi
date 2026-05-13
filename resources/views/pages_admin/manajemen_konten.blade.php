@extends('layouts.admin')

@section('content')
<style>
/* STYLING KHUSUS CMS */
.cms-header { margin-bottom: 20px; }
.cms-header h2 { font-size: 20px; color: #fff; margin: 0 0 5px 0; font-weight: 700; }
.cms-header p { color: #888; font-size: 13px; margin: 0; }

.cms-card { background: #111; border: 1px solid #1e1e1e; border-radius: 8px; padding: 25px; margin-bottom: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }

.form-group { margin-bottom: 20px; }
.form-group label { display: block; color: #888; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
.form-control { width: 100%; background: #0a0a0a; border: 1px solid #333; color: #fff; padding: 12px 15px; border-radius: 6px; font-family: inherit; font-size: 14px; transition: 0.3s; }
.form-control:focus { border-color: #D4A373; outline: none; box-shadow: 0 0 0 2px rgba(212,163,115,0.1); }
textarea.form-control { resize: vertical; min-height: 120px; }

/* Grid Upload Gambar Side-by-Side (Persis Referensi Gambar Bosku) */
.img-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 5px; }
.img-box { background: #0a0a0a; border: 1px solid #222; border-radius: 6px; padding: 10px; height: 180px; display: flex; flex-direction: column; justify-content: center; align-items: center; position: relative; overflow: hidden; }
.img-box img { max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 4px; }
.img-box span { color: #555; font-size: 13px; font-style: italic; }

.upload-box { border: 1px dashed #444; background: transparent; cursor: pointer; transition: 0.3s; }
.upload-box:hover { border-color: #D4A373; background: rgba(212, 163, 115, 0.05); }
.upload-box i { font-size: 28px; color: #666; margin-bottom: 10px; transition: 0.3s; }
.upload-box:hover i { color: #D4A373; transform: translateY(-3px); }
.upload-box p { margin: 0; font-size: 13px; color: #aaa; font-weight: 600; }
.upload-box small { font-size: 11px; color: #666; display: block; margin-top: 6px; }
input[type="file"] { display: none; }

.btn-row { display: flex; gap: 12px; margin-top: 30px; }
.btn-simpan { background: #D4A373; color: #111; border: none; padding: 10px 22px; border-radius: 6px; font-weight: 800; cursor: pointer; transition: 0.2s; font-size: 13px; }
.btn-simpan:hover { background: #b58555; }
.btn-batal { background: transparent; color: #aaa; border: 1px solid #333; padding: 10px 22px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 13px; text-decoration: none; }
.btn-batal:hover { background: #1a1a1a; color: #fff; border-color: #555; }
</style>

<div style="padding: 5px 10px;">
    @if(session('success'))
        <div style="background: rgba(16,185,129,.1); color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid rgba(16,185,129,.2);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.konten.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 1. KELOLA BERANDA --}}
        <div class="cms-header">
            <h2>Kelola Beranda</h2>
            <p>Atur konten halaman utama (Hero Section) website</p>
        </div>

        <div class="cms-card">
            <div class="form-group">
                <label>Judul Hero</label>
                <input type="text" name="hero_title" class="form-control" value="{{ $cms['hero_title'] ?? 'Racikan Kopi Premium dengan Sentuhan Gula Aren Asli Nusantara' }}">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="hero_subtitle" class="form-control">{{ $cms['hero_subtitle'] ?? 'Racikan terbaik dengan cita rasa autentik' }}</textarea>
            </div>

            <div class="img-grid">
                <div class="form-group" style="margin:0;">
                    <label>Gambar Saat Ini</label>
                    <div class="img-box">
                        @if(isset($cms['hero_image']))
                            <img src="{{ asset($cms['hero_image']) }}" alt="Hero Web">
                        @else
                            <span>Belum ada gambar (Gunakan default)</span>
                        @endif
                    </div>
                </div>

                <div class="form-group" style="margin:0;">
                    <label>Ganti Gambar Baru</label>
                    <label class="img-box upload-box" for="hero_file">
                        <i class="fa-regular fa-image"></i>
                        <p id="txt-hero">Klik untuk ganti gambar</p>
                        <small>Format: PNG, JPG, JPEG (Maks. 5MB)</small>
                        <input type="file" id="hero_file" name="hero_image" accept="image/*" onchange="updateFilename(this, 'txt-hero')">
                    </label>
                </div>
            </div>
            
            <div class="btn-row">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            </div>
        </div>

        {{-- 2. KELOLA TENTANG KAMI --}}
        <div class="cms-header">
            <h2>Kelola Tentang Kami</h2>
            <p>Atur teks profil dan gambar di halaman Tentang Kami</p>
        </div>

        <div class="cms-card">
            <div class="form-group">
                <label>Teks Profil (Paragraf 1)</label>
                <textarea name="tentang_cerita_1" class="form-control" style="min-height: 80px;">{{ $cms['tentang_cerita_1'] ?? 'Berawal dari kecintaan terhadap specialty coffee, kami menghadirkan biji pilihan dan proses terbaik untuk menciptakan pengalaman kopi yang autentik, konsisten, dan berkelas di setiap sajian.' }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Teks Profil (Paragraf 2)</label>
                <textarea name="tentang_cerita_2" class="form-control" style="min-height: 80px;">{{ $cms['tentang_cerita_2'] ?? 'Kami percaya kopi bukan sekadar minuman, melainkan pengalaman. Melalui seleksi biji terbaik dan proses yang presisi, kami menghadirkan kualitas dan cita rasa yang dapat dinikmati oleh setiap penikmat kopi sejati.' }}</textarea>
            </div>

            <div class="img-grid">
                <div class="form-group" style="margin:0;">
                    <label>Gambar Banner Saat Ini</label>
                    <div class="img-box">
                        @if(isset($cms['tentang_image']))
                            <img src="{{ asset($cms['tentang_image']) }}" alt="Tentang Web">
                        @else
                            <span>Belum ada gambar (Gunakan default)</span>
                        @endif
                    </div>
                </div>

                <div class="form-group" style="margin:0;">
                    <label>Ganti Banner Tentang</label>
                    <label class="img-box upload-box" for="tentang_file">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p id="txt-tentang">Upload banner baru</p>
                        <small>Format: PNG, JPG (Disarankan landscape)</small>
                        <input type="file" id="tentang_file" name="tentang_image" accept="image/*" onchange="updateFilename(this, 'txt-tentang')">
                    </label>
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            </div>
        </div>

        {{-- 3. PENGATURAN UMUM (LINK WA) --}}
        <div class="cms-header">
            <h2>Pengaturan Global</h2>
            <p>Atur kontak dan tautan sosial media</p>
        </div>

        <div class="cms-card" style="margin-bottom: 60px;">
            <div class="form-group">
                <label>Link / Nomor WhatsApp (Mulai dengan https://wa.me/...)</label>
                <input type="text" name="wa_link" class="form-control" value="{{ $cms['wa_link'] ?? 'https://wa.me/6283114459227' }}">
            </div>
            
            <div class="btn-row">
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            </div>
        </div>

    </form>
</div>

<script>
    function updateFilename(input, textId) {
        if (input.files && input.files[0]) {
            document.getElementById(textId).innerText = input.files[0].name;
            document.getElementById(textId).style.color = '#D4A373';
        }
    }
</script>
@endsection