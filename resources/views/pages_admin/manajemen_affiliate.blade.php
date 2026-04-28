@extends('layouts.admin')

@section('title', 'Manajemen Affiliate')

@section('content')
<div class="affiliate-container">
    
    <h2 class="affiliate-title">DAFTAR MITRA AFFILIATE</h2>

    <div class="affiliate-toolbar">
        <div class="dark-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari Affiliate (Nama/Email)">
        </div>
        
        <a href="{{ route('admin.affiliate.tambah') }}" class="btn-add-affiliate" style="text-decoration: none;">
            <i class="fas fa-plus"></i> TAMBAH AFFILIATE BARU
        </a>
    </div>

    <table class="dark-table">
        <thead>
            <tr>
                <th>ID Affiliate</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
       <tbody>
                @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td>AF-00{{ $i + 1 }}</td>
                    <td>Fadil Prasetyo</td>
                    <td>fdl@gmail.com</td>
                    <td>
                        <span class="status-aktif"><span class="status-dot"></span>Aktif</span>
                    </td>
                    
                    <td>
                        <a href="{{ route('admin.affiliate.profil', 1) }}" class="btn-lihat-profil" style="text-decoration: none; display: inline-block;">
                            Lihat Profil
                        </a>
                    </td>

                </tr>
                @endfor
                
                <tr>
                    <td>AF-006</td>
                    <td>Fadil Prasetyo</td>
                    <td>fdl@gmail.com</td>
                    <td>
                        <span class="status-nonaktif"><span class="status-dot"></span>Nonaktif</span>
                    </td>
                    
                    <td>
                        <a href="{{ route('admin.affiliate.profil', 1) }}" class="btn-lihat-profil" style="text-decoration: none; display: inline-block;">
                            Lihat Profil
                        </a>
                    </td>

                </tr>
            </tbody>
    </table>

</div>
@endsection