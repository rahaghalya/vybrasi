@extends('layouts.admin')
@section('content')

{{-- CDN Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body, .admin-container, .main-content, .content-body, section.content-body, main.main-content, .content-wrapper, .page-wrapper, .main-wrapper, .inner-content, .dashboard-content, [class*="content"], [class*="wrapper"], [class*="main"] { background: #0a0a0a !important; background-color: #0a0a0a !important; }
aside, .sidebar, [class*="sidebar"] { background: unset !important; background-color: unset !important; }

/* Custom Styling Chart agar menyatu dengan Tema Dark */
.chart-container { position: relative; height: 280px; width: 100%; }
</style>

<div class="wrap">

    <div class="banner">
        <div>
            <h2>Selamat Datang, <span class="gold">{{ auth()->user()->full_name ?? 'Admin' }}</span> 👋</h2>
            <p>Ringkasan performa toko Vybrasi hari ini.</p>
        </div>
        <div class="date-pill"><i class="fa-regular fa-calendar-days"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
    </div>

    <div class="kpi-row">
        <div class="kpi gold-bar">
            <div class="kpi-ic"><i class="fa-solid fa-wallet"></i></div>
            <div><p class="kpi-lbl">Pendapatan Hari Ini</p><h3>Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3><p class="sub">Dari <b>{{ $todayOrders }}</b> pesanan</p></div>
        </div>
        <div class="kpi amber-bar">
            <div class="kpi-ic amber"><i class="fa-solid fa-chart-line"></i></div>
            <div><p class="kpi-lbl">Pendapatan Minggu Ini</p><h3>Rp {{ number_format($weekRevenue, 0, ',', '.') }}</h3><p class="sub">Dari <b>{{ $weekOrders }}</b> pesanan</p></div>
        </div>
        <div class="kpi blue-bar">
            <div class="kpi-ic blue"><i class="fa-solid fa-truck-fast"></i></div>
            <div><p class="kpi-lbl">Sedang Dikirim</p><h3>{{ $shippedCount }} <span class="unit">Paket</span></h3><a href="{{ route('admin.pengiriman') }}" class="kpi-link">Lacak <i class="fa-solid fa-arrow-right"></i></a></div>
        </div>
        <div class="kpi green-bar">
            <div class="kpi-ic green"><i class="fa-solid fa-house-chimney-check"></i></div>
            <div><p class="kpi-lbl">Pesanan Selesai</p><h3>{{ $deliveredCount }} <span class="unit">Paket</span></h3><a href="{{ route('admin.laporan') }}" class="kpi-link">Laporan <i class="fa-solid fa-arrow-right"></i></a></div>
        </div>
    </div>

    {{-- AREA GRAFIK UTAMA DENGAN FILTER --}}
    <div class="main-grid" style="margin-bottom: 18px;">
        <div class="card span8">
            <div class="card-head" style="display: flex; justify-content: space-between; align-items: center;">
                <span id="chart-title"><i class="fa-solid fa-chart-area gold"></i> Tren Pendapatan (7 Hari)</span>
                
                {{-- Dropdown Filter Waktu --}}
                <select id="chart-filter" class="filter-dropdown" onchange="updateChartData(this.value)">
                    <option value="7days">7 Hari Terakhir</option>
                    <option value="1month">1 Bulan Terakhir</option>
                    <option value="6months">6 Bulan Terakhir</option>
                    <option value="1year">1 Tahun Terakhir</option>
                </select>
            </div>
            <div class="pad">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="card span4">
            <div class="card-head"><span><i class="fa-solid fa-pie-chart gold"></i> Status Pesanan</span></div>
            <div class="pad">
                <div class="chart-container">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="main-grid">
        <div class="card span8">
            <div class="card-head">
                <span><i class="fa-solid fa-cart-shopping gold"></i> Pesanan Terbaru</span>
                <a href="{{ route('admin.pesanan_baru') }}" class="btn-ol">Semua Pesanan</a>
            </div>
            <table class="dtable">
                <thead><tr><th>Invoice</th><th>Pelanggan</th><th>Produk</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($recentOrders as $o)
                    <tr>
                        <td><span class="mono">{{ $o->no_invoice }}</span></td>
                        <td class="fw">{{ $o->nama_pelanggan }}</td>
                        <td class="mu">{{ Str::limit($o->produk_utama, 30) }}</td>
                        <td>
                            @if($o->status=='pending') <span class="bdg warn">Menunggu</span>
                            @elseif($o->status=='shipped') <span class="bdg info">Dikirim</span>
                            @else <span class="bdg succ">Selesai</span> @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">Belum ada pesanan terbaru.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card span4">
            <div class="card-head"><span><i class="fa-solid fa-star gold"></i> Sorotan Produk</span></div>
            <div class="pad">
                <p class="lbl">PRODUK TERLARIS</p>
                @if($bestSellingProduct)
                <div class="prod-row">
                    <img src="{{ $bestSellingProduct->gambar_utama ?? 'https://placehold.co/60x60/111/FFF?text=K' }}" alt="">
                    <div style="flex:1">
                        <h4 class="fw" style="margin:0 0 4px">{{ $bestSellingProduct->nama }}</h4>
                        <span class="fire"><i class="fa-solid fa-fire"></i> {{ $bestSellingProduct->total_terjual }} Terjual</span>
                    </div>
                    <a href="{{ route('admin.produk.edit', ['id'=>$bestSellingProduct->id_produk]) }}" class="ic-btn"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                </div>
                @else <p class="mu">Belum ada data penjualan.</p> @endif
                <hr class="div">
                <p class="lbl">PERINGATAN STOK</p>
                <div class="stk-alert {{ $lowStockCount > 0 ? 'danger' : 'safe' }}">
                    <i class="fa-solid {{ $lowStockCount > 0 ? 'fa-triangle-exclamation' : 'fa-shield-check' }}"></i>
                    <div style="flex:1">
                        <h4 class="fw" style="margin:0 0 2px">{{ $lowStockCount }} Item Menipis</h4>
                        <p class="mu" style="margin:0">Stok ≤ 10, butuh restock.</p>
                    </div>
                    <a href="{{ route('admin.produk', ['stok' => 'menipis']) }}" class="sm-btn {{ $lowStockCount > 0 ? 'red' : '' }}">Cek</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // 1. Inisialisasi Grafik Pendapatan Global
    let revenueChartInstance = null;
    const ctxRev = document.getElementById('revenueChart').getContext('2d');
    
    revenueChartInstance = new Chart(ctxRev, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($chartRevenue),
                borderColor: '#D4A373',
                backgroundColor: 'rgba(212, 163, 115, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#D4A373'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: '#1a1a1a' }, ticks: { color: '#666', font: { size: 10 } } },
                x: { grid: { display: false }, ticks: { color: '#666', font: { size: 10 } } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // 2. LOGIKA AJAX UNTUK UPDATE GRAFIK TANPA RELOAD
    function updateChartData(range) {
        const titleMap = {
            '7days': 'Tren Pendapatan (7 Hari)',
            '1month': 'Tren Pendapatan (1 Bulan Terakhir)',
            '6months': 'Tren Pendapatan (6 Bulan Terakhir)',
            '1year': 'Tren Pendapatan (1 Tahun Terakhir)'
        };

        // Ganti judul 
        document.getElementById('chart-title').innerHTML = '<i class="fa-solid fa-chart-area gold"></i> ' + titleMap[range];

        // Fetch data baru dari backend
        fetch(`/admin/api/chart-pendapatan?range=${range}`)
            .then(response => response.json())
            .then(data => {
                // Timpa data di instance chart.js dan trigger animasi
                revenueChartInstance.data.labels = data.labels;
                revenueChartInstance.data.datasets[0].data = data.revenue;
                revenueChartInstance.update();
            })
            .catch(error => console.error('Error fetching chart data:', error));
    }

    // 3. LOGIKA GRAFIK STATUS (DOUGHNUT CHART)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Dikirim', 'Selesai'],
            datasets: [{
                data: [{{ $statusCounts['pending'] }}, {{ $statusCounts['shipped'] }}, {{ $statusCounts['delivered'] }}],
                backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { color: '#999', usePointStyle: true, padding: 20, font: { size: 11 } } }
            }
        }
    });
