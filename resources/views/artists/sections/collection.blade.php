<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
     .collection-card {
      position: relative;
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
      right: 16px;
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
<body class="bg-gray-100">
  <div class="max-w-screen-lg mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
      <h3 class="text-3xl font-extrabold text-gray-800">Collections</h3>
      @if(Auth::check())
        @if (Auth::user()->USER_ID == $artist->USER_ID)
          <button id="addCollectionButton" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2 rounded-full shadow-md hover:from-blue-600 hover:to-indigo-700 transition duration-300 transform hover:scale-105">
            + Add Collection
          </button>
        @endif
      @endif
    </div>

    <!-- Collections Grid Container -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($artist->Collections as $collection)
      <!-- Collection Item -->
      <div class="relative bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden border border-gray-200 collection-card">
        @if(Auth::check())
          @if ($artistItSelf)
          <button class="ellipsisButton text-gray-600 hover:text-gray-800 focus:outline-none" onclick="toggleOptionsMenu(event, this)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5Z" />
            </svg>
          </button>
          @endif
        @endif
        <!-- Options Menu -->
        <div class="optionsMenu">
        <button class="block w-full text-left px-4 py-2 hover:bg-gray-100 editCollectionButton" data-collection-id="{{ $collection->ARTIST_COLLECTION_ID }}" data-collection-title="{{ $collection->COLLECTION_NAME }}" data-collection-descr="{{ $collection->COLLECTION_DESCR }}">Edit Collection</button>
        <button class="block w-full text-left px-4 py-2 hover:bg-gray-100 deleteCollectionButton" data-collection-id="{{ $collection->ARTIST_COLLECTION_ID }}" data-collection-title="{{ $collection->COLLECTION_NAME }}">Delete Collection</button>
        </div>

        <img alt="Collection Image" class="w-full h-48 object-cover transform hover:scale-110 transition-transform duration-500" 
             src="{{ $collection->ArtistCollections->first() != null ? 
                (Str::startsWith($collection->ArtistCollections->first()->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? 
                asset($collection->ArtistCollections->first()->art->ArtImages()->first()->IMAGE_PATH) : 
                $collection->ArtistCollections->first()->art->ArtImages()->first()->IMAGE_PATH) : 
                'https://placehold.co/300x300'}}">
        
        <div class="p-6">
          <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $collection->COLLECTION_NAME }}</h4>
          <p class="text-gray-600 mb-4">{{ count($collection->ArtistCollections) }} Artworks</p>
          <a href="{{ route('collection.show', ['artistId' => $artist->ARTIST_ID, 'collectionId' => $collection->ARTIST_COLLECTION_ID]) }}" class="text-indigo-600 font-bold hover:underline">View Collection &rarr;</a>
        </div>
      </div>
      @endforeach
    </div>
    <!-- End of Grid Container -->
  </div>
  <!-- Add Collection Modal -->
  <div id="addCollectionModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-xl">
      <h2 class="text-3xl font-semibold text-gray-800 mb-6">Add New Collection</h2>
      <form id="addCollectionForm" method="POST" action="{{ route('collection.store') }}" class="space-y-6">
        @csrf
        <div>
            <label for="collectionTitle" class="block text-gray-700 font-semibold mb-2">Collection Title</label>
            <input type="text" id="collectionTitle" name="collectionTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" placeholder="Enter collection title" required>
            <span id="collectionTitleError" class="text-red-600"></span>
        </div>
        <div>
            <label for="collectionDescription" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea id="collectionDescription" name="collectionDescription" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" placeholder="Enter collection description" required></textarea>
            <span id="collectionDescriptionError" class="text-red-600"></span>
        </div>
        <div class="flex justify-end space-x-3">
            <button type="button" id="cancelAddCollectionButton" onclick="closeModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">Cancel</button>
            <button type="submit" id="addCollectionButton" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition duration-300 transform hover:scale-105">Add Collection</button>
        </div>
    </form>
    </div>
  </div>

  <div id="editCollectionModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-xl">
      <h2 class="text-3xl font-semibold text-gray-800 mb-6">Edit Collection</h2>
      <form id="editCollectionForm" method="POST" action="" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label for="collectionTitle" class="block text-gray-700 font-semibold mb-2">Collection Title</label>
            <input type="text" id="collectionTitleEdit" name="collectionTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" placeholder="Enter collection title" required>
        </div>
        <div>
            <label for="collectionDescription" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea id="collectionDescriptionEdit" name="collectionDescription" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" placeholder="Enter collection description" required></textarea>
        </div>
        <div class="flex justify-end space-x-3">
            <button type="button" id="cancelEditCollectionButton" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">Cancel</button>
            <button type="submit" id="editCollectionButton" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition duration-300 transform hover:scale-105">Update Collection</button>
        </div>
    </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Delete Collection</h2>
      <p class="text-gray-600 mb-6">Are you sure you want to delete <span id="collectionNameSpan"></span>?</p>
      <div class="flex justify-end space-x-3">
        <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition" onclick="closeDeleteModal()">Cancel</button>
        <a type="button" id="deleteCollectionButton" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Delete</a>
      </div>
    </div>
  </div>


  <!-- JavaScript -->
  <script>

    // Show and hide the Add Collection modal
    document.getElementById('addCollectionButton').addEventListener('click', () => {
      document.getElementById('addCollectionModal').classList.remove('hidden');
    });

    const editButtons = document.querySelectorAll('.editCollectionButton');

    // Add event listener to each button
    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        // document.getElementById('collectionIdEdit').value = this.getAttribute('data-collection-id');
        document.getElementById('collectionTitleEdit').value = this.getAttribute('data-collection-title');
        document.getElementById('collectionDescriptionEdit').value = this.getAttribute('data-collection-descr');

        let collectionId = this.getAttribute('data-collection-id');
        const form = document.getElementById("editCollectionForm");
        let updateCollectionRoute = "{{ route('collection.update', ['collectionId' => 'COLLECTION_ID']) }}";
        form.action = updateCollectionRoute.replace('COLLECTION_ID', collectionId);

        document.getElementById('editCollectionModal').classList.remove('hidden');
      });
    });

    const deleteButtons = document.querySelectorAll('.deleteCollectionButton');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        document.getElementById('collectionNameSpan').innerHTML = '"'+this.getAttribute('data-collection-title')+'"';
        let deleteCollectionRoute = "{{ route('collection.delete', ['collectionId' => 'COLLECTION_ID']) }}";
        document.getElementById('deleteCollectionButton').href = deleteCollectionRoute.replace('COLLECTION_ID', this.getAttribute('data-collection-id'))
        document.getElementById('deleteConfirmationModal').classList.remove('hidden');
      });
    });

    // document.getElementById('editCollectionButton').addEventListener('click', (event) => {
    //   const button = event.target;
    //   console.log('Collection ID:', button.dataset.collectionId);
      
    //   console.log('Collection Name:', button.dataset.collectionTitle);
      
    //   console.log('Collection Description:', button.dataset.collectionDescr);
      

    //   document.getElementById('editCollectionModal').classList.remove('hidden');
    // });

    document.getElementById('cancelEditCollectionButton').addEventListener('click', () => {
      document.getElementById('editCollectionModal').classList.add('hidden');
    });

    function closeModal() {
      document.getElementById('addCollectionModal').classList.add('hidden'); // Hide the modal
      clearErrorsAndForm(); // Clear errors and reset the form
    }

    function clearErrorsAndForm() {
        // Clear error messages
        document.getElementById('collectionTitleError').textContent = '';
        document.getElementById('collectionDescriptionError').textContent = '';

        // Reset the form
        document.getElementById('addCollectionForm').reset();
    }

      // Toggle visibility of link or file upload field based on radio selection
      function toggleImageUploadOption(option) {
      document.getElementById('linkField').classList.toggle('hidden', option !== 'link');
      document.getElementById('fileField').classList.toggle('hidden', option !== 'file');
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

    let collectionToDelete = null;

    // Function to open the delete confirmation modal
    function confirmDeleteCollection(event, collectionName) {
        event.stopPropagation(); // Prevent triggering other events (e.g., opening the post)
        collectionToDelete = collectionName; // Set the ID of the post to delete
        document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show modal
    }

    // Function to close the delete confirmation modal
    function closeDeleteModal() {
        document.getElementById('deleteConfirmationModal').classList.add('hidden'); // Hide modal
        collectionToDelete = null; // Clear the stored post ID
    }

    // Function to delete the post via AJAX

    // // Show delete confirmation modal
    // function confirmDeleteCollection(event) {
    //   event.stopPropagation();
    //   document.getElementById('deleteConfirmationModal').classList.remove('hidden');
    // }

    // Hide delete confirmation modal
    function closeDeleteModal() {
      document.getElementById('deleteConfirmationModal').classList.add('hidden');
    }

    

    // Hide options menu when clicking outside
    document.addEventListener('click', () => {
      document.querySelectorAll('.optionsMenu').forEach(menu => menu.style.display = 'none');
    });

    //
  </script>
</body>
</html>
