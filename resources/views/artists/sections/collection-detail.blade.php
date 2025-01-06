<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .modal-overlay {
            z-index: 50;
        }

        .scrollable-content {
            max-height: 300px; /* Set maximum height for scrollable area */
            overflow-y: auto; /* Enable vertical scrolling */
        }
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
<body class="container mx-auto p-6">
<!-- Back Button with Arrow Icon -->
<a href="javascript:history.back()" 
   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-300 transition duration-300 shadow-sm mt-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
    </svg>
    <span class="text-sm font-medium text-white">Back</span>
</a>
    <!-- Button to Trigger Modal -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $artsCount }} Artworks</h1>
        @if(Auth::check())
            @if (Auth::user()->USER_ID == $artist->USER_ID )
            <button onclick="openAddArtModal()" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2 rounded-full shadow-md hover:from-blue-600 hover:to-indigo-700 transition duration-300 transform hover:scale-105">
                Add Artwork Collection
            </button>
            @endif
        @endif
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Loop through the artworks -->
        @foreach($collection->ArtistCollections as $artwork)
        <div class="group relative bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border-2 border-gray-300 overflow-hidden">
            <!-- Ellipsis Button -->
            @if(Auth::check())
                @if (Auth::user()->USER_ID == $artist->USER_ID )
                <button class="ellipsisButton text-gray-600 hover:text-gray-800 focus:outline-none" onclick="toggleOptionsMenu(event, this)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5Z" />
                    </svg>
                </button>
                
                <!-- Options Menu -->
                <div class="optionsMenu">
                    <button class="block w-full text-left px-4 py-2 hover:bg-gray-100" onclick="confirmDeleteArtwork({{ $artwork->ART_COLLECTION_ID }},'{{ $artwork->Art->ART_TITLE }}')" >Delete from this collection</button>
                </div>
                @endif
            @endif
            <!-- Artwork Image with Hover Effect -->
            <a href="{{ route('artwork.show', $artwork->ART_ID) }}">
                <img src="{{ Str::startsWith($artwork->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($artwork->Art->ArtImages()->first()->IMAGE_PATH) : $artwork->Art->ArtImages()->first()->IMAGE_PATH }}" alt="{{ $artwork->Art->ART_TITLE }}"
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
                <h2 class="text-lg font-bold mt-2 text-gray-900">{{ $artwork->Art->ART_TITLE }}</h2>
                <p class="text-gray-600 text-sm">{{ $artwork->Art->MasterUser->USERNAME }}</p>
                {{-- <p class="text-gray-500 text-sm">{{ $artwork['gallery'] }}</p> --}}
                @if ($artwork->Art->IS_SALE == 1)
                <p class="text-indigo-600 text-lg font-semibold mt-2">Rp.{{ $artwork->Art->PRICE }}</p>
                @else
                <p class="text-indigo-600 text-lg font-semibold mt-2">Not For Sale</p>
                @endif
            </div>

            <!-- Button that appears on hover -->
            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <a href="{{ route('artwork.show', $artwork->ART_ID) }}"
                    class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition-colors duration-300">
                    View Details
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add Artwork Collection Modal -->
    <div id="addArtModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-6">
            
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Add Artwork Collection</h2>
                <button class="text-gray-600 hover:text-gray-800 focus:outline-none" id="x-button">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <!-- Modal Description -->
            <p class="text-gray-600 mb-4">Select the art pieces you want to include in this collection.</p>

            <form id="addArtToCollection" method="POST" action="{{ route('collection.addArt',['collectionId' => $collection->ARTIST_COLLECTION_ID]) }}">
            @csrf
            @method('PUT')
                <!-- Art Selection Grid with Scroll -->
                <div class="scrollable-content grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Art Item Example -->
                    @foreach ($artsWithoutCollections as $artwork)
                    <div class="relative group border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300" data-artwork-id="{{ $artwork->ART_ID }}">
                        <img src="{{ Str::startsWith($artwork->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($artwork->ArtImages()->first()->IMAGE_PATH) : $artwork->ArtImages()->first()->IMAGE_PATH }}" alt="Artwork {{ $artwork->ART_TITLE }}" class="w-full h-48 object-cover">
                        <div class="absolute top-2 left-2">
                            <!-- Add a meaningful ID or name if necessary -->
                            <input 
                                    type="checkbox" 
                                    class="w-6 h-6 text-indigo-500 focus:ring focus:ring-indigo-300" 
                                    value="{{ $artwork->ART_ID }}" 
                                    name="artworks[]"
                                >
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end mt-6 space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition duration-300 transform hover:scale-105">
                        Add Selected Art
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center modal-overlay hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Delete</h2>
        <p class="text-gray-600 mb-6">Are you sure you want to delete "<span id="artNameSpan"></span>" from this collection?</p>
        <div class="flex justify-end space-x-3">
            <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition" onclick="closeDeleteModal()">Cancel</button>
            <a id="deleteFromCollectionButton" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Delete</a>
        </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Function to close the delete confirmation modal
        function closeDeleteModal() {
            document.getElementById('deleteConfirmationModal').classList.add('hidden'); // Hide modal
        }

        document.getElementById('x-button').addEventListener('click', () => {
            document.getElementById('addArtModal').classList.add('hidden');
        });

        document.getElementById('cancel-add-art-button').addEventListener('click', () => {
            document.getElementById('addArtModal').classList.add('hidden');
        });

        // Open Add Art Modal
        function openAddArtModal() {
            document.getElementById('addArtModal').classList.remove('hidden');
        }

        // Close Add Art Modal
        function closeAddArtModal() {
            document.getElementById('addArtModal').classList.add('hidden');
            clearSelection();
        }

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

        // Show delete confirmation (simple alert for demonstration)
        function confirmDeleteArtwork($id, $name) {
            document.getElementById('deleteConfirmationModal').classList.remove('hidden');
            document.getElementById('artNameSpan').innerHTML = $name;

            let deleteCollectionRoute = "{{ route('artCollection.delete', ['artCollectionId' => 'COLLECTION_ID']) }}";
            document.getElementById('deleteFromCollectionButton').href = deleteCollectionRoute.replace('COLLECTION_ID', $id);
        }

        // Declare selectedArtworks globally
        let selectedArtworks = []; // To keep track of selected artworks

        // Handle artwork selection
        document.querySelectorAll('#addArtModal .scrollable-content input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const artworkCard = this.closest('.relative'); // Find the parent artwork card
                const artworkId = artworkCard.getAttribute('data-artwork-id'); // Assuming artwork ID is in the data attribute

                if (this.checked) {
                    // Add artwork to the selected list if checked
                    if (!selectedArtworks.includes(artworkId)) {
                        selectedArtworks.push(artworkId);
                    }
                } else {
                    // Remove artwork from the selected list if unchecked
                    selectedArtworks = selectedArtworks.filter(id => id !== artworkId);
                }
            });
        });

        // Clear all selections
        function clearSelection() {
            document.querySelectorAll('#addArtModal .scrollable-content input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false; // Uncheck all checkboxes
            });
            selectedArtworks = []; // Clear the selected artworks array
        }

        // Function to close the modal
        function closeAddArtModal() {
            document.getElementById('addArtModal').classList.add('hidden');
            clearSelection(); // Clear selections when closing the modal
        }

        // Hide options menu when clicking outside
        document.addEventListener('click', () => {
            document.querySelectorAll('.optionsMenu').forEach(menu => menu.style.display = 'none');
        });
    </script>
</body>
</html>
