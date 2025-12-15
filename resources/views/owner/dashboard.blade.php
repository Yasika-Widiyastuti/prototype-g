@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-bg"></div>
    
    <div class="container-fluid px-4 py-4 position-relative">
        {{-- HEADER --}}
        <div class="dashboard-header mb-5">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <h1 class="dashboard-title mb-2">
                        <span class="gradient-text">Dashboard Analytics</span>
                    </h1>
                </div>

                {{-- DATE CONTROLS --}}
                <div class="date-controls-wrapper">
                    <div class="quick-select mb-2">
                        <button class="quick-btn" onclick="setQuickRange('today')">Hari Ini</button>
                        <button class="quick-btn" onclick="setQuickRange('week')">Minggu Ini</button>
                        <button class="quick-btn" onclick="setQuickRange('month')">Bulan Ini</button>
                        <button class="quick-btn" onclick="setQuickRange('quarter')">Quarter Ini</button>
                        <button class="quick-btn" onclick="setQuickRange('year')">Tahun Ini</button>
                        <button class="quick-btn" onclick="setQuickRange('all')">Semua</button>
                    </div>
                    <input type="text" id="dateRangePicker" class="date-range-input" placeholder="Pilih Tanggal" readonly>
                </div>
            </div>

            <div class="period-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                <span>Menampilkan data: <strong>{{ $periodLabel }}</strong> ({{ $periodDays }} hari)</span>
            </div>
        </div>

        {{-- ROW 1: KPI CARDS --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-primary h-100">
                    <div class="kpi-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div class="kpi-content">
                        <p class="kpi-label">Total Pendapatan</p>
                        <h3 class="kpi-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <div class="kpi-sparkle"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-success h-100">
                    <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="kpi-content">
                        <p class="kpi-label">Order Selesai</p>
                        <h3 class="kpi-value">{{ number_format($completedOrders) }}</h3>
                        <div class="kpi-sparkle"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-info h-100">
                    <div class="kpi-icon"><i class="fas fa-users"></i></div>
                    <div class="kpi-content">
                        <p class="kpi-label">Customer Aktif</p>
                        <h3 class="kpi-value">{{ number_format($activeCustomers) }}</h3>
                        <div class="kpi-sparkle"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-warning h-100">
                    <div class="kpi-icon"><i class="fas fa-star"></i></div>
                    <div class="kpi-content">
                        <p class="kpi-label">Kepuasan Pelanggan</p>
                        <h3 class="kpi-value">{{ number_format($avgRating, 1) }}</h3>
                        <div class="kpi-sparkle"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 2: TREN PENDAPATAN --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title"><i class="fas fa-chart-line me-2"></i>Tren Pendapatan</h5>
                    </div>
                    <div class="chart-body">
                        <div class="chart-container">
                            <canvas id="revenueTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 3: TOP PRODUCTS --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title"><i class="fas fa-trophy me-2"></i>Top 5 Produk Terlaris</h5>
                    </div>
                    <div class="chart-body">
                        <div class="chart-container">
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 4: PAYMENT METHOD --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title"><i class="fas fa-credit-card me-2"></i>Metode Pembayaran</h5>
                    </div>
                    <div class="chart-body">
                        <div class="chart-container mx-auto" style="max-width: 600px;">
                            <canvas id="paymentMethodChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 5: ORDER STATUS --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title"><i class="fas fa-box me-2"></i>Status Order</h5>
                    </div>
                    <div class="chart-body">
                        <div class="chart-container mx-auto" style="max-width: 600px;">
                            <canvas id="orderStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 6: CATEGORY PERFORMANCE --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title"><i class="fas fa-tags me-2"></i>Performa Kategori</h5>
                    </div>
                    <div class="chart-body">
                        <div class="chart-container">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW 7: TOP CUSTOMERS TABLE --}}
        <div class="row g-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="chart-header">
                        <h5 class="chart-title"><i class="fas fa-user-crown me-2"></i>Top 5 Customer</h5>
                    </div>
                    <div class="chart-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th class="text-end">Total Order</th>
                                        <th class="text-end">Total Belanja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topCustomers as $index => $customer)
                                    <tr>
                                        <td>
                                            @if($index == 0)
                                                <span class="badge bg-rank-1"><i class="fas fa-crown me-1"></i>1</span>
                                            @elseif($index == 1)
                                                <span class="badge bg-rank-2"><i class="fas fa-medal me-1"></i>2</span>
                                            @elseif($index == 2)
                                                <span class="badge bg-rank-3"><i class="fas fa-award me-1"></i>3</span>
                                            @else <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $customer->name }}</strong></td>
                                        <td>{{ $customer->email }}</td>
                                        <td class="text-end">{{ number_format($customer->total_orders) }}</td>
                                        <td class="text-end"><strong>Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Tidak ada data customer</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SCRIPTS --}}
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// DATE RANGE PICKER
const picker = flatpickr("#dateRangePicker", {
    mode: "range",
    locale: "id",
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d M Y",
    defaultDate: ["{{ $startDate }}", "{{ $endDate }}"],
    onChange: function(selectedDates) {
        if (selectedDates.length === 2) applyDateRange(selectedDates);
    }
});