</script>

<style>
/* CSS CORE (Tetap sama, tambahan dropdown filter di bawah) */
*,*::before,*::after{box-sizing:border-box}
.wrap{padding:20px 28px;color:#fff;animation:fi .4s ease}
@keyframes fi{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.banner{background:linear-gradient(120deg,rgba(212,163,115,.13),rgba(10,10,10,1));border:1px solid rgba(212,163,115,.25);border-left:4px solid #D4A373;border-radius:12px;padding:22px 26px;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.banner h2{margin:0 0 4px;font-size:20px;font-weight:800;color:#fff}.banner p{margin:0;color:#999;font-size:13px}
.gold{color:#D4A373}
.date-pill{background:#111;border:1px solid rgba(212,163,115,.2);color:#D4A373;padding:9px 15px;border-radius:8px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px}
.kpi-row{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:18px}
.kpi{background:#111;border:1px solid #1e1e1e;border-radius:12px;padding:18px;display:flex;align-items:flex-start;gap:14px;position:relative;overflow:hidden;transition:.3s}
.kpi:hover{transform:translateY(-4px)}.kpi::before{content:'';position:absolute;left:0;top:0;width:4px;height:100%}
.gold-bar::before{background:#D4A373}.amber-bar::before{background:#f59e0b}.blue-bar::before{background:#3b82f6}.green-bar::before{background:#10b981}
.kpi-ic{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;background:rgba(212,163,115,.1);color:#D4A373;flex-shrink:0}
.kpi-ic.amber{background:rgba(245,158,11,.1);color:#f59e0b}.kpi-ic.blue{background:rgba(59,130,246,.1);color:#3b82f6}.kpi-ic.green{background:rgba(16,185,129,.1);color:#10b981}
.kpi-lbl{margin:0 0 4px;font-size:11px;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:.5px}
.kpi h3{margin:0 0 3px;font-size:19px;font-weight:800;color:#fff}
.sub{margin:0;font-size:12px;color:#666}.unit{font-size:13px;color:#888;font-weight:400}.kpi-link{display:inline-block;margin-top:6px;font-size:12px;color:#D4A373;font-weight:600;text-decoration:none}
.main-grid{display:grid;grid-template-columns:repeat(12,1fr);gap:18px}.span8{grid-column:span 8}.span4{grid-column:span 4}
@media(max-width:1024px){.span8,.span4{grid-column:span 12}}
.card{background:#111;border:1px solid #1e1e1e;border-radius:12px;overflow:hidden}.card-head{padding:14px 18px;border-bottom:1px solid #1a1a1a;display:flex;justify-content:space-between;align-items:center;font-size:14px;font-weight:700;color:#fff}.pad{padding:18px}
.dtable{width:100%;border-collapse:collapse}.dtable th{background:#0d0d0d;color:#D4A373;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:13px 18px;text-align:left;border-bottom:1px solid #1a1a1a}.dtable td{padding:13px 18px;border-bottom:1px solid #161616;font-size:14px;color:#ccc;vertical-align:middle}.dtable tbody tr:hover{background:#141414}.mono{background:#1a1a1a;border:1px solid #2a2a2a;padding:3px 8px;border-radius:6px;font-family:monospace;color:#D4A373;font-size:13px}.fw{color:#fff !important;font-weight:600}.mu{color:#777 !important;font-size:13px}.empty{text-align:center;color:#555;padding:25px;font-style:italic}
.bdg{padding:5px 11px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block}.warn{background:rgba(245,158,11,.12);color:#f59e0b;border:1px solid rgba(245,158,11,.2)}.info{background:rgba(59,130,246,.12);color:#3b82f6;border:1px solid rgba(59,130,246,.2)}.succ{background:rgba(16,185,129,.12);color:#10b981;border:1px solid rgba(16,185,129,.2)}
.btn-ol{background:rgba(212,163,115,.1);border:1px solid rgba(212,163,115,.3);color:#D4A373;padding:6px 13px;border-radius:7px;font-size:12px;font-weight:600;text-decoration:none;transition:.2s}.btn-ol:hover{background:#D4A373;color:#fff}
.lbl{font-size:11px;font-weight:700;color:#666;letter-spacing:1px;margin:0 0 12px;text-transform:uppercase}.prod-row{display:flex;align-items:center;gap:12px;background:#0d0d0d;padding:11px;border-radius:10px;border:1px solid #1a1a1a}.prod-row img{width:44px;height:44px;border-radius:8px;object-fit:cover}.fire{font-size:12px;color:#f59e0b;background:rgba(245,158,11,.1);padding:3px 8px;border-radius:6px;font-weight:600}.ic-btn{color:#888;padding:7px;border-radius:8px;background:#1a1a1a;border:1px solid #2a2a2a;text-decoration:none;transition:.2s}.ic-btn:hover{background:#D4A373;color:#fff}.div{border:none;border-top:1px dashed #1e1e1e;margin:15px 0}.stk-alert{display:flex;align-items:center;gap:12px;padding:13px;border-radius:10px;border:1px solid;font-size:20px}.stk-alert.danger{background:rgba(239,68,68,.06);border-color:rgba(239,68,68,.2);color:#ef4444}.stk-alert.safe{background:rgba(16,185,129,.06);border-color:rgba(16,185,129,.2);color:#10b981}.sm-btn{background:#1e1e1e;color:#ccc;padding:6px 13px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;border:1px solid #2a2a2a}.sm-btn.red{background:#ef4444;color:#fff;border-color:#ef4444}

/* Tambahan Style untuk Dropdown Filter */
.filter-dropdown {
    background: #0a0a0a;
    border: 1px solid #333;
    color: #ccc;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    outline: none;
    cursor: pointer;
    font-family: inherit;
    transition: 0.2s;
}
.filter-dropdown:hover { border-color: #D4A373; }
.filter-dropdown option { background: #111; color: #fff; }
</style>
@endsection