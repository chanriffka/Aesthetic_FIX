<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .masonry-container {
            max-height: 600px; /* Sets a max height for the scrollable area */
            overflow-y: auto; /* Enables vertical scrolling */
            padding-right: 1rem; /* Adds padding to avoid content cutoff on the right */
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
        }

        .overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 0.5rem;
            font-size: 0.875rem;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .tag {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
        }
        .scrollable-form {
            max-height: 400px;
            overflow-y: auto;
        }
        .success-modal {
            animation: fadeIn 0.5s ease-in-out, fadeOut 0.5s ease-in-out 2.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }
            to {
                opacity: 0;
                transform: scale(0.9);
            }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Portfolio</h1>
        @if(Auth::check())
            @if (Auth::user()->USER_ID == $artist->USER_ID )
                <button onclick="openModal()" class="flex items-center px-6 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition">
                Add New 
                </button>
            @endif
        @endif
    </div>

    <!-- Masonry Grid Layout Container with Scrollable Area -->
    <div class="masonry-container">
        <div class="masonry">
            <!-- Example Artwork Items -->
            @foreach($portfolios as $portfolio)
            <a href="{{ route('artGallery.show', $portfolio->ART_ID) }}">
                <div class="masonry-item group relative">
                    <img src="{{ Str::startsWith($portfolio->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($portfolio->ArtImages()->first()->IMAGE_PATH) : $portfolio->ArtImages()->first()->IMAGE_PATH }}" 
                        alt="{{ $portfolio->ART_TITLE }}" 
                        class="w-full h-auto object-cover transition-transform duration-500 transform group-hover:scale-105">
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Add Portfolio Modal -->
<div id="addPortfolioModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-7xl h-[90vh] overflow-y-auto" 
         x-data="{ 
            uploadOption: 'link', 
            imagePreview: '' 
         }">

        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Add New Portfolio</h2>
            <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-red-500 text-2xl">&times;</button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('portfolio.store') }}" enctype="multipart/form-data" class="space-y-6" id="addPortfolioForm">
            @csrf

            <!-- Form Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Section: Text Inputs -->
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="portfolioTitle" class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                        <input type="text" name="portfolioTitle" id="portfolioTitle" placeholder="Enter Title" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                        <span id="portfolioTitleError" class="text-red-600"></span>
                    </div>

                                    <!-- Dimension Section -->
                <div>
                    <label for="dimension" class="block text-sm font-semibold text-gray-700 mb-1">Dimensions</label>
                    <div class="flex gap-4">
                        <!-- Length Input -->
                        <div class="flex-1">
                            <input 
                                type="number" 
                                name="artworkHeight" 
                                id="artworkHeight" 
                                placeholder="Height" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                                required
                            />
                            <p class="text-xs text-gray-500 mt-1">Enter height</p>
                        </div>

                        <!-- Width Input -->
                        <div class="flex-1">
                            <input 
                                type="number" 
                                name="artworkWidth" 
                                id="artworkWidth" 
                                placeholder="Width" 
                                class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                                required
                            />
                            <p class="text-xs text-gray-500 mt-1">Enter width</p>
                        </div>

                        <!-- Unit Dropdown -->
                        <div class="w-32">
                            <select 
                                name="dimensionUnit" 
                                id="dimensionUnit" 
                                class="w-full px-4 py-2 border rounded-lg bg-white focus:ring-indigo-500 focus:border-indigo-500"
                                required
                            >
                                <option value="CM">CM</option>
                                <option value="MM">MM</option>
                                <option value="M">M</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Select unit</p>
                        </div>
                    </div>
                </div>

                    <!-- Description -->
                    <div>
                        <label for="portfolioDescription" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea id="portfolioDescription" name="portfolioDescription" rows="5" maxlength="150"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none transition"
                                placeholder="Write about your portfolio..." 
                                oninput="updateCharCount(this)"></textarea>
                        <!-- Character Count -->
                        <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                            <span id="charCount">0 / 150</span>
                            <span id="errorMessage" class="text-red-600 hidden">Maximum 150 characters allowed</span>
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
                            @foreach($artCategoriesMaster as $artCategorie)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="category-checkbox w-4 h-4 text-indigo-600 focus:ring-indigo-500"
                                    name="category_art[]" value="{{ $artCategorie->ART_CATEGORY_MASTER_ID }}">
                                <span class="text-gray-700">{{ $artCategorie->DESCR }}</span>
                            </label>
                            @endforeach
                        </div>
                        <span id="portfolioCategoryError" class="text-red-600 text-sm hidden">You can select up to 6 categories only.</span>
                    </div>
                </div>
            </div>

                <!-- Right Section: Image Upload -->
                <div class="space-y-4">
                    <!-- Image Upload Options -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Image Upload Option</label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="imageOption" value="link" x-model="uploadOption" class="mr-2" checked>
                                <span>Image URL</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="imageOption" value="file" x-model="uploadOption" class="mr-2">
                                <span>Upload New File</span>
                            </label>
                        </div>
                    </div>

                    <!-- Image URL Field -->
                    <div x-show="uploadOption === 'link'" class="transition duration-300">
                        <label for="portfolioImageLink" class="block text-sm font-semibold text-gray-700 mb-1">Image URL</label>
                        <input type="text" name="portfolioImageLink" id="portfolioImageLink" placeholder="Enter Image URL" 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                               x-model="imagePreview" @input="imagePreview = $event.target.value">
                        <span id="portfolioImageLinkError" class="text-red-600"></span>
                    </div>

                    <!-- File Upload Field -->
                    <div x-show="uploadOption === 'file'" class="transition duration-300">
                        <label for="portfolioImageUpload" class="block text-sm font-semibold text-gray-700 mb-1">Upload Image</label>
                        <input type="file" name="portfolioImageUpload" id="portfolioImageUpload" accept="image/*" 
                               @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <span id="portfolioImageUploadError" class="text-red-600"></span>
                    </div>

                    <!-- Image Preview -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Image Preview</p>
                        <img :src="imagePreview" alt="Image Preview" 
                             class="w-full h-64 object-cover rounded-lg border">
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 border-t pt-4">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Cancel</button>
                <button type="submit" 
                        class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">Add Portfolio</button>
            </div>
        </form>
    </div>
