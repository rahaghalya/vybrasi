@extends('layouts.admin')
@section('content')
@include('pages_admin.partials.cms_style')
<div style="padding: 5px 10px;">
    @if(session('success')) <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div> @endif
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
@endsection