function setQuickRange(type) {
    let start, end;
    const now = new Date();
    switch(type) {
        case 'today': start = end = now; break;
        case 'week':
            start = new Date(now);
            start.setDate(now.getDate() - now.getDay() + 1);
            end = now;
            break;
        case 'month':
            start = new Date(now.getFullYear(), now.getMonth(), 1);
            end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            break;
        case 'quarter':
            const q = Math.floor(now.getMonth() / 3);
            start = new Date(now.getFullYear(), q * 3, 1);
            end = new Date(now.getFullYear(), (q + 1) * 3, 0);
            break;
        case 'year':
            start = new Date(now.getFullYear(), 0, 1);
            end = new Date(now.getFullYear(), 11, 31);
            break;
        case 'all':
            start = new Date(2015, 0, 1);
            end = now;
            break;
    }
    picker.setDate([start, end]);
    applyDateRange([start, end]);
}

function applyDateRange(dates) {
    const o1 = dates[0].getTime() - (dates[0].getTimezoneOffset() * 60000);
    const o2 = dates[1].getTime() - (dates[1].getTimezoneOffset() * 60000);
    const s = new Date(o1).toISOString().split('T')[0];
    const e = new Date(o2).toISOString().split('T')[0];
    window.location.href = `{{ route('owner.dashboard') }}?start_date=${s}&end_date=${e}`;
}

// COLOR PALETTE
const COLORS = {
    gradients: {
        blue: ['#667eea', '#764ba2'],
        teal: ['#11998e', '#38ef7d'],
        ocean: ['#4facfe', '#00f2fe'],
        sunset: ['#fa709a', '#fee140'],
        purple: ['#a18cd1', '#fbc2eb'],
    },
    category: ['#667eea', '#a18cd1', '#c471f5', '#fa709a', '#4facfe', '#11998e'],
    rank: ['#667eea', '#7c9aef', '#92b4f4', '#a8cef9', '#bee8fe'],
    status: {
        success: '#11998e',
        warning: '#feca57',
        danger: '#ee5a6f',
        processing: '#4facfe',
        shipped: '#a18cd1',
    }
};

// CHART DEFAULTS
const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            position: 'top',
            labels: {
                padding: 15,
                font: { size: 12, weight: '500' },
                usePointStyle: true,
                boxWidth: 10,
                boxHeight: 10
            }
        },
        tooltip: {
            backgroundColor: 'rgba(30, 30, 30, 0.95)',
            padding: 14,
            titleFont: { size: 14, weight: '600' },
            bodyFont: { size: 13 },
            borderColor: 'rgba(255, 255, 255, 0.1)',
            borderWidth: 1,
            callbacks: {
                label: function(ctx) {
                    let lbl = ctx.dataset.label || '';
                    if (lbl) lbl += ': ';
                    if (ctx.parsed.y !== null) {
                        lbl += 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                    } else if (ctx.parsed !== null) {
                        lbl += ctx.parsed.toLocaleString('id-ID');
                    }
                    return lbl;
                }
            }
        }
    }
};

