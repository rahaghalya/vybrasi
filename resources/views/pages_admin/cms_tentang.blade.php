@extends('layouts.admin')
@section('content')
@include('pages_admin.partials.cms_style')
<div style="padding: 5px 10px;">
    @if(session('success')) <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div> @endif
    <form action="{{ route('admin.konten.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="cms-header"><h2>Kelola Tentang Kami</h2><p>Atur teks profil dan gambar di halaman Tentang Kami</p></div>
        
        <div class="cms-card">
            {{-- KARTU 1 --}}
            <div class="form-group"><label>Judul Kartu 1</label><input type="text" name="tentang_card_1_title" class="form-control" value="{{ $cms['tentang_card_1_title'] ?? 'Cerita Kami' }}"></div>
            <div class="form-group"><label>Teks Kartu 1</label><textarea name="tentang_cerita_1" class="form-control" style="min-height: 100px;">{{ $cms['tentang_cerita_1'] ?? 'Berawal dari kecintaan terhadap specialty coffee...' }}</textarea></div>
            
            <hr style="border-color: #333; margin: 30px 0;">

            {{-- KARTU 2 --}}
            <div class="form-group"><label>Judul Kartu 2</label><input type="text" name="tentang_card_2_title" class="form-control" value="{{ $cms['tentang_card_2_title'] ?? 'Cerita Kami' }}"></div>
            <div class="form-group"><label>Teks Kartu 2</label><textarea name="tentang_cerita_2" class="form-control" style="min-height: 100px;">{{ $cms['tentang_cerita_2'] ?? 'Kami percaya kopi bukan sekadar minuman...' }}</textarea></div>
            
            <hr style="border-color: #333; margin: 30px 0;">

            {{-- BANNER TENTANG --}}
            <div class="img-grid">
                <div class="form-group" style="margin:0;"><label>Gambar Banner Saat Ini</label><div class="img-box">@if(isset($cms['tentang_image']))<img src="{{ asset($cms['tentang_image']) }}">@else<span>Gunakan default</span>@endif</div></div>
                <div class="form-group" style="margin:0;"><label>Ganti Banner Tentang</label><label class="img-box upload-box" for="tentang_file"><i class="fa-solid fa-cloud-arrow-up"></i><p id="txt-tentang">Upload banner baru</p><input type="file" id="tentang_file" name="tentang_image" accept="image/*" onchange="updateFilename(this, 'txt-tentang')"></label></div>
            </div>
            <div class="btn-row"><button type="submit" class="btn-simpan">Simpan Perubahan</button></div>
        </div>
    </form>
</div>
<script>function updateFilename(input, textId) { if (input.files && input.files[0]) { document.getElementById(textId).innerText = input.files[0].name; document.getElementById(textId).style.color = '#D4A373'; } }</script>
@endsection