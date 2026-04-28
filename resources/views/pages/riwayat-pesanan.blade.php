@extends('layouts.app')

@section('title', 'Vybrasi - Riwayat Pesanan')

@section('content')
<div class="riwayat-container">
    <h1 class="page-title">Riwayat Pesanan</h1>

    <div class="riwayat-card-main">
        <div class="order-item">
            <div class="order-img-wrapper">
                <img src="{{ asset('images/kopi-1.jpg') }}" alt="Kopi Gula Aren Signature">
            </div>
            <div class="order-content">
                <div class="order-header">
                    <div class="order-info">
                        <h3 class="product-name">Kopi Gula Aren Signature</h3>
                        <p>Pesanan #VYB-2024001</p>
                    </div>
                    <span class="order-qty">1x</span>
                </div>
                <div class="order-price-details">
                    <p class="order-price">Rp 25.000</p>
                    <p class="order-total">Total: Rp 25.000</p>
                </div>
                <div class="order-actions">
                    <button class="btn-ulasan" onclick="bukaModalUlasan('Kopi Gula Aren Signature')">
                        Kirim Ulasan
                    </button>
                    <a href="{{ route('produk.detail') }}" class="btn-beli" style="text-decoration: none; text-align: center;">
                        Beli Lagi
                    </a>
                </div>
            </div>
        </div>

        <div class="order-item">
            <div class="order-img-wrapper">
                <img src="{{ asset('images/kopi-2.jpg') }}" alt="Arabica Premium Roast">
            </div>
            <div class="order-content">
                <div class="order-header">
                    <div class="order-info">
                        <h3 class="product-name">Arabica Premium Roast</h3>
                        <p>Pesanan #VYB-2024002</p>
                    </div>
                    <span class="order-qty">2x</span>
                </div>
                <div class="order-price-details">
                    <p class="order-price">Rp 45.000</p>
                    <p class="order-total">Total: Rp 90.000</p>
                </div>
                <div class="order-actions">
                    <button class="btn-ulasan" onclick="bukaModalUlasan('Arabica Premium Roast')">
                        Kirim Ulasan
                    </button>
                    <a href="{{ route('produk.detail') }}" class="btn-beli" style="text-decoration: none; text-align: center;">
                        Beli Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalUlasan">
    <div class="modal-ulasan-card">
        <button class="btn-close-modal" onclick="tutupModalUlasan()">&times;</button>

        <div class="modal-header">
            <h2>Ulas Kami</h2>
            <div class="divider"></div>
        </div>

        <form action="#" method="POST" class="form-ulasan-grid" onsubmit="window.location.reload(); return false;">
            @csrf 
            <div class="form-left">
                <div class="input-group">
                    <label>Nama</label>
                    <input type="text" name="nama" placeholder="masukan nama anda" required>
                </div>

                <div class="input-group">
                    <label>Produk</label>
                    <div class="select-wrapper">
                        <select name="produk" id="produk_ulasan" required>
                            <option value="" disabled selected>silahkan pilih produk yang anda beli</option>
                            <option value="Kopi Gula Aren Signature">Kopi Gula Aren Signature</option>
                            <option value="Arabica Premium Roast">Arabica Premium Roast</option>
                            <option value="Signature Series">Signature Series</option>
                        </select>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <div class="input-group">
                    <label>Tanggal Pembelian</label>
                    <input type="text" name="tanggal" placeholder="dd/mm/yyyy" required onfocus="(this.type='date')" onblur="if(this.value === '') this.type='text'">
                </div>
            </div>

            <div class="form-right">
                <div class="input-group h-100">
                    <label>Ulasan</label>
                    <div class="ulasan-box">
                        <textarea name="ulasan_teks" placeholder="masukan ulasan anda" required></textarea>
                        
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn-kirim-submit">Kirim</button>
            </div>
        </form>
    </div>
</div>



<script>
    function bukaModalUlasan(namaProduk) {
        const modal = document.getElementById('modalUlasan');
        const selectProduk = document.getElementById('produk_ulasan');
        
        if(selectProduk) {
            selectProduk.value = namaProduk;
        }
        
        modal.style.display = 'flex';
    }

    function tutupModalUlasan() {
        document.getElementById('modalUlasan').style.display = 'none';
        window.location.reload(); 
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalUlasan');
        if (event.target == modal) {
            tutupModalUlasan();
        }
    }
</script>
@endsection