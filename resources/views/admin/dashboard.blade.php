@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="bg-gradient-to-r from-green-400 to-green-600 p-6 rounded-xl text-white shadow-lg">
        <h3 class="text-lg font-medium opacity-90">Total Donasi Bulan Ini</h3>
        <p class="text-3xl font-bold mt-2">Rp 125.000.000</p>
    </div>
    <!-- tambah card lain... -->
</div>
@endsection