@extends('admin.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
    <!-- Card Example -->
    <div class="p-6 bg-indigo-light border border-indigo-200 rounded-lg shadow-md hover-indigo">
        <h2 class="text-sm font-medium text-indigo-700">Total Buyers</h2>
        <p class="text-3xl font-extrabold text-indigo-900">{{ $totalBuyers }}</p>
    </div>
    <div class="p-6 bg-indigo-light border border-indigo-200 rounded-lg shadow-md hover-indigo">
        <h2 class="text-sm font-medium text-indigo-700">Total Artists</h2>
        <p class="text-3xl font-extrabold text-indigo-900">{{ $totalArtists }}</p>
    </div>
    <div class="p-6 bg-indigo-light border border-indigo-200 rounded-lg shadow-md hover-indigo">
        <h2 class="text-sm font-medium text-indigo-700">Total Categories</h2>
        <p class="text-3xl font-extrabold text-indigo-900">{{ $totalCategories }}</p>
    </div>
    <div class="p-6 bg-indigo-light border border-indigo-200 rounded-lg shadow-md hover-indigo">
        <h2 class="text-sm font-medium text-indigo-700">Total Skills</h2>
        <p class="text-3xl font-extrabold text-indigo-900">{{ $totalSkills }}</p>
    </div>
    <div class="p-6 bg-indigo-light border border-indigo-200 rounded-lg shadow-md hover-indigo">
        <h2 class="text-sm font-medium text-indigo-700">Published Artworks</h2>
        <p class="text-3xl font-extrabold text-indigo-900">{{ $totalArtworks }}</p>
    </div>
</div>
@endsection
