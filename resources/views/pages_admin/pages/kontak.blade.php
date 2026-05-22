@extends('layouts.app')

@section('title', 'Vybrasi - Kontak Kami')

@section('content')
<div class="vy-luxury-contact-wrapper">
    
    {{-- BARIS 1: INFO KONTAK & LAYANAN EKSKLUSIF --}}
    <div class="vy-contact-row">
        
        {{-- Kolom Kiri: Informasi Kontak --}}
        <div class="contact-editorial-info fade-in-up">
            <span class="badge-serif">Pusat Layanan</span>
            <h2 class="editorial-title">Kontak<br><i class="serif-accent">Kami.</i></h2>
            <div class="editorial-hairline"></div>
            
            <div class="luxury-info-grid">
                <div class="luxury-info-box">
                    <div class="info-meta">
                        <i class="fa-brands fa-whatsapp"></i>
                        <h4>WhatsApp</h4>
                    </div>
                    <p>083546795016</p>
                </div>
                
                <div class="luxury-info-box">
                    <div class="info-meta">
                        <i class="fa-regular fa-envelope"></i>
                        <h4>Email</h4>
                    </div>
                    <p>vybrasi@gmail.com</p>
                </div>
                
                <div class="luxury-info-box">
                    <div class="info-meta">
                        <i class="fa-solid fa-location-dot"></i>
                        <h4>Alamat</h4>
                    </div>
                    <p>Jl. Example, No. 21, Sidoarjo</p>
                </div>
                
                <div class="luxury-info-box">
                    <div class="info-meta">
                        <i class="fa-solid fa-globe"></i>
                        <h4>Jangkauan</h4>
                    </div>
                    <p>Melayani pengiriman domestik<br>ke seluruh wilayah Nusantara.</p>
                </div>
            </div>
        </div>
        
        {{-- Kolom Kanan: Siklus Roastery (Pengganti Layanan Eksklusif) --}}
        <div class="contact-services-section fade-in-up" style="animation-delay: 0.3s;">
            <h3 class="services-heading">Siklus Roastery</h3>
            
            <div class="vy-services-list">
                <div class="service-item">
                    <h4 class="service-title">Batch Sangrai Berkala</h4>
                    <p class="service-desc">Kami melakukan proses sangrai (roasting) dalam batch kecil secara berkala untuk memastikan biji kopi yang Anda terima selalu berada di puncak kesegarannya.</p>
                </div>
                <div class="service-item">
                    <h4 class="service-title">Proses Degassing</h4>
                    <p class="service-desc">Setiap kopi kami biarkan melewati masa istirahat (resting) yang presisi agar pelepasan karbon dioksida optimal, siap untuk diseduh dengan rasa yang seimbang.</p>
                </div>
                <div class="service-item">
                    <h4 class="service-title">Standar Pengemasan</h4>
                    <p class="service-desc">Dikemas dengan standar premium menggunakan katup udara satu arah (one-way valve) untuk mengunci aroma dan menjaga cita rasa tetap utuh hingga ke tangan Anda.</p>
                </div>
            </div>
        </div>
        
    </div>

    {{-- BARIS 2: MANIFESTO & FORM SAPA KAMI --}}
    <div class="vy-contact-row reverse-row">
        
        {{-- Kolom Kiri: Giant Typographic Manifesto --}}
        <div class="contact-manifesto-section fade-in-up">
            <h2 class="giant-manifesto">Setiap<br><i class="serif-accent">Tetes</i><br>Bercerita.</h2>
            <div class="editorial-hairline" style="margin-top: 40px; margin-bottom: 30px;"></div>
            <p class="manifesto-sub">Dedikasi tanpa kompromi dari ruang sangrai kami, diantarkan langsung untuk menyempurnakan cangkir Anda.</p>
        </div>
        
        {{-- Kolom Kanan: Luxury Form --}}
        <div class="contact-editorial-form fade-in-up" style="animation-delay: 0.3s;">
            <h2 class="editorial-subtitle">Sapa Kami di Sini</h2>
            <div class="editorial-hairline"></div>
            <p class="form-quote">"Tuangkan inspirasi dalam cangkirmu, berikan kesan dan pengalamanmu bersama kami."</p>
            
            {{-- FORM TESTIMONI TERINTEGRASI --}}
            <form action="{{ route('testimoni.store') }}" method="POST" class="vy-premium-form">
                @csrf
                <input type="hidden" name="jenis_ulasan" value="testimoni">
                <input type="hidden" name="invoice" value="INV-GUEST-KONTAK">
                <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

                <div class="form-grid-layout">
                    {{-- Sisi Kiri Form --}}
                    <div class="form-col">
                        <div class="vy-input-group">
                            <label>Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="nama" value="{{ auth()->check() ? auth()->user()->full_name : '' }}" required placeholder="Masukkan nama Anda">
                        </div>
                        <div class="vy-input-group">
                            <label>Alamat Email</label>
                            <input type="email" name="email" placeholder="nama@email.com">
                        </div>
                        
                        <div class="vy-input-group rating-group">
                            <label>Penilaian Anda <span class="req">*</span></label>
                            <div class="star-rating-kontak">
                                <input type="radio" id="ks5" name="rating" value="5" required><label for="ks5">★</label>
                                <input type="radio" id="ks4" name="rating" value="4"><label for="ks4">★</label>
                                <input type="radio" id="ks3" name="rating" value="3"><label for="ks3">★</label>
                                <input type="radio" id="ks2" name="rating" value="2"><label for="ks2">★</label>
                                <input type="radio" id="ks1" name="rating" value="1"><label for="ks1">★</label>
                            </div>
                        </div>
                    </div>

                    {{-- Sisi Kanan Form --}}
                    <div class="form-col text-col">
                        <div class="vy-input-group h-100">
                            <label>Pesan / Kesan <span class="req">*</span></label>
                            <textarea name="ulasan_teks" required placeholder="Tuliskan pengalaman atau pesan Anda untuk kami..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-action">
                    <button type="submit" class="btn-luxury-submit">Kirim Pesan</button>
                </div>
            </form>
        </div>
        
    </div>

</div>

{{-- TOAST NOTIFICATION --}}
<div id="custom-toast" class="custom-toast" style="display: none; position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); background: var(--vy-pine); color: var(--vy-cream); padding: 15px 30px; border-radius: 2px; box-shadow: 0 10px 30px rgba(30, 38, 31, 0.3); z-index: 10000; font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 600; letter-spacing: 0.1em; align-items: center; gap: 12px; border: 1px solid var(--vy-sage);">
    <i class="fa-solid fa-circle-check" style="color: var(--vy-sage); font-size: 16px;"></i>
    <span id="toast-message">Pesan notifikasi di sini.</span>
</div>

<script>
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