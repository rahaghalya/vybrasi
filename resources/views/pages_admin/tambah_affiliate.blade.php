@extends('layouts.admin')

@section('title', 'Tambah Affiliate Baru')

@section('content')
<div class="tambah-affiliate-container">
    
    <a href="{{ route('admin.affiliate') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Affiliate
    </a>

    <h2 class="affiliate-title">Tambah Mitra Baru</h2>

    <div class="dark-form-card">
        <form action="#" method="POST">
            @csrf
            
            <h3 class="dark-form-title">Data Identitas Mitra</h3>

            <div class="form-grid">
                <div class="form-group full-width">
                    <div class="dark-form-group">
                        <label>Nama Lengkap Affiliate</label>
                        <input type="text" class="dark-input-premium" placeholder="Masukkan nama lengkap mitra">
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>Alamat Email</label>
                        <input type="email" class="dark-input-premium" placeholder="email@contoh.com">
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>Nomor Telepon / WhatsApp</label>
                        <input type="text" class="dark-input-premium" placeholder="0812xxxx">
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>ID Affiliate (Generate)</label>
                        <input type="text" class="dark-input-premium" value="AF-007" readonly style="opacity: 0.7; cursor: not-allowed;">
                        <div class="id-info-box">ID ini akan dibuat secara otomatis oleh sistem.</div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>Status Awal</label>
                        <select class="dark-input-premium" style="appearance: none;">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions" style="border-top: 1px solid rgba(212, 163, 115, 0.1); margin-top: 40px; padding-top: 25px;">
                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('admin.affiliate') }}'" style="border-color: #B5A8A0; color: #B5A8A0;">Batal</button>
                <button type="submit" class="btn-add-affiliate"><i class="fas fa-user-plus"></i> Simpan Data Mitra</button>
            </div>
        </form>
    </div>

</div>
@endsection