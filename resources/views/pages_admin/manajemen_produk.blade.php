@extends('layouts.admin')

@section('content')

<style>
body,
.admin-container,
.main-content,
.content-body,
section.content-body,
main.main-content,
.content-wrapper,
.page-wrapper,
.main-wrapper,
.inner-content,
[class*="content"],
[class*="wrapper"],
[class*="main"] {
    background: #0a0a0a !important;
    background-color: #0a0a0a !important;
}
aside, .sidebar, [class*="sidebar"] {
    background: unset !important;
    background-color: unset !important;
}
</style>

<div class="wrap">

    <h2 class="page-title">DAFTAR PRODUK KOPI</h2>

    @if(session('success'))
        <div class="alert-ok"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.produk') }}" method="GET" class="toolbar" id="filterForm">
        <div class="tb-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Cari Produk..." value="{{ request('search') }}">
                <button type="submit" style="display:none"></button>
            </div>
            <div class="sel-wrap">
                <select name="kategori" class="dark-sel" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Kategori</option>
                    <option value="biji_kopi"  {{ request('kategori')=='biji_kopi'  ? 'selected':'' }}>Biji Kopi</option>
                    <option value="kopi_bubuk" {{ request('kategori')=='kopi_bubuk' ? 'selected':'' }}>Kopi Bubuk</option>
                </select>
                <i class="fas fa-chevron-down sel-ic"></i>
            </div>
            <button type="button" class="btn-stok" id="btnLowStock" onclick="toggleLowStock()">
                <i class="fas fa-exclamation-triangle"></i> Stok Menipis
            </button>
        </div>
        <a href="{{ route('admin.produk.tambah') }}" class="btn-add" style="text-decoration:none">
            <i class="fas fa-plus"></i> TAMBAH PRODUK BARU
        </a>
    </form>

    <div class="prod-grid" id="productGrid">
        @forelse ($produks as $produk)
        <div class="prod-card" data-stock="{{ $produk->stok }}">
            <div class="img-wrap">
                <img src="{{ $produk->gambar_utama ?: 'https://placehold.co/400x300/0d0d0d/FFF?text='.urlencode($produk->nama) }}" alt="{{ $produk->nama }}">
                @if($produk->stok <= 10)
                    <span class="stk-badge danger"><i class="fas fa-exclamation-circle"></i> Sisa {{ $produk->stok }}</span>
                @else
                    <span class="stk-badge safe">Stok: {{ $produk->stok }}</span>
                @endif
            </div>
            <div class="card-body">
                <h4 class="prod-name">{{ $produk->nama }}</h4>
                <p class="prod-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                <div class="card-acts">
                    <a href="{{ route('admin.produk.edit', $produk->id_produk) }}" class="act edit" style="text-decoration:none">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="act del" onclick="openDel('{{ $produk->id_produk }}')">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>Tidak ada produk yang ditemukan.</p>
        </div>
        @endforelse
    </div>

    <div class="pag-footer">
        <div class="total">Total: <strong>{{ $totalProduk }}</strong> Produk</div>
        <div class="pag-wrap">{{ $produks->links('pagination::bootstrap-4') }}</div>
    </div>

</div>

<div class="modal-ov" id="deleteModal">
    <div class="modal-box">
        <div class="modal-ic"><i class="fas fa-exclamation-triangle"></i></div>
        <h3 class="modal-title">Hapus Produk?</h3>
        <p class="modal-txt">Tindakan ini tidak dapat dibatalkan dan data akan hilang permanen.</p>
        <div class="modal-acts">
            <button type="button" class="m-cancel" onclick="closeDel()">Batal</button>
            <form id="formDelete" action="#" method="POST" style="flex:1;margin:0">
                @csrf @method('DELETE')
                <button type="submit" class="m-confirm"><i class="fas fa-trash-alt"></i> Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDel(id){ document.getElementById('formDelete').action=`/admin/produk/hapus/${id}`; document.getElementById('deleteModal').classList.add('show'); }
function closeDel(){ document.getElementById('deleteModal').classList.remove('show'); }
document.getElementById('deleteModal').addEventListener('click',function(e){ if(e.target===this) closeDel(); });

let lsActive=false;
function toggleLowStock(){
    lsActive=!lsActive;
    const btn=document.getElementById('btnLowStock');
    document.querySelectorAll('.prod-card').forEach(c=>{
        c.style.display=lsActive?(parseInt(c.dataset.stock)<=10?'':'none'):'';
    });
    btn.classList.toggle('active',lsActive);
    btn.innerHTML=lsActive?'<i class="fas fa-times"></i> Batalkan Filter':'<i class="fas fa-exclamation-triangle"></i> Stok Menipis';
}
document.addEventListener('DOMContentLoaded',function(){
    if(new URLSearchParams(window.location.search).get('filter')==='low_stock') setTimeout(toggleLowStock,100);
});
</script>

<style>
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

