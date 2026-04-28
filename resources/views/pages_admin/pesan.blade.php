@extends('layouts.admin')
@section('title', 'Vybrasi - Pesan Masuk')

@section('content')
<div class="inbox-wrapper">
    
    <div class="inbox-sidebar">
        <div class="inbox-header">
            <h2 class="inbox-title">Pesan Masuk</h2>
        </div>
        
        <div class="inbox-tabs">
            <button class="tab-btn active" onclick="filterMessages('semua', this)">Semua</button>
            <button class="tab-btn" onclick="filterMessages('belum-dibaca', this)">Belum Dibaca</button>
            <button class="tab-btn" onclick="filterMessages('testimoni', this)">Testimoni</button>
        </div>

        <div class="inbox-list-container">
            <div class="inbox-item unread is-testimony" id="msg-1" onclick="viewMessage('Fadil Prasetyo', 'msg-1')">
                <i class="fas fa-star star-btn starred"></i>
                <div class="item-content">
                    <div class="item-name">A <span class="item-time">10:30 WIB</span></div>
                    <div class="item-snippet">Jujur, kualitasnya di luar ekspektasi! Packagingnya...</div>
                </div>
                <div class="unread-dot"></div>
            </div>

            <div class="inbox-item" id="msg-2" onclick="viewMessage('Siti Aminah', 'msg-2')">
                <i class="far fa-star star-btn"></i>
                <div class="item-content">
                    <div class="item-name">B <span class="item-time">Kemarin</span></div>
                    <div class="item-snippet">Terima kasih, pesanan Drip Bag saya sudah sampai...</div>
                </div>
            </div>

            <div class="inbox-item unread" id="msg-3" onclick="viewMessage('Budi Santoso', 'msg-3')">
                <i class="far fa-star star-btn"></i>
                <div class="item-content">
                    <div class="item-name">C <span class="item-time">24 Apr</span></div>
                    <div class="item-snippet">Apakah Vybrasi menyediakan paket catering kopi?</div>
                </div>
                <div class="unread-dot"></div>
            </div>
        </div>
    </div>

    <div class="inbox-content">
        
        <div id="empty-view" class="empty-state">
            <i class="fas fa-envelope-open-text"></i>
            <h4>Buka Pesan</h4>
            <p>Pilih salah satu pesan di samping untuk meninjau pengalaman pelanggan.</p>
        </div>

        <div id="message-view" style="display: none; height: 100%; flex-direction: column;">
            <div class="message-header">
                <div class="sender-info">
                    <h3 id="sender-name">Nama Pengirim</h3>
                    <p><i class="fas fa-envelope"></i> customer@email.com</p>
                </div>
                <div class="msg-badge badge-new">Pesan Pelanggan</div>
            </div>
            
            <div class="message-body">
                Halo tim Vybrasi!<br><br>
                Saya baru pertama kali mencoba Kopi Arabica Gayo dan Vybrasi Signature Drip Bag-nya. Jujur, kualitasnya di luar ekspektasi! Packaging-nya sangat premium dan aman. Saat Drip Bag-nya diseduh, aroma kopinya langsung memenuhi ruangan kerja saya.<br><br>
                Rasanya sangat smooth, aftertaste-nya luar biasa, dan yang paling penting: sangat nyaman di lambung saya. Benar-benar teman yang pas buat lembur deadline semalaman. Pasti bakal repurchase dan jadi daily coffee saya nih. Terima kasih atas pelayanannya yang memuaskan dan sukses terus untuk Vybrasi Coffee! ✨
            </div>
            
            <div class="message-action-box">
                <button class="btn-delete" onclick="deleteMessage()">
                    <i class="fas fa-trash-alt"></i> Hapus Pesan
                </button>
                
                <div style="display: flex; gap: 12px;">
                    <button class="btn-mark-only" id="btn-mark-read" onclick="markAsRead()">
                        Tandai Sudah Dibaca
                    </button>
                    <button class="btn-publish-testimony" id="btn-toggle-testimoni" onclick="toggleTestimony()">
                        <i class="fas fa-star"></i> Tampilkan sebagai Testimoni
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="toast" class="toast-notification">
    <i class="fas fa-check-circle"></i>
    <span>Notifikasi</span>
</div>

