<<<<<<< HEAD
<footer>
    <div class="footer-container">
        {{-- BAGIAN 1: MAPS (MENGGANTIKAN LOGO) --}}
        <div class="footer-maps" style="flex: 1; min-width: 250px;">
            <h4 style="margin-bottom: 15px; color: #D4A373; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Lokasi Kami</h4>
            <div style="width: 100%; height: 150px; border-radius: 8px; overflow: hidden; border: 1px solid #333;">
                {{-- Menggunakan link maps yang Bosku berikan --}}
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.273336334544!2d112.7237073!3d-7.4350198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMjYnMDYuMSJTIDExMsKwNDMnMjUuMyJF!5e0!3m2!1sid!2sid!4v1715560000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

        {{-- BAGIAN 2: ALAMAT & SOSMED (DINAMIS CMS) --}}
        <div class="footer-alamat">
            <h4>Alamat</h4>
            {{-- Alamat diambil dari CMS, default ke Sidoarjo --}}
            <p>{{ $cms['store_address'] ?? 'Jl. Sidoarjo No. 21, Sidoarjo, Jawa Timur' }}</p>
            
            <div class="social-icons">
                <a href="{{ $cms['wa_link'] ?? 'https://wa.me/6283114459227' }}" target="_blank" title="Hubungi via WhatsApp">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                
                <a href="{{ $cms['ig_link'] ?? 'https://instagram.com/fdlprsty_' }}" target="_blank" title="Kunjungi Instagram Kami">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                
                <a href="mailto:{{ $cms['email_link'] ?? 'padilprasetyo63@gmail.com' }}" title="Kirim Email ke Kami">
=======
{{-- FOOTER VYBRASI (THE ARCHITECTURAL LAYOUT) --}}
<footer class="architectural-footer">
    <div class="footer-grid-container">
        
        {{-- KOLOM 1: DEDIKASI --}}
        <div class="footer-arch-col">
            <span class="arch-badge">Dedikasi</span>
            <h4 class="arch-heading">Komitmen Kami</h4>

            <p class="arch-desc">
                Menyajikan pengalaman ngopi terbaik langsung ke cangkir Anda,
                dengan standar kualitas premium dan cita rasa yang berkarakter.
            </p>

            <ul class="arch-list">
                <li>
                    <i class="fa-solid fa-check"></i>
                    100% Biji Kopi Pilihan
                </li>

                <li>
                    <i class="fa-solid fa-check"></i>
                    Disangrai Presisi
                </li>

                <li>
                    <i class="fa-solid fa-check"></i>
                    Mendukung Petani Lokal
                </li>
            </ul>
        </div>

        {{-- KOLOM 2: KONEKSI --}}
        <div class="footer-arch-col col-bordered">
            <span class="arch-badge">Koneksi</span>
            <h4 class="arch-heading">Hubungi Kami</h4>

            <p class="arch-address">
                {{ $cms['store_address'] ?? 'Jl. Sidoarjo No. 21, Sidoarjo, Jawa Timur' }}
            </p>

            <div class="arch-socials">
                <a href="{{ $cms['wa_link'] ?? 'https://wa.me/6283114459227' }}" target="_blank">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

                <a href="{{ $cms['ig_link'] ?? 'https://instagram.com/fdlprsty_' }}" target="_blank">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="mailto:{{ $cms['email_link'] ?? 'padilprasetyo63@gmail.com' }}">
>>>>>>> frontend-ui
                    <i class="fa-regular fa-envelope"></i>
                </a>
            </div>
        </div>

<<<<<<< HEAD
        {{-- BAGIAN 3: JAM OPERASIONAL --}}
        <div class="footer-jam">
            <h4>Jam Operasional</h4>
            <ul>
                <li>Minggu – Kamis <span>16.00 – 23.00</span></li>
                <li>Jumat – Sabtu <span>16.00 – 00.00</span></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom" style="text-align: center; padding: 20px 0; width: 100%;">
        <p style="margin: 0;">© 2026 VYBRASI. All Rights Reserved.</p>
    </div>
=======
        {{-- KOLOM 3: MAP --}}
        <div class="footer-arch-col map-column">
            <span class="arch-badge">Navigasi</span>
            <h4 class="arch-heading">Lokasi Kami</h4>

            <div class="arch-map-wrapper">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.273336334544!2d112.7237073!3d-7.4350198!2m3!1f0!2f0!3f0!2f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMjYnMDYuMSJTIDExMsKwNDMnMjUuMyJF!5e0!3m2!1sid!2sid!4v1715560000000!5m2!1sid!2sid"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
        </div>

    </div>

    {{-- COPYRIGHT ONLY --}}
    <div class="footer-bottom-arch">
        <div class="copyright-bar">
            <p>
                © 2026 VYBRASI PREMIUM COFFEE. ALL RIGHTS RESERVED.
            </p>
        </div>
    </div>
>>>>>>> frontend-ui
</footer>