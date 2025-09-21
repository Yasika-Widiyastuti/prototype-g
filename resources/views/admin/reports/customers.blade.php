@extends('admin.layouts2.app2')

@section('title', 'Laporan Pelanggan - Admin Panel')
@section('page-title', 'Laporan Pelanggan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-800 mb-6">Laporan Pelanggan</h3>

    <div class="mb-6">
        <p class="text-xl font-semibold text-gray-900">Total Pelanggan:</p>
        <p class="text-3xl font-bold text-purple-600">{{ $totalCustomers }}</p>
    </div>

    <div class="mt-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Pelanggan Baru Bulan Ini:</h4>
        <ul class="list-disc pl-6">
            @foreach($newCustomers as $customer)
                <li class="mb-2">
                    <span class="font-semibold">{{ $customer->name }}</span> - 
                    Bergabung pada {{ $customer->created_at->format('d M Y') }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Pelanggan Paling Aktif:</h4>
        <ul class="list-disc pl-6">
            @foreach($activeCustomers as $customer)
                <li class="mb-2">
                    <span class="font-semibold">{{ $customer->name }}</span> - 
                    Total Pesanan: {{ $customer->total_orders }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
