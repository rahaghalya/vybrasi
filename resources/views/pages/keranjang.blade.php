@extends('layouts.app')

@section('title', 'Vybrasi - Keranjang Saya')

@section('content')
<div class="vy-luxury-cart-wrapper">
    <div class="editorial-cart-container fade-in-up">
        
        <a href="{{ route('produk') }}" class="btn-back-hairline">
            <i class="fa-solid fa-arrow-left-long"></i>
            <span>Kembali ke Katalog</span>
        </a>

        <div class="cart-header-editorial">
            <span class="badge-serif">Ruang Transaksi</span>
            <h1 class="editorial-page-title">Keranjang<br><i class="serif-accent">Saya.</i></h1>
            <div class="editorial-hairline"></div>
        </div>

        <form action="{{ route('checkout') }}" method="GET" id="form-keranjang" class="cart-form-wrapper">
            
            <div class="cart-items-list">
                @forelse($cartItems as $item)
                    {{-- Class 'cart-item' tetap dipertahankan untuk JS --}}
                    <div class="cart-item editorial-cart-item" data-id="{{ $item->id_keranjang }}">
                        
                        {{-- CHECKBOX --}}
                        <label class="cart-checkbox-luxury">
                            <input type="checkbox" name="item[]" value="{{ $item->id_keranjang }}" class="item-checkbox">
                            <span class="check-ring"></span>
                        </label>

                        {{-- GAMBAR --}}
                        <div class="cart-img-luxury">
                            <img src="{{ $item->gambar_utama ? $item->gambar_utama : asset('images/kopi-arabica.png') }}" alt="{{ $item->nama }}">
                        </div>

                        {{-- INFO PRODUK --}}
                        <div class="cart-info-luxury">
                            <h3>{{ $item->nama }}</h3>
                            <p>{{ $item->deskripsi_singkat ?? $item->berat_gram . 'gr - Premium Roast' }}</p>
                            
                            {{-- Tombol Hapus Pindah ke Bawah Nama --}}
                            <button type="button" class="btn-hapus-item hairline-delete" data-id="{{ $item->id_keranjang }}" title="Hapus Produk">
                                <i class="fa-solid fa-xmark"></i> Hapus Item
                            </button>
                        </div>

                        {{-- HARGA & KUANTITAS --}}
                        <div class="cart-action-luxury">
                            <div class="cart-price" data-price="{{ $item->harga }}">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                            
                            <div class="qty-pill-wrapper">
                                <button type="button" class="qty-btn minus" data-id="{{ $item->id_keranjang }}"><i class="fa-solid fa-minus"></i></button>
                                <span class="qty-num" id="qty-{{ $item->id_keranjang }}">{{ $item->jumlah }}</span>
                                <button type="button" class="qty-btn plus" data-id="{{ $item->id_keranjang }}"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="empty-state-editorial">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <h3>Keranjang Kosong</h3>
                        <p>Belum ada mahakarya yang Anda pilih. Mari mulai kurasi pesanan Anda.</p>
                        <a href="{{ route('produk') }}" class="btn-action-hairline">
                            Jelajahi Koleksi <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- STICKY BOTTOM BAR --}}
            @if(count($cartItems) > 0)
                <div class="cart-bottom-glass">
                    <div class="cart-bottom-left">
                        <label class="cart-checkbox-luxury">
                            <input type="checkbox" id="check-all">
                            <span class="check-ring"></span>
                        </label>
                        <span class="select-all-text">Pilih Semua</span>
                    </div>

                    <div class="cart-bottom-right">
                        <div class="summary-text-editorial">
                            <span class="summary-label">Total (<span id="total-selected">0</span> item)</span>
                            <span class="summary-total-price" id="total-price">Rp 0</span>
                        </div>
                        <button type="submit" id="btn-checkout-submit" class="btn-checkout-pill disabled" disabled>
                            <span>Checkout</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            @endif

        </form>
    </div>
</div>

