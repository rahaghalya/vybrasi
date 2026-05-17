@extends('layouts.app')

@section('title', 'Vybrasi - Keranjang Saya')

@section('content')
<div class="keranjang-container">
    <h1 class="page-title">Keranjang Saya</h1>

    <div class="keranjang-card-main">
        
        <form action="{{ route('checkout') }}" method="GET" id="form-keranjang">
            
            @forelse($cartItems as $item)
                <div class="cart-item" data-id="{{ $item->id_keranjang }}">
                    <label class="cart-checkbox">
                        <input type="checkbox" name="item[]" value="{{ $item->id_keranjang }}" class="item-checkbox">
                        <span class="checkmark-circle"></span>
                    </label>

                    <div class="cart-img-wrapper">
                        <img src="{{ $item->gambar_utama ? $item->gambar_utama : asset('images/kopi-arabica.png') }}" alt="{{ $item->nama }}">
                    </div>

                    <div class="cart-info" style="flex-grow: 1;">
                        <h3>{{ $item->nama }}</h3>
                        <p>{{ $item->deskripsi_singkat ?? $item->berat_gram . 'gr - Premium Roast' }}</p>
                        <div class="cart-price" data-price="{{ $item->harga }}">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                    </div>

                    <div class="cart-actions-right" style="display: flex; flex-direction: column; align-items: flex-end; gap: 15px;">
                        <button type="button" class="btn-hapus-item" data-id="{{ $item->id_keranjang }}" title="Hapus Produk">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                        
                        <div class="cart-qty-wrapper">
                            <button type="button" class="qty-btn minus" data-id="{{ $item->id_keranjang }}"><i class="fa-solid fa-minus"></i></button>
                            <span class="qty-num" id="qty-{{ $item->id_keranjang }}">{{ $item->jumlah }}</span>
                            <button type="button" class="qty-btn plus" data-id="{{ $item->id_keranjang }}"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px; color: #888;">
                    <i class="fa-solid fa-cart-shopping" style="font-size: 48px; color: #ccc; margin-bottom: 15px;"></i>
                    <p>Keranjang Anda masih kosong.</p>
                    <a href="{{ route('produk') }}" class="btn-brown" style="display: inline-block; margin-top: 15px; padding: 10px 20px; text-decoration: none; border-radius: 5px; background: #D4A373; color: white;">Belanja Sekarang</a>
                </div>
            @endforelse

            @if(count($cartItems) > 0)
                <div class="cart-bottom-bar">
                    <div class="cart-bottom-left">
                        <label class="cart-checkbox">
                            <input type="checkbox" id="check-all">
                            <span class="checkmark-circle"></span>
                        </label>
                        <span style="margin-left: 10px; font-weight: bold; color: #333;">Pilih Semua</span>
                    </div>

                    <div class="cart-bottom-right">
                        <div class="summary-text">
                            <span>Total (<span id="total-selected">0</span> produk):</span>
                            <span class="summary-total-price" id="total-price">Rp 0</span>
                        </div>
                        <button type="submit" id="btn-checkout-submit" class="btn-checkout disabled" disabled>
                            CheckOut
                        </button>
                    </div>
                </div>
            @endif

        </form>
    </div>
</div>

