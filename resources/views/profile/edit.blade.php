@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Profil</h1>
            <p class="text-sm text-gray-600">Perbarui informasi profil Anda di sini.</p>
        </div>

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Edit Form -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="space-y-4 mb-8">
                <!-- Name -->
                <div>
                    <label for="name" class="text-lg font-semibold text-gray-800">Nama</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           name="name" value="{{ $user->name }}" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="text-lg font-semibold text-gray-800">Email</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           name="email" value="{{ $user->email }}" required>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="mt-8 text-center">
                <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
