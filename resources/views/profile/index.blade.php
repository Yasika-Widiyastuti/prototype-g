@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Profil Pengguna</h1>
            <p class="text-sm text-gray-600">Halaman ini menampilkan informasi akun Anda.</p>
        </div>

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profil Info -->
        <div class="space-y-4 mb-8">
            <div>
                <p class="text-lg font-semibold text-gray-800">Nama:</p>
                <p class="text-gray-600">{{ $user->name }}</p>
            </div>

            <div>
                <p class="text-lg font-semibold text-gray-800">Email:</p>
                <p class="text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Tombol Edit Profil di bawah -->
        <div class="mt-8 text-center">
            <a href="{{ route('profile.edit') }}" 
               class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
