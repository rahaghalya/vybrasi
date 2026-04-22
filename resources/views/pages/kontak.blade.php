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
                    <p>083546795016</p>
                </div>
                <div class="info-box">
                    <div class="info-box-header">
                        <i class="fa-regular fa-envelope"></i>
                        <h4>Email</h4>
                    </div>
                    <p>vybrasi@gmail.com</p>
                </div>
                <div class="info-box">
                    <div class="info-box-header">
                        <i class="fa-solid fa-location-dot"></i>
                        <h4>Alamat</h4>
                    </div>
                    <p>Jl. Example, No. 21, Surabaya</p>
                </div>
                <div class="info-box">
                    <div class="info-box-header">
                        <i class="fa-regular fa-clock"></i>
                        <h4>Operasional</h4>
                    </div>
                    <p>Minggu – Kamis (16.00 – 23.00)<br>Jumat – Sabtu (16.00 – 00.00)</p>
                </div>
            </div>
        </div>
        
        <div class="kontak-images-section">
            <div class="kontak-blob top-blob"></div>
            <img src="{{ asset('images/interior.png') }}" class="k-img-1" alt="Cafe Interior">
            <img src="{{ asset('images/barista.png') }}" class="k-img-2" alt="Barista">
        </div>
    </div>

    <div class="kontak-row reverse-row">
        <div class="kontak-images-section">
            <div class="kontak-blob bottom-blob"></div>
            <img src="{{ asset('images/espresso.png') }}" class="k-img-3" alt="Espresso">
            <img src="{{ asset('images/machine.png') }}" class="k-img-4" alt="Coffee Machine">
        </div>
        
        <div class="kontak-card">
            <h2>Sapa Kami di Sini</h2>
            <hr class="kontak-divider">
            <p class="form-subtitle">"Tuangkan inspirasi dalam cangkirmu, mulai dengan menyapa kami di sini."</p>
            
            <form action="#" method="POST" class="kontak-form">
                @csrf
                <div class="form-left">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" placeholder="Masukan nama anda">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="Masukan email anda">
                    </div>
                </div>
                <div class="form-right">
                    <div class="form-group">
                        <label>Pesan</label>
                        <textarea placeholder="Tuliskan pesan anda untuk kami..."></textarea>
                    </div>
                </div>
                <div class="form-submit">
                    <button type="submit" class="btn-kirim">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection