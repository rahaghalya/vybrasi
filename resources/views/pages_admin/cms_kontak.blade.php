@extends('layouts.admin')
@section('content')
@include('pages_admin.partials.cms_style')
<div style="padding: 5px 10px;">
    @if(session('success')) <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div> @endif
<<<<<<< HEAD
    
    {{-- Arahkan ke route update konten yang sama dengan Beranda --}}
    <form action="{{ route('admin.konten.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- KELOLA TEKS KONTAK --}}
        <div class="cms-header">
            <h2>Kelola Info Kontak</h2>
            <p>Atur teks informasi, nomor WhatsApp, dan jam operasional</p>
        </div>
        <div class="cms-card">
            <div class="form-group">
                <label>Nomor WhatsApp</label>
                <input type="text" name="kontak_wa" class="form-control" value="{{ $cms['kontak_wa'] ?? '' }}" placeholder="Contoh: 083546795016">
            </div>
            <div class="form-group">
                <label>Email Utama</label>
                <input type="email" name="kontak_email" class="form-control" value="{{ $cms['kontak_email'] ?? '' }}" placeholder="Contoh: vybrasi@gmail.com">
            </div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="kontak_alamat" class="form-control" style="min-height: 60px;" placeholder="Contoh: Jl. Pegunungan Sepakung No. 1">{{ $cms['kontak_alamat'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Jam Operasional (Gunakan tag &lt;br&gt; untuk enter/baris baru)</label>
                <textarea name="kontak_operasional" class="form-control" style="min-height: 80px;" placeholder="Minggu – Kamis (16.00 – 23.00)<br>Jumat – Sabtu (16.00 – 00.00)">{{ $cms['kontak_operasional'] ?? '' }}</textarea>
            </div>
            <div class="form-group">
                <label>Kata Sapaan (Di atas form ulasan)</label>
                <textarea name="kontak_teks_form" class="form-control" style="min-height: 60px;">{{ $cms['kontak_teks_form'] ?? '' }}</textarea>
            </div>
        </div>

        {{-- KELOLA GAMBAR HALAMAN KONTAK --}}
        <div class="cms-header">
            <h2>Kelola Gambar Kontak</h2>
            <p>Atur 4 gambar estetik yang mengelilingi form (Samping Kiri & Kanan)</p>
        </div>
        <div class="cms-card">
            <div class="img-grid" style="grid-template-columns: repeat(2, 1fr); gap: 20px;">
                {{-- GAMBAR 1 --}}
                <div class="form-group" style="margin:0;">
                    <label>Gambar 1 (Atas Kiri)</label>
                    <label class="img-box upload-box" for="k_img1" style="height: 220px;">
                        @if(isset($cms['kontak_img_1'])) <img src="{{ asset($cms['kontak_img_1']) }}" style="margin-bottom:10px; max-height:100px;"> @endif
                        <i class="fa-solid fa-camera"></i><p id="txt-k1">Upload Gambar 1</p>
                        <input type="file" id="k_img1" name="kontak_img_1" accept="image/*" onchange="updateFilename(this, 'txt-k1')">
                    </label>
                </div>
                {{-- GAMBAR 2 --}}
                <div class="form-group" style="margin:0;">
                    <label>Gambar 2 (Tengah Kiri)</label>
                    <label class="img-box upload-box" for="k_img2" style="height: 220px;">
                        @if(isset($cms['kontak_img_2'])) <img src="{{ asset($cms['kontak_img_2']) }}" style="margin-bottom:10px; max-height:100px;"> @endif
                        <i class="fa-solid fa-camera"></i><p id="txt-k2">Upload Gambar 2</p>
                        <input type="file" id="k_img2" name="kontak_img_2" accept="image/*" onchange="updateFilename(this, 'txt-k2')">
                    </label>
                </div>
                {{-- GAMBAR 3 --}}
                <div class="form-group" style="margin:0;">
                    <label>Gambar 3 (Bawah Kanan)</label>
                    <label class="img-box upload-box" for="k_img3" style="height: 220px;">
                        @if(isset($cms['kontak_img_3'])) <img src="{{ asset($cms['kontak_img_3']) }}" style="margin-bottom:10px; max-height:100px;"> @endif
                        <i class="fa-solid fa-camera"></i><p id="txt-k3">Upload Gambar 3</p>
                        <input type="file" id="k_img3" name="kontak_img_3" accept="image/*" onchange="updateFilename(this, 'txt-k3')">
                    </label>
                </div>
                {{-- GAMBAR 4 --}}
                <div class="form-group" style="margin:0;">
                    <label>Gambar 4 (Pojok Kanan)</label>
                    <label class="img-box upload-box" for="k_img4" style="height: 220px;">
                        @if(isset($cms['kontak_img_4'])) <img src="{{ asset($cms['kontak_img_4']) }}" style="margin-bottom:10px; max-height:100px;"> @endif
                        <i class="fa-solid fa-camera"></i><p id="txt-k4">Upload Gambar 4</p>
                        <input type="file" id="k_img4" name="kontak_img_4" accept="image/*" onchange="updateFilename(this, 'txt-k4')">
                    </label>
                </div>
            </div>
            <div class="btn-row" style="margin-top: 30px;">
                <button type="submit" class="btn-simpan">Simpan Perubahan Kontak</button>
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
=======
    <form action="{{ route('admin.konten.update') }}" method="POST">
        @csrf
        <div class="cms-header"><h2>Kontak & Sosial Media</h2><p>Atur tautan yang akan muncul di Footer website</p></div>
        <div class="cms-card">
            <div class="form-group">
                <label><i class="fab fa-whatsapp"></i> Link / Nomor WhatsApp</label>
                <input type="text" name="wa_link" class="form-control" placeholder="Contoh: https://wa.me/628123456" value="{{ $cms['wa_link'] ?? '' }}">
            </div>
            <div class="form-group">
                <label><i class="fas fa-map-marker-alt"></i> Alamat Toko (Muncul di Footer)</label>
                <textarea name="store_address" class="form-control" style="min-height: 60px;">{{ $cms['store_address'] ?? 'Jl. Sidoarjo No. 21, Sidoarjo, Jawa Timur' }}</textarea>
            </div>
            <div class="form-group">
                <label><i class="fab fa-instagram"></i> Link Akun Instagram</label>
                <input type="text" name="ig_link" class="form-control" placeholder="Contoh: https://instagram.com/vybrasi" value="{{ $cms['ig_link'] ?? '' }}">
            </div>
            <div class="form-group">
                <label><i class="fa-regular fa-envelope"></i> Alamat Email</label>
                <input type="email" name="email_link" class="form-control" placeholder="Contoh: halo@vybrasi.com" value="{{ $cms['email_link'] ?? '' }}">
            </div>
            <div class="btn-row"><button type="submit" class="btn-simpan">Simpan Perubahan</button></div>
        </div>
    </form>
</div>
>>>>>>> frontend-ui
@endsection