<script>
    let currentMessageId = null;

    // 1. Membuka pesan & Mengatur Tombol Pintar
    function viewMessage(name, id) {
        document.getElementById('empty-view').style.display = 'none';
        document.getElementById('message-view').style.display = 'flex';
        document.getElementById('sender-name').innerText = name;
        
        // Tandai active di sidebar
        document.querySelectorAll('.inbox-item').forEach(item => item.classList.remove('active'));
        const activeItem = document.getElementById(id);
        activeItem.classList.add('active');
        
        // --- LOGIKA TOMBOL PINTAR ---
        const btnMarkRead = document.getElementById('btn-mark-read');
        const btnTestimoni = document.getElementById('btn-toggle-testimoni');

        // Jika pesan masih "unread", tampilkan tombol Tandai Dibaca
        if (activeItem.classList.contains('unread')) {
            btnMarkRead.style.display = 'block';
        } else {
            btnMarkRead.style.display = 'none';
        }

        // Jika pesan sudah menjadi testimoni, ubah UI tombolnya
        if (activeItem.classList.contains('is-testimony')) {
            btnTestimoni.innerHTML = '<i class="fas fa-times-circle"></i> Hapus dari Testimoni';
            btnTestimoni.style.backgroundColor = 'transparent';
            btnTestimoni.style.color = '#B5A8A0';
            btnTestimoni.style.border = '1px solid rgba(181, 168, 160, 0.3)';
        } else {
            btnTestimoni.innerHTML = '<i class="fas fa-star"></i> Tampilkan sebagai Testimoni';
            btnTestimoni.style.backgroundColor = '#D4A373';
            btnTestimoni.style.color = '#1B1616';
            btnTestimoni.style.border = 'none';
        }

        currentMessageId = id;
    }

    // 2. Menutup pesan (ke Empty State)
    function closeMessage() {
        document.getElementById('message-view').style.display = 'none';
        document.getElementById('empty-view').style.display = 'flex';
        document.querySelectorAll('.inbox-item').forEach(item => item.classList.remove('active'));
        currentMessageId = null;
    }

    // 3. Notifikasi Toast Dinamis
    function showToast(pesanTeks, isDanger = false) {
        const toast = document.getElementById('toast');
        const toastIcon = toast.querySelector('i');
        const toastText = toast.querySelector('span');

        toastText.innerText = pesanTeks;

        if (isDanger) {
            toast.style.backgroundColor = '#e74c3c';
            toastIcon.className = 'fas fa-info-circle';
        } else {
            toast.style.backgroundColor = '#27ae60';
            toastIcon.className = 'fas fa-check-circle';
        }

        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // 4. Aksi: Tandai Sudah Dibaca
    function markAsRead() {
        if (currentMessageId) {
            const item = document.getElementById(currentMessageId);
            
            // Hapus class unread & sembunyikan titik merah
            item.classList.remove('unread');
            const dot = item.querySelector('.unread-dot');
            if(dot) dot.style.display = 'none';

            showToast('Pesan ditandai sudah dibaca.');

            // Jika sedang di tab "Belum Dibaca", langsung sembunyikan
            const activeTab = document.querySelector('.tab-btn.active').innerText.trim().toLowerCase();
            if (activeTab === 'belum dibaca') {
                item.style.display = 'none';
            }

            closeMessage();
        }
    }

    // 5. Aksi: Tambah / Hapus Testimoni & Ganti Ikon Bintang
    function toggleTestimony() {
        if (currentMessageId) {
            const item = document.getElementById(currentMessageId);
            const activeTab = document.querySelector('.tab-btn.active').innerText.trim().toLowerCase();
            
            // Cari ikon bintang di dalam item pesan
            const starIcon = item.querySelector('.star-btn'); 

            if (item.classList.contains('is-testimony')) {
                // UNPUBLISH
                item.classList.remove('is-testimony');
                
                // Ubah bintang menjadi kosong
                starIcon.classList.remove('fas', 'starred');
                starIcon.classList.add('far');

                showToast('Dihapus dari testimoni. Kembali ke pesan biasa.', true);

                // Jika sedang di tab "Testimoni", langsung sembunyikan
                if (activeTab === 'testimoni') {
                    item.style.display = 'none';
                }
            } else {
                // PUBLISH
                item.classList.add('is-testimony');
                
                // Ubah bintang menjadi penuh/emas
                starIcon.classList.remove('far');
                starIcon.classList.add('fas', 'starred');

                showToast('Berhasil! Pesan sekarang tampil di Landing Page.');
            }

            closeMessage(); 
        }
    }

    // 6. Hapus Pesan Permanen
    function deleteMessage() {
        if (currentMessageId) {
            const item = document.getElementById(currentMessageId);
            item.style.opacity = '0';
            setTimeout(() => {
                item.remove();
                showToast('Pesan berhasil dihapus dari sistem.', true);
                closeMessage();
            }, 300);
        }
    }

    // 7. Filter Pesan via Tabs
    function filterMessages(filterType, btnElement) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');

        const items = document.querySelectorAll('.inbox-item');
        items.forEach(item => {
            if (filterType === 'semua') {
                item.style.display = 'flex';
            } else if (filterType === 'belum-dibaca') {
                item.style.display = item.classList.contains('unread') ? 'flex' : 'none';
            } else if (filterType === 'testimoni') {
                item.style.display = item.classList.contains('is-testimony') ? 'flex' : 'none';
            }
        });

        closeMessage();
    }
</script>
@endsection