@extends('layouts.admin')
@section('content')
@include('pages_admin.partials.cms_style')
<div style="padding: 5px 10px;">
    @if(session('success')) <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div> @endif
    <form action="{{ route('admin.konten.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- KELOLA HERO --}}
        <div class="cms-header"><h2>Kelola Beranda</h2><p>Atur konten halaman utama (Hero Section) website</p></div>
        <div class="cms-card">
            <div class="form-group"><label>Judul Hero</label><input type="text" name="hero_title" class="form-control" value="{{ $cms['hero_title'] ?? '' }}"></div>
            <div class="form-group"><label>Deskripsi</label><textarea name="hero_subtitle" class="form-control" style="min-height: 80px;">{{ $cms['hero_subtitle'] ?? '' }}</textarea></div>
            <div class="img-grid">
                <div class="form-group" style="margin:0;"><label>Gambar Saat Ini</label><div class="img-box">@if(isset($cms['hero_image']))<img src="{{ asset($cms['hero_image']) }}">@else<span>Gunakan default</span>@endif</div></div>
                <div class="form-group" style="margin:0;"><label>Ganti Gambar Baru</label><label class="img-box upload-box" for="hero_file"><i class="fa-regular fa-image"></i><p id="txt-hero">Klik untuk ganti gambar</p><input type="file" id="hero_file" name="hero_image" accept="image/*" onchange="updateFilename(this, 'txt-hero')"></label></div>
            </div>
        </div>

        {{-- KELOLA GAMBAR SUASANA CAFE --}}
        <div class="cms-header"><h2>Gambar Suasana Cafe</h2><p>Atur 2 gambar foto suasana cafe di Beranda</p></div>
        <div class="cms-card">
            <div class="img-grid">
                {{-- CAFE 1 --}}
                <div class="form-group" style="margin:0;">
                    <label>Gambar Suasana 1 (Kiri/Atas)</label>
                    <label class="img-box upload-box" for="cafe1_file" style="height: 220px;">
                        @if(isset($cms['beranda_cafe_1'])) <img src="{{ asset($cms['beranda_cafe_1']) }}" style="margin-bottom:10px; max-height:100px;"> @endif
                        <i class="fa-solid fa-camera"></i><p id="txt-cafe1">Upload Gambar 1</p>
                        <input type="file" id="cafe1_file" name="beranda_cafe_1" accept="image/*" onchange="updateFilename(this, 'txt-cafe1')">
                    </label>
                </div>
                {{-- CAFE 2 --}}
                <div class="form-group" style="margin:0;">
                    <label>Gambar Suasana 2 (Kanan/Bawah)</label>
                    <label class="img-box upload-box" for="cafe2_file" style="height: 220px;">
                        @if(isset($cms['beranda_cafe_2'])) <img src="{{ asset($cms['beranda_cafe_2']) }}" style="margin-bottom:10px; max-height:100px;"> @endif
                        <i class="fa-solid fa-camera"></i><p id="txt-cafe2">Upload Gambar 2</p>
                        <input type="file" id="cafe2_file" name="beranda_cafe_2" accept="image/*" onchange="updateFilename(this, 'txt-cafe2')">
                    </label>
                </div>
            </div>
            <div class="btn-row"><button type="submit" class="btn-simpan">Simpan Perubahan</button></div>
        </div>
    </form>
</div>
<script>function updateFilename(input, textId) { if (input.files && input.files[0]) { document.getElementById(textId).innerText = input.files[0].name; document.getElementById(textId).style.color = '#D4A373'; } }</script>
@endsection