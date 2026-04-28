@extends('layouts.admin')
@section('title', 'Pesanan Baru (Kitchen Display)')

@section('content')
<div class="pesanan-baru-container">
    <h2 class="pesanan-baru-title">DAFTAR PESANAN</h2>

    <div class="kanban-board">
        
<div class="kanban-column" id="col-masuk">
            <div class="kanban-header">
                <h3>Pesanan Baru Masuk</h3>
                <span class="order-count" id="count-masuk">3</span>
            </div>
            <div class="kanban-body">
                
                <div class="receipt-card" id="order-VF671" data-timestamp="13">
                    <div class="receipt-header">
                        <span class="order-id">#VF671</span>
                        <span class="order-timer">
                            <i class="fas fa-clock"></i> <span class="time-text">13</span> mnt lalu
                        </span>
                    </div>
                    <div class="receipt-customer"><i class="fas fa-user-circle"></i> A</div>
                    <div class="receipt-items">
                        <div class="item-row"><span class="item-qty">2x</span><span class="item-name">Kopi Arabica Gayo</span></div>
                        <div class="item-row"><span class="item-qty">1x</span><span class="item-name">Signature Drip Bag</span></div>
                    </div>
                    <div class="receipt-total">
                        <span>TOTAL</span><span>Rp 120.000</span>
                    </div>
                    <div class="aksi-buttons" id="action-VF671">
                        <button class="btn-tolak" onclick="tolakPesanan('order-VF671')">Tolak</button>
                        <button class="btn-terima" onclick="terimaPesanan('order-VF671')">Terima</button>
                    </div>
                </div>

                <div class="receipt-card" id="order-VF672" data-timestamp="9">
                    <div class="receipt-header">
                        <span class="order-id">#VF672</span>
                        <span class="order-timer">
                            <i class="fas fa-clock"></i> <span class="time-text">9</span> mnt lalu
                        </span>
                    </div>
                    <div class="receipt-customer"><i class="fas fa-user-circle"></i> B</div>
                    <div class="receipt-items">
                        <div class="item-row"><span class="item-qty">1x</span><span class="item-name">Gula Aren Asli Nusantara</span></div>
                    </div>
                    <div class="receipt-total">
                        <span>TOTAL</span><span>Rp 55.000</span>
                    </div>
                    <div class="aksi-buttons" id="action-VF672">
                        <button class="btn-tolak" onclick="tolakPesanan('order-VF672')">Tolak</button>
                        <button class="btn-terima" onclick="terimaPesanan('order-VF672')">Terima</button>
                    </div>
                </div>

                <div class="receipt-card" id="order-VF673" data-timestamp="3">
                    <div class="receipt-header">
                        <span class="order-id">#VF673</span>
                        <span class="order-timer">
                            <i class="fas fa-clock"></i> <span class="time-text">3</span> mnt lalu
                        </span>
                    </div>
                    <div class="receipt-customer"><i class="fas fa-user-circle"></i> C</div>
                    <div class="receipt-items">
                        <div class="item-row"><span class="item-qty">3x</span><span class="item-name">Cold Brew Original</span></div>
                    </div>
                    <div class="receipt-total">
                        <span>TOTAL</span><span>Rp 90.000</span>
                    </div>
                    <div class="aksi-buttons" id="action-VF673">
                        <button class="btn-tolak" onclick="tolakPesanan('order-VF673')">Tolak</button>
                        <button class="btn-terima" onclick="terimaPesanan('order-VF673')">Terima</button>
                    </div>
                </div>

            </div>
        </div>

        <div class="kanban-column" id="col-racik">
            <div class="kanban-header">
                <h3>Pesanan Sedang Disiapkan</h3>
                <span class="order-count" id="count-racik">0</span>
            </div>
            <div class="kanban-body"></div>
        </div>

        <div class="kanban-column" id="col-siap">
            <div class="kanban-header">
                <h3>Pesanan Telah Diantar</h3>
                <span class="order-count" id="count-siap">0</span>
            </div>
            <div class="kanban-body"></div>
        </div>

    </div>
</div>