{{-- POP-UP CUSTOM UNTUK KONFIRMASI HAPUS --}}
<div id="delete-modal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-icon">
            <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <h3>Hapus Produk?</h3>
        <p>Apakah Anda yakin ingin menghapus produk ini dari keranjang belanja Anda?</p>
        <div class="modal-actions">
            <button type="button" id="btn-cancel-delete" class="btn-cancel-modal">Batal</button>
            <button type="button" id="btn-confirm-delete" class="btn-confirm-modal">Ya, Hapus</button>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ... CSS Lama ... */
    .cart-bottom-bar {
        display: flex; justify-content: space-between; align-items: center;
        background: #fff; padding: 15px 20px; margin-top: 20px;
        border-radius: 12px; box-shadow: 0 -4px 12px rgba(0,0,0,0.05);
        border: 1px solid #eee; position: sticky; bottom: 20px; z-index: 10;
    }
    .cart-bottom-left { display: flex; align-items: center; cursor: pointer; }
    .cart-bottom-right { display: flex; align-items: center; gap: 20px; }
    .summary-text { display: flex; flex-direction: column; text-align: right; }
    .summary-text > span:first-child { font-size: 14px; color: #666; }
    .summary-total-price { font-size: 18px; font-weight: bold; color: #D4A373; }
    
    .btn-checkout {
        background-color: #D4A373; color: white; border: none; padding: 12px 30px;
        border-radius: 8px; font-weight: bold; font-size: 16px; cursor: pointer; transition: all 0.3s;
    }
    .btn-checkout:hover { background-color: #b58555; }
    .btn-checkout.disabled { background-color: #e0e0e0; color: #a0a0a0; cursor: not-allowed; }

    .btn-hapus-item {
        background: none; border: none; color: #ff4d4f; cursor: pointer;
        font-size: 14px; display: flex; align-items: center; gap: 5px; transition: color 0.3s;
    }
    .btn-hapus-item:hover { color: #c9302c; font-weight: bold; }

    /* --- CSS CUSTOM POP-UP --- */
    .custom-modal {
        display: none; /* Sembunyikan default */
        position: fixed; z-index: 9999;
        left: 0; top: 0; width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Background gelap transparan */
        align-items: center; justify-content: center;
        backdrop-filter: blur(2px);
    }
    .custom-modal.show { display: flex; }
    
    .modal-content {
        background-color: #fff; padding: 30px 20px;
        border-radius: 15px; text-align: center;
        max-width: 350px; width: 90%;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        animation: modalScaleUp 0.3s ease-out;
    }
    
    @keyframes modalScaleUp {
        0% { transform: scale(0.8); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    .modal-icon { font-size: 50px; color: #ff4d4f; margin-bottom: 15px; }
    .modal-content h3 { margin: 0 0 10px; color: #333; font-size: 20px; }
    .modal-content p { color: #666; margin-bottom: 25px; font-size: 14px; line-height: 1.5; }
    
    .modal-actions { display: flex; justify-content: center; gap: 10px; }
    .modal-actions button {
        padding: 10px 20px; border-radius: 8px; border: none;
        cursor: pointer; font-weight: bold; transition: 0.2s; font-size: 14px; flex: 1;
    }
    .btn-cancel-modal { background-color: #f0f0f0; color: #555; }
    .btn-cancel-modal:hover { background-color: #e4e4e4; }
    .btn-confirm-modal { background-color: #ff4d4f; color: white; }
    .btn-confirm-modal:hover { background-color: #d9363e; }
</style>

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

        // Elemen Custom Pop-up
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

        // --- LOGIKA TOMBOL HAPUS DENGAN POP-UP ---
        
        // 1. Munculkan pop-up saat tombol hapus diklik
        deleteBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                targetIdKeranjang = this.getAttribute('data-id');
                targetItemDiv = this.closest('.cart-item');
                modal.classList.add('show'); // Tampilkan modal
            });
        });

        // 2. Tutup pop-up jika batal
        btnCancelDelete.addEventListener('click', function() {
            modal.classList.remove('show');
            targetIdKeranjang = null;
            targetItemDiv = null;
        });

        // 3. Eksekusi Hapus jika klik "Ya, Hapus"
        btnConfirmDelete.addEventListener('click', function() {
            if(!targetIdKeranjang) return;

            // Beri efek loading pada tombol
            let originalText = this.innerHTML;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
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
                    // Hapus elemen barang dari layar
                    targetItemDiv.remove();
                    // Hitung ulang total pembayaran
                    calculateTotal();
                    // Sembunyikan Pop-up
                    modal.classList.remove('show');
                    
                    // Jika keranjang sudah benar-benar kosong, reload halaman
                    if(document.querySelectorAll('.cart-item').length === 0) {
                        location.reload(); 
                    }
                } else {
                    alert("Gagal menghapus barang.");
                }
            }).catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan jaringan.");
            }).finally(() => {
                // Kembalikan tombol seperti semula jika gagal
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });

    });
</script>
@endsection