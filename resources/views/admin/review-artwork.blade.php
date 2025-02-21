<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $artwork['title'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif; /* Updated to Roboto */
            background-color: #f7f8fa;
            color: #333;
        }
        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
            background-color: #4c1d95;
            color: #fff;
        }

        .carousel-button:hover {
            background-color: #6b7280;
        }

        .image-thumbnail:hover {
            transform: scale(1.1);
        }

        .share-icons i:hover {
            transform: scale(1.2);
            color: #4c1d95;
        }

        .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .ellipsis-button {
            @apply p-2 border rounded-lg flex items-center justify-center text-gray-600 hover:bg-gray-200 transition-all;
        }
        /* Modal Background */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
        }
        .modal.active {
            display: flex;
        }

        /* Zoom Slider */
        .zoom-controls {
            position: absolute;
            bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .zoom-controls button {
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            width: 40px; /* Adjust for consistent width */
            height: 40px; /* Ensure width equals height for round shape */
            border-radius: 50%; /* Makes the button perfectly round */
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem; /* Ensures the font is properly centered */
        }

        .zoom-controls button:hover {
            background-color: rgba(255, 255, 255, 1);
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    @if(Auth::Check())
    {{-- @include('layouts.navbar-login') --}}
    @else
    {{-- @include('layouts.navbar') --}}
    @endif

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto p-4">
        {{-- <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
            <a href="/" class="hover:underline">home</a>
            <span>/</span>
            <a href="/category" class="hover:underline">{{ $artwork['category'] }}</a>
            <span>/</span>
            <span class="text-gray-800">{{ $artwork->ARTWORK_TITLE }}</span>
        </nav> --}}
        <!-- Back Button with Arrow Icon -->
        <a href="javascript:history.back()" 
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-300 transition duration-300 shadow-sm mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            <span class="text-sm font-medium text-white">Back</span>
        </a>

        @if(session('status'))
        <div class="p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('status') }}
        </div>
        @endif

        @foreach($errors->all() as $error)
        <div class="flex items-center p-4 my-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Error</span>
            <div>
            {{ $error }}
            </div>
        </div>
        @endforeach

        <!-- Clickable Artwork Image with Navigation -->
        <div class="relative flex flex-col items-center max-w-screen-lg p-4">
            <!-- Left Navigation Button -->
            <button id="prevButton" 
                class="absolute left-[-25px] top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 rounded-full shadow-md hover:bg-gray-700 z-10">
                &#10094;
            </button>

            <!-- Artwork Image -->
            <img id="artworkImage" 
                src="{{ Str::startsWith($artwork->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($artwork->ArtImages()->first()->IMAGE_PATH) : $artwork->ArtImages()->first()->IMAGE_PATH }}" 
                alt="{{ $artwork->ARTWORK_TITLE }}" 
                class="max-h-[85vh] w-auto object-contain rounded-lg transition-transform duration-300 transform hover:scale-105 cursor-pointer" />

            <!-- Right Navigation Button -->
            <button id="nextButton" 
                class="absolute right-[-25px] top-1/2 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-2 rounded-full shadow-md hover:bg-gray-700">
                &#10095;
            </button>

            <!-- Dots Indicator -->
            <div id="dotsContainer" class="flex space-x-2 mt-4">
                @foreach ($artwork->ArtImages()->get() as $index => $image)
                    <div class="dot w-3 h-3 rounded-full bg-gray-400 cursor-pointer" data-index="{{ $index }}"></div>
                @endforeach
            </div>
        </div>


    <!-- Artwork Info Section (Redesigned) -->
    <div class="mt-8 lg:flex lg:space-x-4 lg:justify-between">
            <!-- Basic Artwork Details -->
            <div class="lg:w-2/3 space-y-4">
                <!-- Artist Info Above Title -->
                <div class="flex items-center mb-2">
                    <img src="{{ $artwork->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($artwork->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Artist Name" class="w-12 h-12 rounded-full mr-4">
                    <div>
                        <span class="block text-lg font-semibold text-gray-800">{{ $artwork->MasterUser->Buyer->FULLNAME }}</span>
                    </div>
                </div>
                <!-- Artwork Title -->
                <h2 class="text-3xl font-bold text-gray-900">{{ $artwork->ART_TITLE }}</h2>

                <!-- Category  -->
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($artwork->ArtCategories as $category)
                    <button class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium border border-gray-300 rounded-full hover:bg-gray-200 transition">
                        {{ $category->ArtCategoryMaster->DESCR }}
                    </button>
                    @endforeach
                </div>

                <div class="text-xl font-semibold text-indigo-600 mt-4">
                    @if ($artwork->IS_SALE == 1)
                    Rp {{ number_format($artwork->PRICE, 0, ',', '.') }}
                    @else
                    Not For Sale
                    @endif
                </div>
                <!-- Actions -->
                <div class="flex space-x-4 mt-6">
                    <a href="{{ route('admin.artRequest.art.artUploadRequest.approve',['id'=>$artwork->ART_ID]) }}" class="border border-green-500 text-green-500 py-2 px-4 rounded-lg hover:bg-green-50 transition btn">
                        <i class="fas fa-check"></i>
                        <span>Approve</span>
                    </a>
                    <a href="{{ route('admin.artRequest.art.artUploadRequest.reject',['id'=>$artwork->ART_ID]) }}" class="border border-red-500 text-red-500 py-2 px-4 rounded-lg hover:bg-red-50 transition btn">
                        <i class="fas fa-times-circle"></i>
                        <span>Reject</span>
                    </a>
                </div>
            </div>

            <!-- New Share and More Button Section -->
            {{-- <div class="lg:w-1/3 space-y-4 mt-6 lg:mt-0">
                <!-- Share and More Button -->
                <div class="flex space-x-2 mt-4"> --}}
                    {{-- <!-- Share Button with New SVG Icon -->
                    @if(Auth::user() != null)
                    <a href="{{ route('artwork.like',['id'=>$artwork->ART_ID]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="@if($artwork->isLiked()) currentColor @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-pink-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    </a>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-pink-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    @endif
                    <span>{{ $artwork->ArtLikes->count() }}</span> --}}
                    {{-- <button class="share-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                        </svg>
                    </button>
                    <!-- Ellipsis (More Options) Button -->
                    <button class="ellipsis-button">
                        <i class="fas fa-ellipsis-h"></i>
                    </button> --}}
                {{-- </div>
            </div> --}}
        </div>

        <!-- Description Section -->
        <div class="mt-12">
            <h3 class="text-xl font-semibold mb-4">Description</h3>
            <p class="text-gray-700 leading-relaxed">{{ $artwork->DESCRIPTION }}</p>
        </div>

        <!-- Additional Details -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center space-x-2">
                <i class="fas fa-ruler-combined text-gray-500"></i>
                <div>
                    <h4 class="text-sm font-bold">Dimensions</h4>
                    <p class="text-sm text-gray-500">{{ $artwork->WIDTH }}x{{ $artwork->HEIGHT }} {{ $artwork->UNIT }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-palette text-gray-500"></i>
                <div>
                    <h4 class="text-sm font-bold">Style</h4>
                    <p class="text-sm text-gray-500">Abstract</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <i class="fas fa-users text-gray-500"></i>
                <div>
                    <h4 class="text-sm font-bold">Subject</h4>
                    <p class="text-sm text-gray-500">Nature</p>
                </div>
            </div>
        </div>
<!-- Other Listings Section -->
{{-- @if($moreArtWorks->count() > 0)
<div class="max-w-7xl mx-auto py-12 mt-12">
    <div class="text-center mb-8">
        <img alt="Profile picture of Ruslana Levandovska" class="rounded-full mx-auto mb-4 w-16 h-16 object-cover"
             src="{{ $artwork->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($artwork->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" />
        <h2 class="text-2xl font-semibold text-gray-700 mt-2">
            Other listings from {{ $artwork->MasterUser->Buyer->FULLNAME }}
        </h2>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Listing Card 1 -->
        @foreach($moreArtWorks as $otherArtwork)
        <a href="{{ route('artwork.show', $otherArtwork->ART_ID) }}" class="group bg-white rounded-lg border border-gray-200 overflow-hidden shadow hover:shadow-lg transition">
            <img src="{{ Str::startsWith($otherArtwork->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($otherArtwork->ArtImages()->first()->IMAGE_PATH) : $otherArtwork->ArtImages()->first()->IMAGE_PATH }}" 
                 alt="{{ $otherArtwork->ART_TITLE }}" 
                 class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-1 group-hover:text-indigo-600 transition-colors">{{ $otherArtwork->ART_TITLE }}</h3>
                <p class="text-gray-500">
                    @if ($otherArtwork->IS_SALE == 1)
                    Rp.{{ number_format($otherArtwork->PRICE, 2, ',', '.') }}
                    @else
                    Not For Sale
                    @endif
                </p>
                <p class="text-gray-500 text-sm">
                    {{ $otherArtwork->ArtCategories->map(fn($category) => $category->ArtCategoryMaster->DESCR)->implode(' | ') }}
                </p>
            </div>
        </a>
        @endforeach
</div>
@endif --}}

    <!-- Modal for Zoomed Image -->
    <div id="imageModal" class="modal">
        <button id="closeModal" class="absolute top-4 right-4 text-white text-3xl">&times;</button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain transition-transform duration-300 transform">
        <div class="zoom-controls">
            <button id="zoomOut">-</button>
            <button id="zoomIn">+</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        // Get the images from Laravel
        const images = @json($artwork->ArtImages()->pluck('IMAGE_PATH')->toArray());

        let currentIndex = 0;
        const artworkImage = document.getElementById("artworkImage");
        const prevButton = document.getElementById("prevButton");
        const nextButton = document.getElementById("nextButton");
        const dots = document.querySelectorAll(".dot");

        function updateImage() {
            let imagePath = images[currentIndex];
            artworkImage.src = imagePath.startsWith('images/art/') ? "{{ asset('') }}" + imagePath : imagePath;

            // Update active dot
            dots.forEach((dot, index) => {
                dot.classList.toggle("bg-gray-800", index === currentIndex);
                dot.classList.toggle("bg-gray-400", index !== currentIndex);
            });
        }

        prevButton.addEventListener("click", function () {
            currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
            updateImage();
        });

        nextButton.addEventListener("click", function () {
            currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
            updateImage();
        });

        // Allow clicking on dots to jump to an image
        dots.forEach(dot => {
            dot.addEventListener("click", function () {
                currentIndex = parseInt(this.dataset.index);
                updateImage();
            });
        });

        // Initialize first active dot
        updateImage();
    });
    
// Get elements
const artworkImage = document.getElementById('artworkImage');
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const closeModal = document.getElementById('closeModal');
    const zoomIn = document.getElementById('zoomIn');
    const zoomOut = document.getElementById('zoomOut');

    // Zoom and Pan variables
    let zoomScale = 1;
    let isDragging = false;
    let startX, startY, translateX = 0, translateY = 0;

    // Open modal
    artworkImage.addEventListener('click', () => {
        modalImage.src = artworkImage.src;
        imageModal.classList.add('active');
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        imageModal.classList.remove('active');
        resetImage(); // Reset zoom and pan
    });

    // Zoom in
    zoomIn.addEventListener('click', () => {
        zoomScale += 0.1;
        applyTransform();
    });

    // Zoom out
    zoomOut.addEventListener('click', () => {
        if (zoomScale > 0.5) { // Prevent zooming out too much
            zoomScale -= 0.1;
            applyTransform();
        }
    });

    // Pan Image (Mouse Down)
    modalImage.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX - translateX;
        startY = e.clientY - translateY;
        modalImage.style.cursor = "grabbing";
    });

    // Stop Pan (Mouse Up)
    window.addEventListener('mouseup', () => {
        isDragging = false;
        modalImage.style.cursor = "grab";
    });

    // Move Image (Mouse Move)
    window.addEventListener('mousemove', (e) => {
        if (isDragging) {
            translateX = e.clientX - startX;
            translateY = e.clientY - startY;
            applyTransform();
        }
    });

    // Reset Image
    function resetImage() {
        zoomScale = 1;
        translateX = 0;
        translateY = 0;
        applyTransform();
    }

    // Apply Transform (Zoom and Pan)
    function applyTransform() {
        modalImage.style.transform = `translate(${translateX}px, ${translateY}px) scale(${zoomScale})`;
    }
    function openEditModal() {
        document.getElementById('editArtworkModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editArtworkModal').classList.add('hidden');
    }
    // Character Count Logic
    function updateCharCount(textarea) {
        const currentLength = textarea.value.length;
        const charCount = document.getElementById('charCountEdit');
        const errorMessage = document.getElementById('errorMessageEdit');

        charCount.textContent = `${currentLength} / 150`;

        if (currentLength > 150) {
            errorMessage.classList.remove('hidden');
            textarea.value = textarea.value.substring(0, 150);
            charCount.textContent = '150 / 150';
        } else {
            errorMessage.classList.add('hidden');
        }
    }
    </script>
</body>

</html>
