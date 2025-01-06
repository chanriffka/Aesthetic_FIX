<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .ellipsisButton {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            padding: 6px;
            z-index: 10;
        }
        .optionsMenu {
            position: absolute;
            top: 40px;
            right: 8px;
            background-color: white;
            border: 1px solid #e5e7eb;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 8px;
            width: 120px;
            display: none;
            z-index: 20;
        }
        .modal-overlay {
            z-index: 50;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="container mx-auto p-6">
        <!-- Description Section -->

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">{{ count($artworks) }} Artworks</h1>
            @if(Auth::check())
                @if (Auth::user()->USER_ID == $artistUserId )
                <button id="addArtworkButton" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2 rounded-full shadow-md hover:from-blue-600 hover:to-indigo-700 transition duration-300 transform hover:scale-105">
                    + Add Artwork
                </button>
                @endif
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Loop through the artworks -->
            @foreach($artworks as $artwork => $listArtWorks)
            <div class="group relative bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-2 border-gray-300 overflow-hidden" id="artistArtWork" data-artwork-id="{{ $listArtWorks->ART_ID}}" data-delete-route="{{ route('artwork.destroy', $listArtWorks->ART_ID) }}">
                <!-- Ellipsis Button -->
                <button class="ellipsisButton text-gray-600 hover:text-gray-800 focus:outline-none" onclick="toggleOptionsMenu(event, this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5Z" />
                    </svg>
                </button>
                <!-- Options Menu -->
                <div class="optionsMenu">
                    <button class="block w-full text-left px-4 py-2 hover:bg-gray-100">Edit Art</button>
                    <button class="block w-full text-left px-4 py-2 hover:bg-gray-100" onclick="confirmDeleteArtWork(event,{{ $listArtWorks->ART_ID }})">Delete Art</button>
                </div>

                <!-- Artwork Image with Hover Effect -->
                <a href="{{ route('artwork.show', $listArtWorks->ART_ID) }}">
                    <img src="{{ asset($listArtWorks->IMAGE_PATH) }}" alt="{{ $listArtWorks->ART_TITLE }}"
                        class="w-full h-64 object-cover rounded-t-lg transition-transform duration-300 transform group-hover:scale-105">
                </a>
                
                <div class="p-6">
                    <!-- Increased Interest Badge -->
                    {{-- @if($artwork['interest'])
                    <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                        Increased Interest
                    </span>
                    @endif --}}
                    <!-- Artwork Info -->
                    <h2 class="text-lg font-bold mt-2 text-gray-900">{{ $listArtWorks->USERNAME }}</h2>
                    <p class="text-gray-600 text-sm">{{ $listArtWorks->ART_TITLE }}, {{ $listArtWorks->ART_YEAR }}</p>
                    {{-- <p class="text-gray-500 text-sm">{{ $artwork['gallery'] }}</p> --}}
                    @if ($listArtWorks->IS_SALE == 1)
                    <p class="text-indigo-600 text-lg font-semibold mt-2">Rp.{{ $listArtWorks->ART_PRICE }}</p>
                    @else
                    <!-- Portfolio Badge -->
                    <p class="mt-2">
                        <span class="absolute top-2 left-2 bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                            Portfolio
                        </span>
                    </p>
                    @endif
                </div>

                <!-- Button that appears on hover -->
                <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="{{ route('artwork.show', $listArtWorks->ART_ID) }}"
                        class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors duration-300">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

<!-- Add Artwork Modal -->
<div id="addArtworkModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-3xl">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Add New Artwork 🎨 </h2>
            <form id="addArtWorkForm" class="grid grid-cols-2 gap-4" method="POST" action="{{ route('artwork.store') }}" enctype="multipart/form-data" id="addArtWorkForm">
                @csrf
                <div class="col-span-2">
                    <label for="artWorkTitle" class="block text-gray-700 font-semibold mb-1">Title of Art</label>
                    <input type="text" id="artWorkTitle" name="artWorkTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition" placeholder="Enter art title">
                    <span id="artWorkTitleError" class="text-red-600"></span>
                </div>
                <!-- Category Field -->
                <div class="col-span-2">
                    <label class="block text-lg font-semibold text-gray-700">Category</label>
                    <div class="flex items-center">
                        <input type="text" id="selectedCategories" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Select categories (max 6)">
                        <button type="button" onclick="toggleCategorySelection()" class="ml-3 text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <!-- Category Selection Modal -->
                <div id="categorySelection" class="hidden mt-4 col-span-2">
                    <h3 class="text-gray-700 font-semibold mb-2">Select Categories</h3>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach($artCategoryMaster as $artCategoryMaster => $listArtCategoryMaster)
                        <label><input type="checkbox" class="category-checkbox" name="category_art[]" value="{{ $listArtCategoryMaster->ART_CATEGORY_MASTER_ID }}"> {{ $listArtCategoryMaster->DESCR }}</label>
                        @endforeach
                    </div>
                </div>
                <span id="artWorkCategoryError" class="text-red-600"></span>
                <div class="col-span-2">
                    <label for="artWorkDescription" class="block text-gray-700 font-semibold mb-1">Description</label>
                    <textarea id="artWorkDescription" name="artWorkDescription" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition" placeholder="Enter art description"></textarea>
                    <span id="artWorkDescriptionError" class="text-red-600"></span>
                </div>
                <div>
                    <label for="artWorkPrice" class="block text-gray-700 font-semibold mb-1">Price</label>
                    <input type="text" id="artWorkPrice" name="artWorkPrice" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition" placeholder="Enter price">
                    <span id="artWorkPriceError" class="text-red-600"></span>
                </div>
                <!-- Image Upload Options -->
                <div class="col-span-2">
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Select Image Upload Option</label>
                    <div class="flex items-center mb-4">
                        <input type="radio" id="linkOption" name="imageOption" value="link" class="mr-3" onclick="toggleImageUploadOption('link')" checked>
                        <label for="linkOption" class="text-gray-700">Upload by Link</label>
                    </div>
                    <div class="flex items-center mb-4">
                        <input type="radio" id="fileOption" name="imageOption" value="file" class="mr-3" onclick="toggleImageUploadOption('file')">
                        <label for="fileOption" class="text-gray-700">Upload from File</label>
                    </div>
                </div>

                <!-- Image Upload Fields -->
                <div id="linkField" class="col-span-2">
                    <label for="artWorkImageLink" class="block text-lg font-semibold text-gray-700">Image URL</label>
                    <input type="text" id="artWorkImageLink" name="artWorkImageLink" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <span id="artWorkImageLinkError" class="text-red-600"></span>
                </div>
                <div id="fileField" class="mb-4 hidden">
                    <label for="artWorkImageUpload" class="block text-lg font-semibold text-gray-700">Upload Image</label>
                    <input type="file" id="artWorkImageUpload" name="artWorkImageUpload" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <span id="artWorkImageUploadError" class="text-red-600"></span>
                </div>
                <div class="col-span-2 flex justify-end mt-4">
                    <button type="button" id="cancelAddArtworkButton" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">Cancel</button>
                    <button type="submit" onclick="submitArtWork(event)" class="ml-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition duration-300 transform hover:scale-105">Add Artwork</button>
                </div>   
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
  <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Delete ArtWork</h2>
      <p class="text-gray-600 mb-6">Are you sure you want to delete this ArtWork?</p>
      <div class="flex justify-end space-x-3">
        <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition" onclick="closeDeleteModal()">Cancel</button>
        <button type="button" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition" onclick="deleteArtWork()">Delete</button>
      </div>
    </div>
  </div>

    <!-- JavaScript -->
    <script>
        // Show and hide the Add Artwork modal
        document.getElementById('addArtworkButton').addEventListener('click', () => {
            document.getElementById('addArtworkModal').classList.remove('hidden');
        });

        document.getElementById('cancelAddArtworkButton').addEventListener('click', () => {
            document.getElementById('addArtworkModal').classList.add('hidden');
        });

        // Toggle options menu visibility for each ellipsis button
        function toggleOptionsMenu(event, button) {
            event.stopPropagation();
            document.querySelectorAll('.optionsMenu').forEach(menu => {
                if (menu !== button.nextElementSibling) {
                    menu.style.display = 'none';
                }
            });
            const optionsMenu = button.nextElementSibling;
            optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
        }

        // // Show delete confirmation (simple alert for demonstration)
        // function confirmDeleteArtwork() {
        //     if (confirm("Are you sure you want to delete this artwork?")) {
        //         alert("Artwork deleted!");
        //         // Additional delete logic can be added here
        //     }
        // }

        let artWorkToDelete = null;

        // Function to open the delete confirmation modal
        function confirmDeleteArtWork(event, artWorkId) {
            event.stopPropagation(); // Prevent triggering other events (e.g., opening the post)
            artWorkToDelete = artWorkId; // Set the ID of the post to delete
            document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show modal
        }

        // Function to close the delete confirmation modal
        function closeDeleteModal() {
            document.getElementById('deleteConfirmationModal').classList.add('hidden'); // Hide modal
            artWorkToDelete = null; // Clear the stored post ID
        }

        // Function to delete the post via AJAX
        function deleteArtWork() {
            if (!artWorkToDelete) return; // Ensure there's a post to delete
            

            // Get the delete route from the data attribute
            console.log('artWorkToDelete:', artWorkToDelete); // Check the value of artWorkToDelete
            const artWorkElement = document.querySelector(`#artistArtWork[data-artwork-id="${artWorkToDelete}"]`);
            console.log('artWorkElement:', artWorkElement); // Verify the element exists
            const url = artWorkElement.dataset.deleteRoute; // Get the route from the data attribute

            console.log('Delete URL:', url); // Log the URL to verify it's correct

            // Send AJAX request
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to delete the artwork.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    artWorkElement.remove(); // Remove the post from the DOM
                    closeDeleteModal(); // Close the modal
                    alert('artwork deleted successfully.');
                } else {
                    alert('Failed to delete the artwork.');
                }
            })
            .catch(error => {
                console.error('Error deleting artwork:', error);
                alert('An error occurred while deleting the artwork.');
            });
        }

        // Hide options menu when clicking outside
        document.addEventListener('click', () => {
            document.querySelectorAll('.optionsMenu').forEach(menu => menu.style.display = 'none');
        });


    function clearErrorsAndForm() {
        // Clear error messages
        document.getElementById('artWorkTitleError').textContent = '';
        document.getElementById('artWorkDescriptionError').textContent = '';
        document.getElementById('artWorkCategoryError').textContent = '';
        document.getElementById('artWorkPriceError').textContent = '';
        document.getElementById('artWorkImageLinkError').textContent = '';
        document.getElementById('artWorkImageUploadError').textContent = '';

        // Reset the form
        document.getElementById('addArtWorkForm').reset();
    }

    function toggleCategorySelection() {
        const categorySelection = document.getElementById('categorySelection');
        categorySelection.classList.toggle('hidden');
    }

    function toggleImageUploadOption(option) {
        document.getElementById('linkField').classList.toggle('hidden', option !== 'link');
        document.getElementById('fileField').classList.toggle('hidden', option !== 'file');
    }

    function submitArtWork(event) {
        event.preventDefault(); // Prevent traditional form submission

        // Clear previous error messages
        document.getElementById('artWorkTitleError').textContent = '';
        document.getElementById('artWorkDescriptionError').textContent = '';
        document.getElementById('artWorkCategoryError').textContent = '';
        document.getElementById('artWorkPriceError').textContent = '';
        document.getElementById('artWorkImageLinkError').textContent = '';
        document.getElementById('artWorkImageUploadError').textContent = '';

        // Get the form and form data
        const form = document.getElementById('addArtWorkForm');
        const formData = new FormData(form);

        // Get the selected image option
        const imageOption = formData.get('imageOption'); // "file" or "link"

        // Send AJAX request
        fetch('{{ route('artwork.store') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw err; // Throw JSON error
                    });
                }
                return response.json();
            })
            .then(data => {
                // Success handling
                if (data.success) {
                    location.reload(); // Reload the page to reflect changes
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error.errors) {
                    // Display validation errors dynamically
                    if (error.errors.artWorkTitle) {
                        document.getElementById('artWorkTitleError').textContent = error.errors.artWorkTitle[0];
                    }
                    if (error.errors.artWorkDescription) {
                        document.getElementById('artWorkDescriptionError').textContent = error.errors.artWorkDescription[0];
                    }
                    if (error.errors.artWorkPrice) {
                        document.getElementById('artWorkPriceError').textContent = error.errors.artWorkPrice[0];
                    }
                    if (error.errors.category_art) {
                        document.getElementById('artWorkCategoryError').textContent = error.errors.category_art[0];
                    }
                    if (error.errors.artWorkImageUpload && imageOption === 'file') {
                        document.getElementById('artWorkImageUploadError').textContent = error.errors.artWorkImageUpload[0];
                    }
                    if (error.errors.artWorkImageLink && imageOption === 'link') {
                        document.getElementById('artWorkImageLinkError').textContent = error.errors.artWorkImageLink[0];
                    }
                } else {
                    alert('An unexpected error occurred. Please try again later.');
                }
            });
    }

    // Update the selected categories display
    document.querySelectorAll('.category-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(
                (checkbox) => checkbox.nextSibling.textContent.trim()
            );
            if (selectedCategories.length > 6) {
                checkbox.checked = false;
                alert('You can select up to 6 categories.');
            } else {
                document.getElementById('selectedCategories').value = selectedCategories.join(', ');
            }
        });
    });
    </script>
</body>
</html>
