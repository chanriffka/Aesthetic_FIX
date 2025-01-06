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
    @include('layouts.navbar-login')
    @else
    @include('layouts.navbar')
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

        <!-- Clickable Artwork Image -->
        <div class="flex justify-center items-center max-w-screen-lg p-4">
            <img id="artworkImage" 
                 src="{{ Str::startsWith($artwork->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($artwork->ArtImages()->first()->IMAGE_PATH) : $artwork->ArtImages()->first()->IMAGE_PATH }}" 
                 alt="{{ $artwork->ARTWORK_TITLE }}" 
                 class="max-h-[85vh] w-auto object-contain rounded-lg transition-transform duration-300 transform hover:scale-105 cursor-pointer" />
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
                    @if(Auth::check())
                        @if (Auth::user()->USER_ID == $artwork->USER_ID )
                            <button id="editArtworkButton" onclick="openEditModal()" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600 transition btn">
                                <i class="fas fa-pen"></i>
                                <span>EDIT</span>
                            </button>
                            <a href={{ route('artwork.destroy', ['artworkId' => $artwork->ART_ID]) }} class="border border-red-500 text-red-500 py-2 px-4 rounded-lg hover:bg-red-50 transition btn" onclick="return confirm('Are you sure you want to delete this art?');">
                                <i class="fas fa-trash"></i>
                                <span>DELETE</span>
                            </a>
                        @else
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $artwork->MasterUser->Buyer->PHONE_NUMBER) }}" class="border border-indigo-500 text-indigo-500 py-2 px-4 rounded-lg hover:bg-indigo-50 transition btn">
                                CONTACT ARTIST
                            </a>
                            <a href="{{ route('cart.add', ['id'=>$artwork->ART_ID]) }}" class="border border-indigo-500 text-indigo-500 py-2 px-4 rounded-lg hover:bg-indigo-50 transition btn">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Add to Cart</span>
                            </a>
                        @endif
                    @else
                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $artwork->MasterUser->Buyer->PHONE_NUMBER) }}" class="border border-indigo-500 text-indigo-500 py-2 px-4 rounded-lg hover:bg-indigo-50 transition btn">
                        CONTACT ARTIST
                    </a>
                        <button class="border border-indigo-500 text-indigo-500 py-2 px-4 rounded-lg hover:bg-indigo-50 transition btn">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Add to Cart</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- New Share and More Button Section -->
            <div class="lg:w-1/3 space-y-4 mt-6 lg:mt-0">
                <!-- Share and More Button -->
                <div class="flex space-x-2 mt-4">
                    <!-- Share Button with New SVG Icon -->
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
                    <span>{{ $artwork->ArtLikes->count() }}</span>
                    {{-- <button class="share-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                        </svg>
                    </button>
                    <!-- Ellipsis (More Options) Button -->
                    <button class="ellipsis-button">
                        <i class="fas fa-ellipsis-h"></i>
                    </button> --}}
                </div>
            </div>
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
                    @foreach($otherArtwork->ArtCategories as $category)
                        {{ $otherArtwork->ArtCategories->map(fn($category) => $category->ArtCategoryMaster->DESCR)->implode(' | ') }}
                    @endforeach
                </p>
            </div>
        </a>
        @endforeach
</div>
<!-- View More Button -->
<div class="flex justify-center mt-8">
    <a href="#"
       class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition">
        View More <span class="ml-2">→</span>
    </a>
