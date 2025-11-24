@extends('layouts.app') 

@section('content')
<div class="dashboard-container">
    {{-- Animated Background --}}
    <div class="dashboard-bg"></div>
    
    <div class="container-fluid px-4 py-4 position-relative">
        {{-- Enhanced Header --}}
        <div class="dashboard-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="dashboard-title mb-2">
                        <span class="gradient-text">Dashboard</span>
                    </h1>
                    <p class="dashboard-subtitle mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        Executive Summary & Business Intelligence
                    </p>
                </div>
                <div class="status-badge">
                    <div class="pulse-dot"></div>
                    <span class="ms-2"><i class="fas fa-database me-1"></i> Data Warehouse</span>
                </div>
            </div>
        </div>

        {{-- Enhanced KPI Cards --}}
        <div class="row g-4 mb-4">
            {{-- KPI 1: Total Pendapatan --}}
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-primary">
                    <div class="kpi-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="kpi-content">
                        <p class="kpi-label">Total Pendapatan</p>
                        <h3 class="kpi-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="kpi-chart-mini">
                        <canvas id="miniChart1"></canvas>
                    </div>
                </div>
            </div>

            {{-- KPI 2: Order Selesai --}}
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-success">
                    <div class="kpi-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="kpi-content">
                        <p class="kpi-label">Order Selesai</p>
                        <h3 class="kpi-value">{{ number_format($completedOrders) }}</h3>
                    </div>
                    <div class="kpi-chart-mini">
                        <canvas id="miniChart2"></canvas>
                    </div>
                </div>
            </div>

            {{-- KPI 3: Customer Aktif --}}
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-info">
                    <div class="kpi-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="kpi-content">
                        <p class="kpi-label">Customer Aktif</p>
                        <h3 class="kpi-value">{{ number_format($activeCustomers) }}</h3>
                    </div>
                    <div class="kpi-chart-mini">
                        <canvas id="miniChart3"></canvas>
                    </div>
                </div>
            </div>

            {{-- KPI 4: Rating --}}
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-warning">
                    <div class="kpi-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="kpi-content">
                        <p class="kpi-label">Kepuasan Pelanggan</p>
                        <h3 class="kpi-value">{{ number_format($avgRating, 1) }}</h3>
                    </div>
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $avgRating ? 'active' : '' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Enhanced Charts Row 1 --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h6 class="chart-title">
                                <i class="fas fa-chart-line me-2"></i>
                                Tren Pendapatan Bulanan
                            </h6>
                            <p class="chart-subtitle">Analisis performa revenue 12 bulan terakhir</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        @if($revenueTrend->isNotEmpty())
                            <div style="height: 350px;">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-chart-line"></i>
                                <p>Belum ada data transaksi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h6 class="chart-title">
                                <i class="fas fa-chart-pie me-2"></i>
                                Status Order
                            </h6>
                            <p class="chart-subtitle">Distribusi status pesanan</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        @if($orderStatusStats->isNotEmpty())
                            <div style="height: 350px;">
                                <canvas id="orderStatusChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-chart-pie"></i>
                                <p>Belum ada order</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Enhanced Charts Row 2 --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h6 class="chart-title">
                                <i class="fas fa-trophy me-2"></i>
                                Top 5 Produk Terlaris
                            </h6>
                            <p class="chart-subtitle">Produk dengan penjualan tertinggi</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        @if($topProducts->isNotEmpty())
                            <div style="height: 350px;">
                                <canvas id="productChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <p>Belum ada produk terjual</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h6 class="chart-title">
                                <i class="fas fa-credit-card me-2"></i>
                                Metode Pembayaran
                            </h6>
                            <p class="chart-subtitle">Preferensi metode pembayaran</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        @if($paymentStats->isNotEmpty())
                            <div style="height: 350px;">
                                <canvas id="paymentChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-credit-card"></i>
                                <p>Belum ada data pembayaran</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Enhanced Charts Row 3 --}}
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h6 class="chart-title">
                                <i class="fas fa-boxes me-2"></i>
                                Performa Kategori Produk
                            </h6>
                            <p class="chart-subtitle">Revenue berdasarkan kategori</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        @if($categoryStats->isNotEmpty())
                            <div style="height: 350px;">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-boxes"></i>
                                <p>Belum ada data kategori</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <div>
                            <h6 class="chart-title">
                                <i class="fas fa-crown me-2"></i>
                                Top 5 Customer VIP
                            </h6>
                            <p class="chart-subtitle">Customer dengan total belanja tertinggi</p>
                        </div>
                    </div>
                    <div class="chart-body">
                        @if($topCustomers->isNotEmpty())
                            <div class="vip-customers-list">
                                @foreach($topCustomers as $index => $customer)
                                <div class="vip-customer-item">
                                    <div class="vip-rank rank-{{ $index + 1 }}">
                                        <span>{{ $index + 1 }}</span>
                                    </div>
                                    <div class="vip-avatar">
                                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                                    </div>
                                    <div class="vip-info">
                                        <h6 class="vip-name">{{ $customer->name }}</h6>
                                        <p class="vip-email">{{ $customer->email }}</p>
                                    </div>
                                    <div class="vip-stats">
                                        <div class="vip-orders">
                                            <span class="label">Orders</span>
                                            <span class="value">{{ $customer->total_orders }}</span>
                                        </div>
                                        <div class="vip-spent">
                                            <span class="label">Total Belanja</span>
                                            <span class="value">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-user-friends"></i>
                                <p>Belum ada data customer</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, sans-serif";
    Chart.defaults.color = '#64748b';

    // 1. Mini Charts for KPI Cards
    const miniChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { enabled: false } },
        scales: { x: { display: false }, y: { display: false } },
        elements: { line: { tension: 0.4 }, point: { radius: 0 } }
    };

    [1, 2, 3].forEach(num => {
        // FIX: Menggunakan string concatenation atau template literal dengan benar
        const ctx = document.getElementById('miniChart' + num); 
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['', '', '', '', '', ''],
                    datasets: [{
                        data: [3, 7, 4, 8, 5, 9], // Dummy data untuk efek visual
                        borderColor: 'rgba(255, 255, 255, 0.8)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: miniChartOptions
            });
        }
    });

    @if($revenueTrend->isNotEmpty())
    // 2. Revenue Chart with Gradient
    const revenueCtx = document.getElementById('revenueChart');
    if(revenueCtx) {
        const gradient = revenueCtx.getContext('2d').createLinearGradient(0, 0, 0, 350);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueTrend->map(function($item) {
                    $monthNames = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Oct', 'Nov', 'Des'];
                    return $monthNames[$item->month] . ' ' . $item->year;
                })) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($revenueTrend->pluck('total')) !!},
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#6366f1',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        padding: 16,
                        borderColor: 'rgba(148, 163, 184, 0.1)',
                        borderWidth: 1,
                        titleColor: '#f1f5f9',
                        bodyColor: '#cbd5e1',
                        displayColors: false,
                        callbacks: {
                            label: (c) => 'Rp ' + new Intl.NumberFormat('id-ID').format(c.parsed.y)
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        border: { display: false },
                        grid: { color: 'rgba(148, 163, 184, 0.1)' },
                        ticks: {
                            callback: (v) => 'Rp ' + (v / 1000000).toFixed(0) + 'M',
                            padding: 10
                        }
                    },
                    x: {
                        border: { display: false },
                        grid: { display: false },
                        ticks: { padding: 10 }
                    }
                }
            }
        });
    }
    @endif

    @if($orderStatusStats->isNotEmpty())
    // 3. Order Status Chart
    new Chart(document.getElementById('orderStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($orderStatusStats->pluck('status')->map(function($s) {
                $labels = ['paid' => 'Paid', 'pending' => 'Pending', 'cancelled' => 'Cancelled'];
                return $labels[$s] ?? ucfirst($s);
            })) !!},
            datasets: [{
                data: {!! json_encode($orderStatusStats->pluck('total')) !!},
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6366f1', '#8b5cf6'],
                borderWidth: 4,
                borderColor: '#ffffff',
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: { size: 13, weight: '500' },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
    @endif

    @if($topProducts->isNotEmpty())
    // 4. Top Products Chart
    new Chart(document.getElementById('productChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topProducts->pluck('name')) !!},
            datasets: [{
                label: 'Qty Terjual',
                data: {!! json_encode($topProducts->pluck('total_qty')) !!},
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#06b6d4'].map(c => c + 'dd'),
                borderColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#06b6d4'],
                borderWidth: 2,
                borderRadius: 8,
                barThickness: 35
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: { color: 'rgba(148, 163, 184, 0.1)' }
                },
                y: {
                    border: { display: false },
                    grid: { display: false }
                }
            }
        }
    });
    @endif

    @if($paymentStats->isNotEmpty())
    // 5. Payment Methods Chart
    new Chart(document.getElementById('paymentChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($paymentStats->pluck('provider_name')) !!},
            datasets: [{
                data: {!! json_encode($paymentStats->pluck('total_transaksi')) !!},
                backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6'].map(c => c + 'dd'),
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: { size: 13, weight: '500' },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });
    @endif

    @if($categoryStats->isNotEmpty())
    // 6. Category Performance Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($categoryStats->pluck('category')) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($categoryStats->pluck('total_revenue')) !!},
                backgroundColor: '#6366f1dd',
                borderColor: '#6366f1',
                borderWidth: 2,
                borderRadius: 10,
                barThickness: 45
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    padding: 16,
                    callbacks: {
                        label: (c) => 'Rp ' + new Intl.NumberFormat('id-ID').format(c.parsed.y)
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    border: { display: false },
                    grid: { color: 'rgba(148, 163, 184, 0.1)' },
                    ticks: {
                        callback: (v) => 'Rp ' + (v / 1000000).toFixed(1) + 'M'
                    }
                },
                x: {
                    border: { display: false },
                    grid: { display: false }
                }
            }
        }
    });
    @endif
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .dashboard-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }

    .dashboard-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3), transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(99, 102, 241, 0.3), transparent 50%),
            radial-gradient(circle at 40% 20%, rgba(139, 92, 246, 0.3), transparent 50%);
        animation: bgFloat 20s ease-in-out infinite;
    }

    @keyframes bgFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* Header Styles */
    .dashboard-header {
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .gradient-text {
        background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .dashboard-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        font-weight: 500;
    }

    .status-badge {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 12px 24px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        animation: fadeInScale 0.6s ease-out 0.2s both;
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }

    .pulse-dot {
        width: 10px;
        height: 10px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse 2s ease-in-out infinite;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }

    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        50% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
    }

    /* Enhanced KPI Cards */
    .kpi-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 28px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out both;
        height: 100%;
    }

    .kpi-card:nth-child(1) { animation-delay: 0.1s; }
    .kpi-card:nth-child(2) { animation-delay: 0.2s; }
    .kpi-card:nth-child(3) { animation-delay: 0.3s; }
    .kpi-card:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .kpi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--card-color-1), var(--card-color-2));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .kpi-card:hover::before { transform: scaleX(1); }

    .kpi-primary { --card-color-1: #6366f1; --card-color-2: #8b5cf6; }
    .kpi-success { --card-color-1: #10b981; --card-color-2: #059669; }
    .kpi-info { --card-color-1: #06b6d4; --card-color-2: #0891b2; }
    .kpi-warning { --card-color-1: #f59e0b; --card-color-2: #d97706; }

    .kpi-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
    }

    .kpi-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--card-color-1), var(--card-color-2));
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .kpi-icon i { font-size: 1.6rem; color: white; }

    .kpi-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 8px;
    }

    .kpi-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .kpi-chart-mini {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 120px;
        height: 40px;
        opacity: 0.15;
    }

    .rating-stars {
        position: absolute;
        bottom: 20px;
        right: 20px;
        display: flex;
        gap: 4px;
    }

    .rating-stars i {
        font-size: 0.9rem;
        color: #cbd5e1;
        transition: all 0.3s ease;
    }

    .rating-stars i.active { color: #f59e0b; }

    /* Chart Cards */
    .chart-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.6s ease-out both;
        height: 100%;
    }

    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.15);
    }

    .chart-header {
        padding: 24px 28px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .chart-title i { color: #6366f1; }

    .chart-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        margin: 4px 0 0 0;
        font-weight: 500;
    }

    .chart-body { padding: 28px; }

    /* Empty States */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 350px;
        color: #cbd5e1;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 16px;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 1rem;
        font-weight: 500;
        margin: 0;
    }

    /* VIP Customers List */
    .vip-customers-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        max-height: 450px;
        overflow-y: auto;
        padding-right: 8px;
    }

    .vip-customers-list::-webkit-scrollbar { width: 6px; }
    .vip-customers-list::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
    .vip-customers-list::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    .vip-customer-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%);
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .vip-customer-item:hover {
        transform: translateX(8px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        border-color: #cbd5e1;
    }

    .vip-rank {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        font-weight: 800;
        color: white;
        flex-shrink: 0;
    }

    .vip-rank.rank-1 { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3); }
    .vip-rank.rank-2 { background: linear-gradient(135deg, #94a3b8, #64748b); box-shadow: 0 8px 20px rgba(148, 163, 184, 0.3); }
    .vip-rank.rank-3 { background: linear-gradient(135deg, #fb923c, #f97316); box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3); }
    .vip-rank.rank-4, .vip-rank.rank-5 { background: linear-gradient(135deg, #6366f1, #8b5cf6); box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3); }

    .vip-avatar {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
    }

    .vip-info { flex: 1; min-width: 0; }
    .vip-name { font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0 0 4px 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .vip-email { font-size: 0.85rem; color: #64748b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    
    .vip-stats { display: flex; gap: 24px; flex-shrink: 0; }
    .vip-orders, .vip-spent { text-align: right; }
    .vip-stats .label { display: block; font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .vip-orders .value { display: inline-block; padding: 6px 14px; background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; border-radius: 8px; font-size: 0.9rem; font-weight: 700; box-shadow: 0 4px 12px rgba(6, 182, 212, 0.2); }
    .vip-spent .value { display: block; font-size: 1.1rem; font-weight: 800; color: #10b981; }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .dashboard-title { font-size: 2rem; }
        .kpi-value { font-size: 1.5rem; }
    }

    @media (max-width: 768px) {
        .dashboard-header, .chart-header { flex-direction: column; align-items: flex-start !important; gap: 16px; }
        .status-badge { align-self: flex-start; }
        .vip-customer-item { flex-wrap: wrap; }
        .vip-stats { width: 100%; justify-content: space-between; }
        .kpi-chart-mini { display: none; }
    }
</style>
@endsection