<script>
    // 1. UPDATE ANGKA PADA HEADER KOLOM
    function updateCounters() {
        document.getElementById('count-masuk').innerText = document.querySelectorAll('#col-masuk .receipt-card').length;
        document.getElementById('count-racik').innerText = document.querySelectorAll('#col-racik .receipt-card').length;
        document.getElementById('count-siap').innerText = document.querySelectorAll('#col-siap .receipt-card').length;
    }

    // 2. LOGIKA SLA (WAKTU, WARNA & AUTO-SORT FIFO)
    function applySLA() {
        const container = document.querySelector('#col-masuk .kanban-body');
        if (!container) return; // Mencegah error jika elemen tidak ada

        const cards = Array.from(container.querySelectorAll('.receipt-card'));

        cards.forEach(card => {
            // Ambil angka waktu
            let minutesElapsed = parseInt(card.getAttribute('data-timestamp'));
            
            // Update teks di HTML
            const timeText = card.querySelector('.time-text');
            if (timeText) timeText.innerText = minutesElapsed;

            // Bersihkan warna lama
            card.classList.remove('status-low', 'status-mid', 'status-high');

            // Berikan warna baru sesuai waktu
            if (minutesElapsed < 5) {
                card.classList.add('status-low'); // Hijau
            } else if (minutesElapsed >= 5 && minutesElapsed <= 10) {
                card.classList.add('status-mid'); // Kuning
            } else {
                card.classList.add('status-high'); // Merah
            }
        });

        // Urutkan dari Terlama ke Terbaru
        cards.sort((a, b) => {
            return parseInt(b.getAttribute('data-timestamp')) - parseInt(a.getAttribute('data-timestamp'));
        });

        // Susun ulang di layar
        cards.forEach(card => container.appendChild(card));
    }

    // Fungsi penambah 1 menit otomatis
    function addOneMinute() {
        const cards = document.querySelectorAll('#col-masuk .receipt-card');
        cards.forEach(card => {
            let currentMin = parseInt(card.getAttribute('data-timestamp'));
            card.setAttribute('data-timestamp', currentMin + 1); 
        });
        applySLA(); // Warnai dan urutkan lagi
    }

    // TRIGGER OTOMATIS (Ini yang sebelumnya terlewat)
    // Jalankan pewarnaan pertama kali saat halaman dibuka
    document.addEventListener('DOMContentLoaded', applySLA);
    
    // Jalankan penambahan waktu setiap 1 menit (60000 milidetik)
    setInterval(addOneMinute, 60000);

    // 3. AKSI KANBAN: TOLAK PESANAN
    function tolakPesanan(orderId) {
        if(confirm('Yakin ingin menolak pesanan ini?')) {
            const card = document.getElementById(orderId);
            card.style.opacity = '0';
            setTimeout(() => {
                card.remove();
                updateCounters();
            }, 300);
        }
    }

    // 4. AKSI KANBAN: TERIMA PESANAN
    function terimaPesanan(orderId) {
        const card = document.getElementById(orderId);
        const targetBody = document.querySelector('#col-racik .kanban-body');
        
        card.style.opacity = '0.5';
        card.style.transform = 'scale(0.95)';

        setTimeout(() => {
            targetBody.appendChild(card);
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
            
            // Hapus class SLA & Tambah class Processing
            card.classList.remove('status-low', 'status-mid', 'status-high');
            card.classList.add('status-processing'); 
            
            const timerBadge = card.querySelector('.order-timer');
            timerBadge.innerHTML = '<i class="fas fa-fire"></i> Sedang Disiapkan';
            timerBadge.style.color = '#D4A373';
            timerBadge.style.background = 'rgba(212, 163, 115, 0.1)';

            const actionContainer = document.getElementById(`action-${orderId.split('-')[1]}`);
            actionContainer.innerHTML = `
                <button class="btn-kanban" onclick="selesaiRacik('${orderId}')">
                    <i class="fas fa-check"></i> Selesai Disiapkan
                </button>
            `;

            updateCounters();
        }, 200);
    }

    // 5. AKSI KANBAN: SELESAI DISIAPKAN
    function selesaiRacik(orderId) {
        const card = document.getElementById(orderId);
        const targetBody = document.querySelector('#col-siap .kanban-body');
        
        card.style.opacity = '0.5';
        setTimeout(() => {
            targetBody.appendChild(card);
            card.style.opacity = '1';

            // Hapus class Processing & Tambah class Ready
            card.classList.remove('status-processing');
            card.classList.add('status-ready');

            const timerBadge = card.querySelector('.order-timer');
            timerBadge.innerHTML = '<i class="fas fa-paper-plane"></i> Sedang Dikirim';
            timerBadge.style.color = '#3498db';
            timerBadge.style.background = 'rgba(52, 152, 219, 0.1)';

            const actionContainer = document.getElementById(`action-${orderId.split('-')[1]}`);
            actionContainer.innerHTML = `
                <button class="btn-kanban" onclick="kirimPesanan('${orderId}')" style="background-color: #27ae60; color: white;">
                    <i class="fas fa-check-circle"></i> Pesanan Selesai
                </button>
            `;

            updateCounters();
        }, 200);
    }

    // 6. AKSI KANBAN: SELESAIKAN TRANSAKSI
    function kirimPesanan(orderId) {
        const card = document.getElementById(orderId);
        card.style.opacity = '0';
        card.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            card.remove();
            updateCounters();
        }, 300);
    }
</script>
@endsection