<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        .gallery-section {
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 1rem; 
        }

        .masonry {
            column-count: 3;
            column-gap: 1rem;
        }

        .masonry-item {
            display: inline-block;
            width: 100%;
            margin-bottom: 1rem;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            transition: transform 0.3s, border-color 0.3s;
            cursor: pointer;
        }

        .masonry-item:hover {
            transform: scale(1.02); 
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
@if(Auth::Check())
    @include('layouts.navbar-login')
@else
    @include('layouts.navbar')
@endif
<!-- Art Gallery Section -->
<div class="gallery-section mt-12">
    <div class="gallery-title text-center text-3xl font-bold text-gray-800 mb-6">
        Welcome to Art Gallery
    </div>
    <div class="gallery-subtitle text-center text-gray-600 mb-8">
        ENJOY VARIOUS ART FROM DESIGNERS AROUND THE WORLD
    </div>
    
    <!-- Masonry Grid Layout -->
    <div class="masonry">
        <!-- Example Artwork Items with Different Aspect Ratios -->
        @foreach($portfolios as $portfolio)
        <a href="{{ route('artGallery.show', $portfolio->ART_ID) }}">
        <div class="masonry-item group relative">
            <img src="{{ Str::startsWith($portfolio->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($portfolio->ArtImages()->first()->IMAGE_PATH) : $portfolio->ArtImages()->first()->IMAGE_PATH }}" 
                 alt="Abstract Artwork 1" 
                 class="w-full h-auto object-cover">
        </div>
        </a>
        @endforeach
    </div>
    {{-- <!-- Load More Button -->
    <div class="flex justify-center mt-8">
        <button class="w-full max-w-4xl mx-4 py-4 text-gray-500 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
            Load more
        </button>
    </div> --}}
</div>

<!-- Modal for viewing image in larger format -->
<div id="imageModal" class="hidden modal-overlay" onclick="closeModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="Large View">
        <span class="close-button" onclick="closeModal()">
            <i class="fas fa-times text-gray-800 text-lg"></i>
        </span>
    </div>
</div>
</body>
</html>
