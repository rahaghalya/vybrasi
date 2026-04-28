@extends('layouts.admin')

@section('title', 'Profil Affiliate')

@section('content')
<div class="tambah-affiliate-container">
    
    <a href="{{ route('admin.affiliate') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Affiliate
    </a>

    <h2 class="affiliate-title">Profil Mitra: Fadil Prasetyo</h2>

    <div class="dark-form-card">
        
        <div class="affiliate-stats-grid">
            <div class="dark-stat-box">
                <div class="dark-stat-value">45</div>
                <div class="dark-stat-label">Pesanan Selesai</div>
            </div>
            <div class="dark-stat-box">
                <div class="dark-stat-value">Rp 1.250K</div>
                <div class="dark-stat-label">Total Komisi</div>
            </div>
        </div>

        <form action="#" method="POST">
            @csrf
            
            <h3 class="dark-form-title">Detail Akun Mitra</h3>

            <div class="form-grid">
                <div class="form-group full-width">
                    <div class="dark-form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="dark-input-premium" value="Fadil Prasetyo">
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>Email</label>
                        <input type="email" class="dark-input-premium" value="fdl@gmail.com">
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>Nomor WhatsApp</label>
                        <input type="text" class="dark-input-premium" value="081234567890">
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>Kode Unik Affiliate</label>
                        <div class="unique-code-wrapper">
                            <input type="text" class="dark-input-premium code-font" value="VYB-FDL-2026" readonly>
                            <button type="button" class="btn-copy-code" title="Salin Kode">
                                <i class="far fa-copy"></i>
                            </button>
                        </div>
                        <small class="input-hint">Kode ini digunakan untuk tracking link penjualan.</small>
                    </div>
                </div>

                <div class="form-group">
                    <div class="dark-form-group">
                        <label>Status Akun saat ini</label>
                        <select class="dark-input-premium status-selector">
                            <option value="aktif" selected>🟢 Aktif (Mitra dapat komisi)</option>
                            <option value="nonaktif">🔴 Nonaktif (Mitra ditangguhkan)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="window.location.href='{{ route('admin.affiliate') }}'">Batal</button>
                <button type="submit" class="btn-add-affiliate"><i class="fas fa-save"></i> Perbarui Profil</button>
            </div>
        </form>
    </div>

</div>
@endsection