</div>
<!-- Edit Artwork Modal -->
<div id="editArtworkModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-5xl h-[90vh] overflow-y-auto" 
         x-data="{ 
            uploadOption: '{{ Str::startsWith($artwork->ArtImages()->first()->IMAGE_PATH, "images/art/") ? "file" : "link" }}', 
            imagePreview: '{{ Str::startsWith($artwork->ArtImages()->first()->IMAGE_PATH, "images/art/") ? asset($artwork->ArtImages()->first()->IMAGE_PATH) : $artwork->ArtImages()->first()->IMAGE_PATH }}' 
         }">

        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Artwork</h2>
            <button type="button" onclick="closeEditModal()" class="text-gray-500 hover:text-red-500 text-2xl">&times;</button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('artwork.update',['artworkId'=>$artwork->ART_ID]) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="artworkTitleEdit" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" id="artworkTitleEdit" value="{{ $artwork->ART_TITLE }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Dimensions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="artworkLengthEdit" class="block text-sm font-medium text-gray-700 mb-1">Height</label>
                    <input type="number" name="artworkHeight" id="artworkLengthEdit" value="{{ $artwork->HEIGHT }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label for="artworkWidthEdit" class="block text-sm font-medium text-gray-700 mb-1">Width</label>
                    <input type="number" name="artworkWidth" id="artworkWidthEdit" value="{{ $artwork->WIDTH }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label for="dimensionUnitEdit" class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                    <select name="dimensionUnit" id="dimensionUnitEdit" 
                            class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="CM" {{ $artwork->UNIT == 'CM' ? 'selected' : '' }}>CM</option>
                        <option value="MM" {{ $artwork->UNIT == 'MM' ? 'selected' : '' }}>MM</option>
                        <option value="M" {{ $artwork->UNIT == 'M' ? 'selected' : '' }}>M</option>
                    </select>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="artworkDescriptionEdit" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="artworkDescriptionEdit" rows="5" maxlength="150"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                          oninput="updateCharCount(this)" required>{{ $artwork->DESCRIPTION }}</textarea>
                <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                    <span id="charCountEdit">0 / 150</span>
                    <span id="errorMessageEdit" class="text-red-600 hidden">Maximum 150 characters allowed</span>
                </div>
            </div>

            <!-- Category Selection -->
            <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
            <div class="flex items-center gap-3">
                <input type="text" id="selectedCategories" readonly
                    class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-gray-100 cursor-not-allowed" 
                    placeholder="Select categories (max 3)">
                <button type="button" onclick="toggleCategorySelection()" 
                        class="text-indigo-600 hover:text-indigo-800 transition">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <!-- Category Dropdown -->
            <div id="categorySelection" class="hidden mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="text-gray-700 font-semibold mb-2">Select Categories</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                   {{-- @foreach($artCategoriesMaster as $artCategorie) --}}
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="category-checkbox w-4 h-4 text-indigo-600 focus:ring-indigo-500"
                        {{--   name="category_art[]" value="{{ $artCategorie->ART_CATEGORY_MASTER_ID }}" --}}>
                        <span class="text-gray-700"> {{-- {{ $artCategorie->DESCR }} --}}</span>
                    </label>
                  {{--  @endforeach --}}
                </div>
                <span id="portfolioCategoryError" class="text-red-600 text-sm hidden">You can select up to 3 categories only.</span>
            </div>
        </div>


            <!-- Price -->
            <div>
                <label for="artworkPriceEdit" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                <input type="number" name="price" id="artworkPriceEdit" value="{{ $artwork->PRICE }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Image Upload Section -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image Upload Option</label>
                <div class="flex items-center gap-4 mb-4">
                    <label class="flex items-center">
                        <input type="radio" name="imageOption" value="link" x-model="uploadOption" class="mr-2">
                        <span>Image URL</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="imageOption" value="file" x-model="uploadOption" class="mr-2">
                        <span>Upload New File</span>
                    </label>
                </div>

                <div x-show="uploadOption === 'link'" class="transition">
                    <label for="imageLinkEdit" class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
                    <input type="text" name="imageLink" id="imageLinkEdit" value="{{ $artwork->IMAGE_URL }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                            @input="imagePreview = $event.target.value">
                </div>

                <div x-show="uploadOption === 'file'" class="transition">
                    <label for="imageFileEdit" class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
                    <input type="file" name="imageFile" id="imageFileEdit" accept="image/*"
                           @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Image Preview -->
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Image Preview</p>
                    <img :src="imagePreview" alt="Image Preview" 
                         class="w-full h-64 object-cover rounded-lg border border-gray-200">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 border-t pt-4">
                <button type="button" onclick="closeEditModal()" 
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                <button type="submit" 
                        class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">Save Changes</button>
            </div>
        </form>
    </div>
</div>
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
