@extends('admin.admin')

@section('title', 'Category')

@section('content')
<div class="flex-1 p-6">

    <!-- Top Section: Button and Search -->
    <div class="flex justify-between items-center mb-4">
        <!-- Add New Category Button -->
        <div>
            <button id="openModalButton" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">
                Add new category
            </button>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 max-w-md">
            <input
                id="searchInput"
                type="text"
                placeholder="Search for categories..."
                class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
            />
        </div>
    </div>

    <!-- Category Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-indigo-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Category Art Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Number of Artworks</th>
                    <th class="px-6 py-3 text-left font-semibold">Created Date</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Example Row -->
                @foreach($categories as $category)
                <tr class="hover:bg-indigo-50" data-category-name = "{{ strtolower($category->DESCR ) }}" id="categoryArt" data-category-id="{{$category->ART_CATEGORY_MASTER_ID }}">
                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $category->DESCR }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $category->ArtCategories->count() }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $category->created_at }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <button onclick="openEditCategoryModal(event,{{$category->ART_CATEGORY_MASTER_ID }})" data-category-id="{{ $category->ART_CATEGORY_MASTER_ID }}" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 items-center">
                            Edit 
                        </button>
                        <a href="{{ route('admin.category.destroy',['id'=>$category->ART_CATEGORY_MASTER_ID]) }}" onclick="return confirm('Are you sure you want to delete the category?');" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 items-center">
                            Delete 
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
           
        </div>
    </div>
</div>

<!-- Modal for Adding Category -->
<div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-sm">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Add New Category</h3>
            <button id="closeModalButton" class="text-gray-500 hover:text-red-600 text-2xl focus:outline-none">
                &times;
            </button>
        </div>

        <!-- Modal Form -->
        <form action="{{ route('admin.category.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="category-name" class="block text-sm font-medium text-gray-700 mb-2">
                    Category Name
                </label>
                <input
                    type="text"
                    id="category-name"
                    name="DESCR"
                    placeholder="Enter category name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required
                />
            </div>

            <!-- Modal Actions -->
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelButton" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-sm">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Edit Category</h3>
            <button id="closeModalButton" onclick="closeEditCategoryModal()" class="text-gray-500 hover:text-red-600 text-2xl focus:outline-none">
                &times;
            </button>
        </div>

        <!-- Modal Form -->
        <form id="editArtCategoryForm" method="POST">
            @csrf
            <div class="mb-6">
                <label for="category-name" class="block text-sm font-medium text-gray-700 mb-2">
                    Category Name
                </label>
                <input
                    type="text"
                    id="category-name-edit"
                    name="DESCREdit"
                    placeholder="Enter category name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                    required
                />
            </div>

            <!-- Modal Actions -->
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelButton" onclick="closeEditCategoryModal()" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for Modal -->
<script>
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const cancelButton = document.getElementById('cancelButton');
    const modal = document.getElementById('modal');

    // Open Modal
    openModalButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    // Close Modal
    closeModalButton.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    cancelButton.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Close modal if clicking outside content
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const buyerName = row.getAttribute('data-category-name');

                if (buyerName.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);

        
    });

    async function openEditCategoryModal(event,categoryId){
        const modal = document.getElementById('editCategoryModal');
        if (modal) {
            modal.classList.remove('hidden');
            try{
                const categoryElement = document.querySelector(`#categoryArt[data-category-id="${categoryId}"]`);
                const response = await fetch(`/admin/category/${categoryId}`);
                if (!response.ok) throw new Error('Failed to fetch artist profile');
                const data = await response.json();

                console.log('Fetched post data:', data);

                document.getElementById('category-name-edit').value = data.DESCR || '';

                const form = document.getElementById('editArtCategoryForm'); // Assuming your form has this ID
                form.action = `/admin/category/updateCategory/${categoryId}`; //
            } catch (error) {
                console.error('Error fetching category data:', error);
                alert('Could not load category data. Please try again.');
                modal.style.display = 'none'; // Hide modal if fetching data fails
            }
        }
    }

    function closeEditCategoryModal(){
        const modal = document.getElementById('editCategoryModal');
        if (modal) {
            modal.classList.add('hidden');
            const form = modal.querySelector('form');
            if (form) {
                form.reset(); // Clears form inputs
            }

            // Clear validation error messages (if you have them)
            const errorMessages = modal.querySelectorAll('.error-message');
            errorMessages.forEach(error => error.textContent = '');
        }
    }
</script>
@endsection
