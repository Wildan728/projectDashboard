<!-- dashboard.html -->
@extends('layouts.master')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600">Selamat datang, Admin!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Total Event</h2>
            <p class="text-3xl font-bold text-red-700 mt-2">15</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Sales Aktif</h2>
            <p class="text-3xl font-bold text-red-700 mt-2">5</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Event Bulan Ini</h2>
            <p class="text-3xl font-bold text-red-700 mt-2">4</p>
        </div>
    </div>
@endsection