// 1. REVENUE TREND CHART
const revenueTrendData = @json($revenueTrend);
const labels = revenueTrendData.map(item => {
    if (item.full_date) {
        return item.day_name || new Date(item.full_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    } else if (item.week) return `Week ${item.week}`;
    else if (item.month) {
        const m = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return m[item.month - 1];
    } else if (item.year) return item.year.toString();
    return '';
});
const revenues = revenueTrendData.map(item => item.total || 0);

new Chart(document.getElementById('revenueTrendChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: revenues,
            borderColor: COLORS.gradients.blue[0],
            backgroundColor: function(ctx) {
                const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 300);
                g.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
                g.addColorStop(1, 'rgba(102, 126, 234, 0)');
                return g;
            },
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 8,
            pointBackgroundColor: '#fff',
            pointBorderColor: COLORS.gradients.blue[0],
            pointBorderWidth: 3,
            pointHoverBackgroundColor: COLORS.gradients.blue[0],
            pointHoverBorderColor: '#fff',
            pointHoverBorderWidth: 3
        }]
    },
    options: {
        ...chartDefaults,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(v) {
                        return v >= 1000000 ? 'Rp ' + (v/1000000).toFixed(1) + 'M' : 'Rp ' + (v/1000).toFixed(0) + 'K';
                    },
                    font: { size: 11 }
                },
                grid: { color: 'rgba(0, 0, 0, 0.04)' }
            },
            x: {
                ticks: { font: { size: 11 } },
                grid: { display: false }
            }
        }
    }
});

// 2. TOP PRODUCTS CHART
const topProductsData = @json($topProducts);
new Chart(document.getElementById('topProductsChart'), {
    type: 'bar',
    data: {
        labels: topProductsData.map(p => p.name),
        datasets: [{
            label: 'Quantity Terjual',
            data: topProductsData.map(p => p.total_qty),
            backgroundColor: COLORS.rank,
            borderRadius: 10,
            borderSkipped: false
        }]
    },
    options: {
        ...chartDefaults,
        indexAxis: 'y',
        plugins: {
            ...chartDefaults.plugins,
            legend: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: { font: { size: 11 } },
                grid: { color: 'rgba(0, 0, 0, 0.04)' }
            },
            y: {
                ticks: { font: { size: 11 } },
                grid: { display: false }
            }
        }
    }
});

// 3. PAYMENT METHOD CHART
const paymentData = @json($paymentStats);
new Chart(document.getElementById('paymentMethodChart'), {
    type: 'doughnut',
    data: {
        labels: paymentData.map(p => p.provider_name),
        datasets: [{
            data: paymentData.map(p => p.total_transaksi),
            backgroundColor: COLORS.category,
            borderWidth: 4,
            borderColor: '#fff',
            hoverOffset: 12
        }]
    },
    options: {
        ...chartDefaults,
        cutout: '68%',
        plugins: {
            ...chartDefaults.plugins,
            legend: { ...chartDefaults.plugins.legend, position: 'right' },
            tooltip: {
                ...chartDefaults.plugins.tooltip,
                callbacks: {
                    label: function(ctx) {
                        const lbl = ctx.label || '';
                        const val = ctx.parsed;
                        const tot = ctx.dataset.data.reduce((a,b) => a+b, 0);
                        const pct = ((val/tot)*100).toFixed(1);
                        return `${lbl}: ${val} (${pct}%)`;
                    }
                }
            }
        }
    }
});

// 4. ORDER STATUS CHART
const orderStatusData = @json($orderStatusStats);
const statusLabels = {
    'pending': 'Pending', 'paid': 'Dibayar', 'processing': 'Diproses',
    'shipped': 'Dikirim', 'completed': 'Selesai', 'cancelled': 'Dibatalkan', 'failed': 'Gagal'
};
const statusColors = orderStatusData.map(s => {
    const st = s.status.toLowerCase();
    if (['paid', 'completed'].includes(st)) return COLORS.status.success;
    if (['pending', 'unpaid'].includes(st)) return COLORS.status.warning;
    if (['cancelled', 'failed'].includes(st)) return COLORS.status.danger;
    if (st === 'processing') return COLORS.status.processing;
    if (st === 'shipped') return COLORS.status.shipped;
    return '#94a3b8';
});

