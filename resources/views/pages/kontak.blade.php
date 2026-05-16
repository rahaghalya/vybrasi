@extends('layouts.app')

@section('title', 'Vybrasi - Kontak Kami')

@section('content')
<div class="kontak-page-container">
    
    <div class="kontak-row">
        <div class="kontak-card">
            <h2>Kontak Kami</h2>
            <hr class="kontak-divider">
            
            <div class="info-grid">
                <div class="info-box">
                    <div class="info-box-header">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h4>WhatsApp</h4>
                    </div>
                    {{-- Tarik data WA dari CMS --}}
                    <p>{{ $cms['kontak_wa'] ?? '083546795016' }}</p>
                </div>
                <div class="info-box">
                    <div class="info-box-header">
                        <i class="fa-regular fa-envelope"></i>
                        <h4>Email</h4>
                    </div>
                    {{-- Tarik data Email dari CMS --}}
                    <p>{{ $cms['kontak_email'] ?? 'vybrasi@gmail.com' }}</p>
                </div>
                <div class="info-box">
                    <div class="info-box-header">
                        <i class="fa-solid fa-location-dot"></i>
                        <h4>Alamat</h4>
                    </div>
                    {{-- Tarik data Alamat dari CMS --}}
                    <p>{{ $cms['kontak_alamat'] ?? 'Jl. Example, No. 21, Surabaya' }}</p>
                </div>
                <div class="info-box">
                    <div class="info-box-header">
                        <i class="fa-regular fa-clock"></i>
                        <h4>Operasional</h4>
                    </div>
                    {{-- Tarik data Operasional dari CMS (Pakai {!! !!} agar tag <br> bisa terbaca) --}}
                    <p>{!! $cms['kontak_operasional'] ?? 'Minggu – Kamis (16.00 – 23.00)<br>Jumat – Sabtu (16.00 – 00.00)' !!}</p>
                </div>
            </div>
        </div>
        
        <div class="kontak-images-section">
            <div class="kontak-blob top-blob"></div>
            {{-- Tarik Gambar 1 & 2 dari CMS --}}
            <img src="{{ !empty($cms['kontak_img_1']) ? asset($cms['kontak_img_1']) : asset('images/interior.png') }}" class="k-img-1" alt="Cafe Interior">
            <img src="{{ !empty($cms['kontak_img_2']) ? asset($cms['kontak_img_2']) : asset('images/barista.png') }}" class="k-img-2" alt="Barista">
        </div>
    </div>

    <div class="kontak-row reverse-row">
        <div class="kontak-images-section">
            <div class="kontak-blob bottom-blob"></div>
            {{-- Tarik Gambar 3 & 4 dari CMS --}}
            <img src="{{ !empty($cms['kontak_img_3']) ? asset($cms['kontak_img_3']) : asset('images/espresso.png') }}" class="k-img-3" alt="Espresso">
            <img src="{{ !empty($cms['kontak_img_4']) ? asset($cms['kontak_img_4']) : asset('images/machine.png') }}" class="k-img-4" alt="Coffee Machine">
        </div>
        
        <div class="kontak-card">
            <h2>Sapa Kami di Sini</h2>
            <hr class="kontak-divider">
            {{-- Tarik Subtitle Form dari CMS --}}
            <p class="form-subtitle">{{ $cms['kontak_teks_form'] ?? '"Tuangkan inspirasi dalam cangkirmu, berikan kesan dan pengalamanmu bersama kami."' }}</p>
            
            {{-- FORM TESTIMONI TERINTEGRASI --}}
            <form action="{{ route('testimoni.store') }}" method="POST" class="kontak-form">
                @csrf
                {{-- Data Tersembunyi agar lolos validasi backend tanpa error --}}
                <input type="hidden" name="jenis_ulasan" value="testimoni">
                <input type="hidden" name="invoice" value="INV-GUEST-KONTAK">
                <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

                <div class="form-left">
                    <div class="form-group">
                        <label>Nama <span style="color:red;">*</span></label>
                        <input type="text" name="nama" value="{{ auth()->check() ? auth()->user()->full_name : '' }}" required placeholder="Masukan nama anda">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Masukan email anda">
                    </div>
                    
                    {{-- Rating Bintang diselipkan dengan rapi --}}
                    <div class="form-group" style="margin-top: 15px;">
                        <label>Penilaian Anda <span style="color:red;">*</span></label>
                        <div class="star-rating-kontak">
                            <input type="radio" id="ks5" name="rating" value="5" required><label for="ks5">★</label>
                            <input type="radio" id="ks4" name="rating" value="4"><label for="ks4">★</label>
                            <input type="radio" id="ks3" name="rating" value="3"><label for="ks3">★</label>
                            <input type="radio" id="ks2" name="rating" value="2"><label for="ks2">★</label>
                            <input type="radio" id="ks1" name="rating" value="1"><label for="ks1">★</label>
                        </div>
                    </div>
                </div>
                <div class="form-right">
                    <div class="form-group h-100">
                        <label>Pesan / Kesan <span style="color:red;">*</span></label>
                        <textarea name="ulasan_teks" required placeholder="Tuliskan pengalaman atau pesan anda untuk kami..." style="height: 100%; min-height: 150px;"></textarea>
                    </div>
                </div>
                <div class="form-submit">
                    <button type="submit" class="btn-kirim">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- TOAST NOTIFICATION --}}
<div id="custom-toast" class="custom-toast" style="display: none; position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: #28a745; color: white; padding: 12px 25px; border-radius: 30px; box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3); z-index: 10000; font-weight: bold; align-items: center; gap: 8px;">
    <i class="fa-solid fa-circle-check"></i>
    <span id="toast-message">Pesan notifikasi di sini.</span>
</div>

<style>
    /* CSS Tambahan Khusus Bintang di Halaman Kontak */
    .star-rating-kontak { display: flex; flex-direction: row-reverse; justify-content: flex-end; }
    .star-rating-kontak input { display: none; }
    .star-rating-kontak label { color: #e0e0e0; font-size: 30px; cursor: pointer; padding: 0 3px; transition: .2s; }
    .star-rating-kontak input:checked ~ label, .star-rating-kontak label:hover, .star-rating-kontak label:hover ~ label { color: #FFD700; text-shadow: 0 0 8px rgba(255, 215, 0, 0.4); }
    .h-100 { height: 100%; display: flex; flex-direction: column; }
</style>

<script>
    // Memunculkan alert sukses jika dikirim
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('custom-toast');
            document.getElementById('toast-message').textContent = "{{ session('success') }}";
            toast.style.display = 'flex';
            setTimeout(() => { toast.style.display = 'none'; }, 4000);
        });
    @endif
</script>
@endsection