</div>

<!-- Success Modal -->
@if(session('status'))
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg text-center success-modal">
        <i class="fas fa-check-circle text-indigo-600 text-5xl mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-800">Success!</h2>
        <p class="text-gray-600 mt-2">{{ session('status') }}</p>
        <div class="mt-6 flex justify-center space-x-4">
            <button onclick="closeSuccessModal()" class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-400 transition duration-200">Cancel</button>
    </div>
</div>
@endif


<script>
    function openModal() {
        document.getElementById('addPortfolioModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addPortfolioModal').classList.add('hidden'); // Hide the modal
        clearErrorsAndForm(); // Clear errors and reset the form
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.add('hidden'); // Hide the modal
        clearErrorsAndForm(); // Clear errors and reset the form
    }

    function updateCharCount(textarea) {
        const maxLength = 150;
        const charCount = textarea.value.length;

        const charCountSpan = document.getElementById('charCount');
        const errorMessage = document.getElementById('errorMessage');

        charCountSpan.textContent = `${charCount} / ${maxLength}`;

        if (charCount > maxLength) {
            errorMessage.classList.remove('hidden');
            textarea.value = textarea.value.substring(0, maxLength); // Truncate excess characters
            charCountSpan.textContent = `${maxLength} / ${maxLength}`;
        } else {
            errorMessage.classList.add('hidden');
        }
    }

    function clearErrorsAndForm() {
        // Clear error messages
        document.getElementById('portfolioTitleError').textContent = '';
        document.getElementById('portfolioDescriptionError').textContent = '';
        document.getElementById('portfolioCategoryError').textContent = '';
        document.getElementById('portfolioImageLinkError').textContent = '';
        document.getElementById('portfolioImageUploadError').textContent = '';

        // Reset the form
        document.getElementById('addPortfolioForm').reset();
    }

    function toggleCategorySelection() {
        const categorySelection = document.getElementById('categorySelection');
        categorySelection.classList.toggle('hidden');
    }

    function toggleImageUploadOption(option) {
        const linkField = document.getElementById('linkField');
        const fileField = document.getElementById('fileField');
        const portfolioImageLink = document.getElementById('portfolioImageLink');
        const portfolioImageUpload = document.getElementById('portfolioImageUpload');

        if (option === 'link') {
            // Show link field and hide file field
            linkField.classList.remove('hidden');
            fileField.classList.add('hidden');

            // Add required to link input and remove from file input
            portfolioImageLink.setAttribute('required', 'true');
            portfolioImageUpload.removeAttribute('required');
        } else if (option === 'file') {
            // Show file field and hide link field
            fileField.classList.remove('hidden');
            linkField.classList.add('hidden');

            // Add required to file input and remove from link input
            portfolioImageUpload.setAttribute('required', 'true');
            portfolioImageLink.removeAttribute('required');
        }
    }

    // Update the selected categories display
    document.querySelectorAll('.category-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(
                (checkbox) => checkbox.nextSibling.textContent.trim()
            );
            if (selectedCategories.length > 3) {
                checkbox.checked = false;
                alert('You can select up to 3 categories.');
            } else {
                document.getElementById('selectedCategories').value = selectedCategories.join(', ');
            }
        });
    });
</script>

</body>
</html>