{{-- MODAL HAPUS ITEM (EDITORIAL POP-UP) --}}
<div id="delete-modal" class="custom-modal">
    <div class="modal-ulasan-card"> {{-- Menggunakan class layout modal yang sudah ada --}}
        <div class="modal-icon-luxury">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="modal-header">
            <h2>Hapus Item?</h2>
            <p>Tindakan ini akan mengeluarkan mahakarya ini dari daftar kurasi Anda.</p>
        </div>
        <div class="modal-actions-editorial">
            <button type="button" id="btn-cancel-delete" class="btn-cancel-hairline">Batal</button>
            <button type="button" id="btn-confirm-delete" class="btn-confirm-solid">Ya, Keluarkan</button>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- SCRIPT JAVASCRIPT TETAP SAMA --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const minusBtns = document.querySelectorAll('.qty-btn.minus');
        const plusBtns = document.querySelectorAll('.qty-btn.plus');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const checkAllBtn = document.getElementById('check-all');
        const totalSelectedEl = document.getElementById('total-selected');
        const totalPriceEl = document.getElementById('total-price');
        const btnCheckout = document.getElementById('btn-checkout-submit');
        const deleteBtns = document.querySelectorAll('.btn-hapus-item');

        const modal = document.getElementById('delete-modal');
        const btnCancelDelete = document.getElementById('btn-cancel-delete');
        const btnConfirmDelete = document.getElementById('btn-confirm-delete');
        
        let targetIdKeranjang = null;
        let targetItemDiv = null;

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { 
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0 
            }).format(angka).replace('Rp', 'Rp ');
        }

        function calculateTotal() {
            let totalItems = 0;
            let totalPrice = 0;
            let checkedCount = 0;
            
            const currentCheckboxes = document.querySelectorAll('.item-checkbox');

            currentCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkedCount++;
                    const cartItem = checkbox.closest('.cart-item');
                    const price = parseInt(cartItem.querySelector('.cart-price').getAttribute('data-price'));
                    const qty = parseInt(cartItem.querySelector('.qty-num').textContent);
                    
                    totalItems += qty;
                    totalPrice += (price * qty);
                }
            });

            totalSelectedEl.textContent = totalItems;
            totalPriceEl.textContent = formatRupiah(totalPrice);

            if (checkAllBtn) {
                checkAllBtn.checked = (checkedCount === currentCheckboxes.length && currentCheckboxes.length > 0);
            }

            if (checkedCount > 0) {
                btnCheckout.classList.remove('disabled');
                btnCheckout.disabled = false;
            } else {
                btnCheckout.classList.add('disabled');
                btnCheckout.disabled = true;
            }
        }

        itemCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', calculateTotal);
        });

        if (checkAllBtn) {
            checkAllBtn.addEventListener('change', function() {
                const isChecked = this.checked;
                document.querySelectorAll('.item-checkbox').forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
                calculateTotal();
            });
        }

        function updateCartQtyDB(idKeranjang, newQty) {
            fetch("{{ route('keranjang.update_qty') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id_keranjang: idKeranjang, jumlah: newQty })
            }).catch(error => console.error("Error:", error));
        }

        minusBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const qtySpan = this.parentElement.querySelector('.qty-num');
                const idKeranjang = this.getAttribute('data-id');
                let currentQty = parseInt(qtySpan.textContent);

                if (currentQty > 1) {
                    currentQty--;
                    qtySpan.textContent = currentQty;
                    updateCartQtyDB(idKeranjang, currentQty);
                    calculateTotal();
                }
            });
        });

        plusBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const qtySpan = this.parentElement.querySelector('.qty-num');
                const idKeranjang = this.getAttribute('data-id');
                let currentQty = parseInt(qtySpan.textContent);

                currentQty++;
                qtySpan.textContent = currentQty;
                updateCartQtyDB(idKeranjang, currentQty);
                calculateTotal();
            });
        });

        // 1. Munculkan pop-up
        deleteBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                targetIdKeranjang = this.getAttribute('data-id');
                targetItemDiv = this.closest('.cart-item');
                modal.classList.add('show'); 
            });
        });

        // 2. Tutup pop-up
        btnCancelDelete.addEventListener('click', function() {
            modal.classList.remove('show');
            targetIdKeranjang = null;
            targetItemDiv = null;
        });

        // 3. Eksekusi Hapus
        btnConfirmDelete.addEventListener('click', function() {
            if(!targetIdKeranjang) return;

            let originalText = this.innerHTML;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            this.disabled = true;

            fetch("{{ route('keranjang.hapus') }}", {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id_keranjang: targetIdKeranjang })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    targetItemDiv.style.opacity = '0';
                    setTimeout(() => {
                        targetItemDiv.remove();
                        calculateTotal();
                        modal.classList.remove('show');
                        
                        if(document.querySelectorAll('.cart-item').length === 0) {
                            location.reload(); 
                        }
                    }, 300);
                } else {
                    alert("Gagal menghapus barang.");
                }
            }).catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan jaringan.");
            }).finally(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });
</script>
@endsection