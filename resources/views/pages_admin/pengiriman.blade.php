@extends('layouts.admin')

@section('title', 'List Pengiriman')

@section('content')
<div class="pengiriman-container">
    
    <h2 class="pengiriman-title">LIST PENGIRIMAN</h2>

    <div class="pengiriman-toolbar">
        <div class="filter-box search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari ID Pesanan/Nama">
        </div>
        
        <div class="filter-box">
            <i class="fas fa-filter"></i>
            <select>
                <option value="">Status</option>
                <option value="siap">Siap Dikirim</option>
                <option value="jalan">Dalam Perjalanan</option>
                <option value="tiba">Tiba di Tujuan</option>
            </select>
        </div>

        <div class="filter-box">
            <i class="far fa-calendar-alt"></i>
            <select>
                <option value="">Tanggal</option>
                <option value="terbaru">Terbaru</option>
                <option value="terlama">Terlama</option>
            </select>
        </div>
    </div>

    <div class="status-ringkasan-bar">
        <div class="ringkasan-title">STATUS RINGKASAN</div>
        <div class="ringkasan-item">Siap Kirim: <span>12</span></div>
        <div class="ringkasan-item">Dalam Perjalanan: <span>25</span></div>
        <div class="ringkasan-item">Tiba: <span>45</span></div>
    </div>

    <table class="pengiriman-table">
        <thead>
            <tr>
                <th>ID<br>Pesanan</th>
                <th>Penerima</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-teks-putih">#VF260501</td>
                <td class="col-teks-putih">Fadil<br>Prasetyo</td>
                <td class="col-teks-putih">Jl. Example,<br>Surabaya</td>
                <td><span class="badge-pengiriman bg-jalan">Dalam<br>Perjalanan</span></td>
                <td><button type="button" class="btn-lihat-detail" onclick="openTrackingModal('JNEX-8899001122')" style="background-color: transparent; border: 1px solid #D4A373; color: #D4A373;">
                    <i class="fas fa-map-marker-alt"></i> Lacak</button></td>
            </tr>

            <tr>
                <td class="col-teks-putih">#VF260501</td>
                <td class="col-teks-putih">Fadil<br>Prasetyo</td>
                <td class="col-teks-putih">Jl. Example,<br>Surabaya</td>
                <td><span class="badge-pengiriman bg-siap">Siap<br>Dikirim</span></td>
                <td><button type="button" class="btn-lihat-detail" onclick="openTrackingModal('JNEX-8899001122')" style="background-color: transparent; border: 1px solid #D4A373; color: #D4A373;">
                    <i class="fas fa-map-marker-alt"></i> Lacak</button></td>
            </tr>

            <tr>
                <td class="col-teks-putih">#VF260501</td>
                <td class="col-teks-putih">Fadil<br>Prasetyo</td>
                <td class="col-teks-putih">Jl. Example,<br>Surabaya</td>
                <td><span class="badge-pengiriman bg-tiba">Tiba di<br>Tujuan</span></td>
                <td><button type="button" class="btn-lihat-detail" onclick="openTrackingModal('JNEX-8899001122')" style="background-color: transparent; border: 1px solid #D4A373; color: #D4A373;">
                    <i class="fas fa-map-marker-alt"></i> Lacak</button></td>
            </tr>
        </tbody>
    </table>

    <div class="pengiriman-footer">
        <div class="pagination-center">
            <a href="#" class="page-item">Prev</a>
            <a href="#" class="page-item active">1</a>
            <a href="#" class="page-item">2</a>
            <a href="#" class="page-item">3</a>
            <a href="#" class="page-item">4</a>
            <a href="#" class="page-item">Next</a>
        </div>
    </div>
</div>

//pop up lacak produk 
<div class="modal-overlay" id="trackingModal">
        <div class="modal-box tracking-box">
            
            <div class="tracking-header" style="flex-direction: column; align-items: flex-start; gap: 15px;">
                <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                    <div>
                        <span style="font-size: 12px; color: #8C7A70; display: block;">ID Pengiriman:</span>
                        <span class="tracking-resi" id="resiNumberDisplay">DEL-TRX-001</span>
                    </div>
                    <div class="tracking-kurir" style="background-color: #D4A373; color: #1B1616; border: none;">
                        <i class="fas fa-motorcycle"></i> Vybrasi Internal
                    </div>
                </div>
                
                <div style="background-color: rgba(212, 163, 115, 0.05); padding: 12px 15px; border-radius: 8px; width: 100%; border: 1px dashed rgba(212, 163, 115, 0.3); text-align: left;">
                    <span style="font-size: 11px; color: #B5A8A0; display: block; margin-bottom: 5px; text-transform: uppercase; font-weight: 600;">Detail Tujuan:</span>
                    <span style="font-size: 14px; color: #1B1616; font-weight: 700; display: block; font-family: 'Montserrat', sans-serif;">Fadil Prasetyo (0812-3456-7890)</span>
                    <span style="font-size: 12px; color: #4A3A36; display: block; margin-top: 3px; line-height: 1.4;">Perumahan Indah Asri Blok C2 No. 15, Sidoarjo</span>
                </div>
            </div>

            <div class="timeline-container">
                
                <div class="timeline-item active">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-time">26 Apr 2026, 14:10 WIB • Sistem</span>
                        <div class="timeline-title">Pesanan Diproses</div>
                        <div class="timeline-desc">Pembayaran tervalidasi. Order diteruskan ke area persiapan.</div>
                    </div>
                </div>

                <div class="timeline-item active">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-time">26 Apr 2026, 14:30 WIB • Admin (Manual Update)</span>
                        <div class="timeline-title">Diserahkan ke Kurir</div>
                        <div class="timeline-desc">Paket diserahkan kepada kurir (Bpk. Anton).</div>
                    </div>
                </div>

                <div class="timeline-item current">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-time">26 Apr 2026, 14:45 WIB • Admin (Manual Update)</span>
                        <div class="timeline-title">Kurir Dalam Perjalanan</div>
                        <div class="timeline-desc">Kurir mengonfirmasi via WhatsApp bahwa paket sedang diantar ke alamat tujuan.</div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <span class="timeline-time">-</span>
                        <div class="timeline-title">Selesai / Terkirim</div>
                        <div class="timeline-desc">Menunggu laporan pengiriman selesai dari kurir.</div>
                    </div>
                </div>

            </div>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button class="btn-close-tracking" onclick="closeTrackingModal()" style="flex: 1; background-color: transparent; border: 1px solid #8C7A70; color: #4A3A36;">Tutup</button>
                <button class="btn-close-tracking" style="flex: 1; background-color: #D4A373; color: #1B1616;"><i class="fas fa-edit"></i> Update Status Manual</button>
            </div>
            
        </div>
    </div>

    <script>
        function openTrackingModal(resiNumber) {
            // Bisa digunakan untuk mengubah teks resi secara dinamis jika diperlukan
            if(resiNumber) {
                document.getElementById('resiNumberDisplay').innerText = resiNumber;
            }
            document.getElementById('trackingModal').classList.add('show');
        }

        function closeTrackingModal() {
            document.getElementById('trackingModal').classList.remove('show');
        }

        // Tutup jika area gelap diklik
        document.getElementById('trackingModal').addEventListener('click', function(e) {
            if(e.target === this) {
                closeTrackingModal();
            }
        });
    </script>
@endsection