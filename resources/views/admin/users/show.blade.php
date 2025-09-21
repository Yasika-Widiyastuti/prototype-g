@extends('admin.layouts2.app2')

@section('title', 'Detail User - Admin Panel')
@section('page-title', 'Detail User: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- User Info Card -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-600">{{ $user->email }}</p>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->status_badge }}">
                    {{ $user->status_text }}
                </span>
            </div>
            
            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="px-4 py-2 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-md text-sm">
                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-3 rounded-lg">
                <div class="text-lg font-bold text-blue-600">{{ $stats['total_orders'] }}</div>
                <div class="text-sm text-gray-600">Total Orders</div>
            </div>
            <div class="bg-green-50 p-3 rounded-lg">
                <div class="text-lg font-bold text-green-600">{{ $stats['completed_orders'] }}</div>
                <div class="text-sm text-gray-600">Selesai</div>
            </div>
            <div class="bg-yellow-50 p-3 rounded-lg">
                <div class="text-lg font-bold text-yellow-600">{{ $stats['pending_orders'] }}</div>
                <div class="text-sm text-gray-600">Pending</div>
            </div>
            <div class="bg-purple-50 p-3 rounded-lg">
                <div class="text-lg font-bold text-purple-600">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</div>
                <div class="text-sm text-gray-600">Total Spent</div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h4 class="text-lg font-semibold text-gray-800 mb-4">Orders Terbaru</h4>
        
        @if($recent_orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recent_orders as $order)
                    <tr>
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                        <td class="px-4 py-4 text-sm text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $order->status_badge }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900 text-sm">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-8">User ini belum pernah melakukan order.</p>
        @endif
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
        ← Kembali ke Daftar User
    </a>
</div>
@endsection