new Chart(document.getElementById('orderStatusChart'), {
    type: 'pie',
    data: {
        labels: orderStatusData.map(s => statusLabels[s.status] || s.status),
        datasets: [{
            data: orderStatusData.map(s => s.total),
            backgroundColor: statusColors,
            borderWidth: 4,
            borderColor: '#fff',
            hoverOffset: 12
        }]
    },
    options: {
        ...chartDefaults,
        plugins: {
            ...chartDefaults.plugins,
            legend: { ...chartDefaults.plugins.legend, position: 'right' }
        }
    }
});

// 5. CATEGORY PERFORMANCE CHART
const categoryData = @json($categoryStats);
new Chart(document.getElementById('categoryChart'), {
    type: 'bar',
    data: {
        labels: categoryData.map(c => c.category),
        datasets: [{
            label: 'Revenue (Rp)',
            data: categoryData.map(c => c.total_revenue),
            backgroundColor: COLORS.category,
            borderRadius: 10,
            borderSkipped: false
        }]
    },
    options: {
        ...chartDefaults,
        plugins: {
            ...chartDefaults.plugins,
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(v) {
                        return 'Rp ' + (v/1000000).toFixed(1) + 'M';
                    },
                    font: { size: 11 }
                },
                grid: { color: 'rgba(0, 0, 0, 0.04)' }
            },
            x: {
                ticks: { font: { size: 11 } },
                grid: { display: false }
            }
        }
    }
});
</script>

<style>
:root {
    --gradient-blue: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --gradient-teal: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --gradient-ocean: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --gradient-sunset: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --gradient-purple: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
    --shadow-sm: 0 2px 8px rgba(102, 126, 234, 0.08);
    --shadow-md: 0 4px 16px rgba(102, 126, 234, 0.12);
    --shadow-lg: 0 8px 32px rgba(102, 126, 234, 0.16);
}

.dashboard-container {
    min-height: 100vh;
    position: relative;
}

.dashboard-bg {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #fa709a 100%);
    opacity: 0.04;
    z-index: -1;
}

.dashboard-title {
    font-size: 2.25rem;
    font-weight: 700;
    margin: 0;
    letter-spacing: -0.5px;
}

.gradient-text {
    background: var(--gradient-blue);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.date-controls-wrapper {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    padding: 1.25rem;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid rgba(255, 255, 255, 0.6);
}

.quick-select {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.quick-btn {
    padding: 0.5rem 1rem;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.quick-btn:hover {
    background: var(--gradient-blue);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.date-range-input {
    width: 100%;
    padding: 0.75rem 1.25rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s;
    background: white;
}

.date-range-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

.period-info {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #667eea;
    font-size: 0.95rem;
}

.kpi-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 1.75rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(255, 255, 255, 0.6);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.5) 100%);
    opacity: 0;
    transition: opacity 0.4s;
}

.kpi-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
}

.kpi-card:hover::before {
    opacity: 1;
}

.kpi-sparkle {
    position: absolute;
    top: 10px; right: 10px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: 0.1;
    pointer-events: none;
}

.kpi-primary .kpi-sparkle {
    background: radial-gradient(circle, #667eea 0%, transparent 70%);
}

.kpi-success .kpi-sparkle {
    background: radial-gradient(circle, #11998e 0%, transparent 70%);
}

.kpi-info .kpi-sparkle {
    background: radial-gradient(circle, #4facfe 0%, transparent 70%);
}

.kpi-warning .kpi-sparkle {
    background: radial-gradient(circle, #fa709a 0%, transparent 70%);
}

.kpi-icon {
    width: 70px; height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.kpi-card:hover .kpi-icon {
    transform: scale(1.1) rotate(-5deg);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
}

.kpi-primary .kpi-icon {
    background: var(--gradient-blue);
    color: white;
}

.kpi-success .kpi-icon {
    background: var(--gradient-teal);
    color: white;
}

.kpi-info .kpi-icon {
    background: var(--gradient-ocean);
    color: white;
}

.kpi-warning .kpi-icon {
    background: var(--gradient-sunset);
    color: white;
}

.kpi-content {
    flex: 1;
}

.kpi-label {
    font-size: 0.9rem;
    color: #64748b;
    margin: 0 0 0.5rem 0;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.kpi-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    letter-spacing: -0.5px;
}

.chart-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(255, 255, 255, 0.6);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.chart-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
}

.chart-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

.chart-title {
    margin: 0;
    font-size: 1.15rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
}

.chart-title i {
    background: var(--gradient-blue);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.chart-body {
    padding: 2rem;
    position: relative;
}

.chart-container {
    position: relative;
    width: 100%;
}

#revenueTrendChart {
    height: 320px !important;
}

#topProductsChart {
    height: 300px !important;
}

#paymentMethodChart {
    height: 320px !important;
}

#orderStatusChart {
    height: 320px !important;
}

#categoryChart {
    height: 300px !important;
}

