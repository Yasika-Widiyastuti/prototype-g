<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Sewa Barang Konser')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Active sidebar link */
        .sidebar-link.active { 
            background-color: #3182ce; 
            color: white; 
        }
        /* Hover effect for sidebar links */
        .sidebar-link:hover { 
            background-color: #2d3748; 
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">

        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 flex-shrink-0" x-data="{ open: false }">
            <div class="p-4">
                <h1 class="text-xl font-bold">Admin Panel</h1>
                <p class="text-sm text-gray-400">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
            </div>

            <nav class="mt-8">
                <!-- Dashboard Link -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link flex items-center px-4 py-2 text-gray-300 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- User Management -->
                <a href="{{ route('admin.users.index') }}" 
                   class="sidebar-link flex items-center px-4 py-2 text-gray-300 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Manajemen User
                </a>

                <!-- Payment Management -->
                <a href="{{ route('admin.payments.index') }}" 
                   class="sidebar-link flex items-center px-4 py-2 text-gray-300 {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Verifikasi Pembayaran
                    @if(\App\Models\Payment::where('status', 'waiting')->count() > 0)
                        <span class="ml-2 px-2 py-1 text-xs bg-red-500 text-white rounded-full">
                            {{ \App\Models\Payment::where('status', 'waiting')->count() }}
                        </span>
                    @endif
                </a>

                <!-- Orders Management -->
                <a href="{{ route('admin.orders.index') }}" 
                   class="sidebar-link flex items-center px-4 py-2 text-gray-300 {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Kelola Pesanan
                </a>

                <!-- Produk Link -->
                <a href="{{ route('admin.products.index') }}" 
                   class="sidebar-link flex items-center px-4 py-2 text-gray-300 {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Produk
                </a>

                <!-- Audit Logs -->
                <a href="{{ route('admin.audit.index') }}" 
                   class="sidebar-link flex items-center px-4 py-2 text-gray-300 {{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Audit Logs
                </a>

            </nav>

            <div class="absolute bottom-0 w-64 p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-400 hover:text-red-300 text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Top Bar -->
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-6 py-4">
                        <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    </div>
                </header>

                <!-- Content Area -->
                <main class="flex-1 overflow-y-auto p-6">
                    <!-- Popup session -->
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                            class="bg-green-500 text-white px-4 py-3 rounded mb-4 shadow">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                            class="bg-red-500 text-white px-4 py-3 rounded mb-4 shadow">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>

    </div>
</body>
</html>