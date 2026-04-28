@extends('layouts.admin')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="laporan-container">
    
    <h2 class="laporan-title">LAPORAN TRANSAKSI</h2>

    <div class="laporan-toolbar">
        <div class="laporan-filters">
            <div class="dark-input-group">
                <i class="far fa-calendar-alt"></i>
                <input type="text" value="Februari 2026" readonly>
            </div>
            
            <div class="dark-input-group">
                <select>
                    <option value="semua">Semua Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="diproses">Diproses</option>
                </select>
            </div>
        </div>

        <button type="button" class="btn-download-pdf">Unduh Laporan (PDF)</button>
    </div>

    <table class="laporan-table">
        <thead>
            <tr>
                <th>ID<br>Pesanan</th>
                <th>Tanggal</th>
                <th>Nama<br>Pelanggan</th>
                <th>Sumber</th>
                <th>Total<br>Pembayaran (Rp)</th>
                <th>Status<br>Pembayaran</th>
                <th>Status<br>Pesanan</th>
                <th>Aksi</th>
            </tr>
        </thead>
<tbody>
                <tr>
                    <td>TRX-001</td>
                    <td>26 Apr 2026</td>
                    <td>Fadil Prasetyo</td>
                    <td><div class="sumber-text">Affiliate<span>(AF-001)</span></div></td>
                    <td>Rp 220.000</td>
                    <td><span class="badge-status bg-lunas">Berhasil</span></td>
                    <td><span class="badge-status bg-selesai">Selesai</span></td>
                    <td>
                        <a href="{{ url('/admin/transaksi/detail/TRX-001') }}" class="btn-lihat-detail">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>TRX-002</td>
                    <td>25 Apr 2026</td>
                    <td>Raha</td>
                    <td><div class="sumber-text">Organik<span>(Website)</span></div></td>
                    <td>Rp 150.000</td>
                    <td><span class="badge-status bg-lunas">Berhasil</span></td>
                    <td><span class="badge-status bg-diproses">Diproses</span></td>
                    <td>
                        <a href="{{ url('/admin/transaksi/detail/TRX-002') }}" class="btn-lihat-detail">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>TRX-003</td>
                    <td>25 Apr 2026</td>
                    <td>Budi Santoso</td>
                    <td><div class="sumber-text">Organik<span>(Website)</span></div></td>
                    <td>Rp 345.000</td>
                    <td><span class="badge-status bg-lunas">Berhasil</span></td>
                    <td><span class="badge-status bg-kurir">Menunggu Kurir</span></td>
                    <td>
                        <a href="{{ url('/admin/transaksi/detail/TRX-003') }}" class="btn-lihat-detail">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </td>
                </tr>

                <tr>
                    <td>TRX-004</td>
                    <td>24 Apr 2026</td>
                    <td>Siti Aminah</td>
                    <td><div class="sumber-text">Affiliate<span>(AF-002)</span></div></td>
                    <td>Rp 85.000</td>
                    <td><span class="badge-status bg-gagal">Gagal</span></td>
                    <td><span class="badge-status bg-batal">Dibatalkan</span></td>
                    <td>
                        <a href="{{ url('/admin/transaksi/detail/TRX-004') }}" class="btn-lihat-detail">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </td>
                </tr>
            </tbody>
    </table>

    <div class="laporan-footer">
        <div class="pagination-center">
            <a href="#" class="page-item">Prev</a>
            <a href="#" class="page-item active">1</a>
            <a href="#" class="page-item">2</a>
            <a href="#" class="page-item">3</a>
            <a href="#" class="page-item">4</a>
            <a href="#" class="page-item">Next</a>
        </div>
        <div class="footer-info">
            Menampilkan 8 dari 45 transaksi
        </div>
    </div>

</div>
@endsection