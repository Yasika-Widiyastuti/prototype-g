@extends('admin.layouts2.app2')

@section('title', 'Laporan Penjualan - Admin Panel')
@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-800 mb-6">Laporan Penjualan</h3>

    <div class="mb-6">
        <p class="text-xl font-semibold text-gray-900">Total Pendapatan Bulan Ini:</p>
        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($sales, 0, ',', '.') }}</p>
    </div>

    <!-- Optional: Bisa ditambahkan grafik atau diagram menggunakan library seperti Chart.js -->
    <!-- Misalnya, jika ingin menambahkan grafik penjualan per hari dalam bulan ini -->
    <div class="mt-6">
        <canvas id="salesChart" width="400" height="200"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($salesData['labels']), // Label tanggal
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($salesData['data']), // Data pendapatan per hari
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Pendapatan Harian'
                    }
                }
            }
        });
    </script>
</div>
@endsection