.table-responsive {
    border-radius: 12px;
    overflow: hidden;
}

.table {
    margin: 0;
}

.table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color: #475569;
    font-weight: 600;
    border-bottom: 2px solid #e5e7eb;
    padding: 1.25rem 1.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: all 0.2s;
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.04) 0%, rgba(250, 112, 154, 0.04) 100%);
    transform: scale(1.01);
}

.table tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    color: #334155;
}

.badge {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.badge.bg-rank-1 {
    background: var(--gradient-sunset) !important;
    color: white;
    box-shadow: 0 2px 8px rgba(250, 112, 154, 0.3);
}

.badge.bg-rank-2 {
    background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%) !important;
    color: white;
    box-shadow: 0 2px 8px rgba(100, 116, 139, 0.3);
}

.badge.bg-rank-3 {
    background: linear-gradient(135deg, #cd7f32 0%, #b87333 100%) !important;
    color: white;
    box-shadow: 0 2px 8px rgba(205, 127, 50, 0.3);
}

.badge.bg-light {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%) !important;
    color: #475569 !important;
}

@media (max-width: 1200px) {
    .dashboard-title {
        font-size: 2rem;
    }
    
    .kpi-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .kpi-value {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .dashboard-title {
        font-size: 1.75rem;
    }
    
    .quick-select {
        justify-content: center;
    }
    
    .kpi-card {
        padding: 1.5rem;
    }
    
    .kpi-icon {
        width: 55px;
        height: 55px;
        font-size: 1.35rem;
    }
    
    .kpi-value {
        font-size: 1.35rem;
    }
    
    .kpi-label {
        font-size: 0.8rem;
    }
    
    .chart-body {
        padding: 1.25rem;
    }
    
    .chart-header {
        padding: 1.25rem 1.5rem;
    }
    
    #revenueTrendChart {
        height: 240px !important;
    }
    
    #topProductsChart,
    #categoryChart {
        height: 220px !important;
    }
    
    #paymentMethodChart,
    #orderStatusChart {
        height: 260px !important;
    }
    
    .table thead th,
    .table tbody td {
        padding: 1rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .dashboard-container {
        padding: 0 !important;
    }
    
    .container-fluid {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .dashboard-title {
        font-size: 1.5rem;
    }
    
    .date-controls-wrapper {
        padding: 1rem;
    }
    
    .quick-btn {
        font-size: 0.8rem;
        padding: 0.4rem 0.75rem;
    }
    
    .kpi-card {
        padding: 1.25rem;
    }
    
    .kpi-value {
        font-size: 1.2rem;
    }
    
    .chart-title {
        font-size: 1rem;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.kpi-card,
.chart-card {
    animation: fadeInUp 0.6s ease-out;
}

.kpi-card:nth-child(1) { animation-delay: 0.1s; }
.kpi-card:nth-child(2) { animation-delay: 0.2s; }
.kpi-card:nth-child(3) { animation-delay: 0.3s; }
.kpi-card:nth-child(4) { animation-delay: 0.4s; }

.flatpickr-calendar {
    border-radius: 16px !important;
    box-shadow: var(--shadow-lg) !important;
    border: 1px solid #e5e7eb !important;
}

.flatpickr-day.selected {
    background: var(--gradient-blue) !important;
    border-color: #667eea !important;
}

.flatpickr-day.selected:hover {
    background: var(--gradient-blue) !important;
    border-color: #667eea !important;
}

.flatpickr-day:hover {
    background: rgba(102, 126, 234, 0.1) !important;
    border-color: rgba(102, 126, 234, 0.3) !important;
}

::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}
</style>

@endsection