.page-title{font-size:22px;font-weight:800;color:#fff;margin-bottom:22px;padding-left:12px;border-left:4px solid #D4A373;letter-spacing:1px}

.alert-ok{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);color:#4ade80;padding:13px 17px;border-radius:10px;margin-bottom:20px;font-weight:600;display:flex;align-items:center;gap:10px}

.toolbar{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;margin-bottom:22px}
.tb-left{display:flex;gap:12px;flex-wrap:wrap;align-items:center}

.search-box{display:flex;align-items:center;background:#111;border:1px solid #222;border-radius:8px;padding:10px 14px;min-width:230px;transition:.3s}
.search-box:focus-within{border-color:#D4A373;box-shadow:0 0 0 3px rgba(212,163,115,.2)}
.search-box i{color:#666;margin-right:10px}
.search-box input{background:transparent;border:none;color:#fff;outline:none;width:100%;font-size:14px}
.search-box input::placeholder{color:#555}

.sel-wrap{position:relative}
.dark-sel{appearance:none;background:#111;border:1px solid #222;color:#fff;padding:10px 34px 10px 14px;border-radius:8px;font-size:14px;cursor:pointer;outline:none;transition:.3s}
.dark-sel:focus{border-color:#D4A373}
.sel-ic{position:absolute;right:11px;top:50%;transform:translateY(-50%);color:#666;pointer-events:none;font-size:11px}

.btn-stok{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);color:#fca5a5;padding:10px 14px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;display:inline-flex;gap:7px;align-items:center;transition:.3s}
.btn-stok:hover{background:rgba(239,68,68,.2)}.btn-stok.active{background:#ef4444;color:#fff;border-color:#ef4444}

.btn-add{background:#D4A373;color:#fff;padding:11px 20px;border-radius:8px;font-weight:700;font-size:13px;letter-spacing:.4px;display:inline-flex;align-items:center;gap:8px;transition:.3s;box-shadow:0 4px 14px rgba(212,163,115,.2)}
.btn-add:hover{background:#b58555;transform:translateY(-2px)}

.prod-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:18px;margin-bottom:22px}
.prod-card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden;display:flex;flex-direction:column;transition:.3s;box-shadow:0 8px 24px rgba(0,0,0,.3)}
.prod-card:hover{transform:translateY(-5px);border-color:#2a2a2a}

.img-wrap{position:relative;height:175px;background:#0d0d0d}
.img-wrap img{width:100%;height:100%;object-fit:cover}
.stk-badge{position:absolute;top:11px;right:11px;padding:5px 10px;border-radius:20px;font-size:11px;font-weight:700;backdrop-filter:blur(4px)}
.stk-badge.safe{background:rgba(0,0,0,.65);color:#fff;border:1px solid rgba(255,255,255,.1)}
.stk-badge.danger{background:rgba(239,68,68,.9);color:#fff;box-shadow:0 0 10px rgba(239,68,68,.4)}

.card-body{padding:16px;flex:1;display:flex;flex-direction:column}
.prod-name{margin:0 0 5px;font-size:15px;color:#fff;font-weight:700}
.prod-price{margin:0 0 16px;font-size:17px;color:#D4A373;font-weight:800}
.card-acts{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:auto}
.act{padding:8px;border-radius:8px;font-size:13px;font-weight:600;text-align:center;cursor:pointer;transition:.2s;display:inline-flex;justify-content:center;align-items:center;gap:6px;border:1px solid}
.act.edit{background:rgba(212,163,115,.08);border-color:rgba(212,163,115,.25);color:#D4A373}
.act.edit:hover{background:#D4A373;color:#fff;border-color:#D4A373}
.act.del{background:rgba(239,68,68,.06);border-color:rgba(239,68,68,.2);color:#ef4444}
.act.del:hover{background:#ef4444;color:#fff;border-color:#ef4444}

.empty-state{grid-column:1/-1;text-align:center;padding:50px 20px;background:#111;border:1px dashed #222;border-radius:12px;color:#555}
.empty-state i{font-size:38px;margin-bottom:12px;display:block;color:#222}

.pag-footer{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;background:#111;border:1px solid #1e1e1e;border-radius:12px;flex-wrap:wrap;gap:12px}
.total{color:#999;font-size:14px}.total strong{color:#fff}
.pag-wrap nav ul.pagination{display:flex;gap:5px;margin:0;padding:0;list-style:none}
.pag-wrap nav ul.pagination li.page-item .page-link{background:#1a1a1a;border:1px solid #2a2a2a;color:#ccc;border-radius:6px;padding:6px 12px;transition:.2s}
.pag-wrap nav ul.pagination li.page-item.active .page-link{background:#D4A373;color:#fff;border-color:#D4A373}
.pag-wrap nav ul.pagination li.page-item.disabled .page-link{opacity:.4;cursor:not-allowed}

.modal-ov{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.88);backdrop-filter:blur(4px);z-index:9999;display:flex;justify-content:center;align-items:center;opacity:0;visibility:hidden;transition:.3s}
.modal-ov.show{opacity:1;visibility:visible}
.modal-box{background:#111;border:1px solid #222;padding:28px;border-radius:12px;width:90%;max-width:390px;text-align:center;transform:translateY(20px);transition:.3s;box-shadow:0 20px 50px rgba(0,0,0,.6)}
.modal-ov.show .modal-box{transform:translateY(0)}
.modal-ic{width:58px;height:58px;border-radius:50%;background:rgba(239,68,68,.1);color:#ef4444;font-size:26px;display:flex;justify-content:center;align-items:center;margin:0 auto 14px}
.modal-title{margin:0 0 10px;color:#fff;font-size:19px;font-weight:700}
.modal-txt{color:#888;font-size:14px;margin-bottom:22px;line-height:1.6}
.modal-acts{display:flex;gap:10px;justify-content:center}
.m-cancel{flex:1;padding:10px;background:#1a1a1a;border:1px solid #2a2a2a;color:#aaa;border-radius:8px;cursor:pointer;font-weight:600;transition:.2s}
.m-cancel:hover{background:#222;color:#fff}
.m-confirm{width:100%;padding:10px;background:#ef4444;border:none;color:#fff;border-radius:8px;cursor:pointer;font-weight:600;display:inline-flex;align-items:center;justify-content:center;gap:8px;transition:.2s}
.m-confirm:hover{background:#dc2626}
</style>
@endsection