@extends('admin.admin')

@section('title', 'Buyers')

@section('content')
<div class="flex-1 p-6">
    <!-- Search and Controls -->
    <div class="flex items-center mb-4">
        <!-- Search Bar -->
        <input
            id="searchInput"
            type="text"
            placeholder="Search for Buyer..."
            class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
        />

        <!-- Controls -->
        <div class="flex items-center space-x-3 ml-4">
            <button class="text-gray-600 hover:text-indigo-600">
                <i class="fas fa-cog"></i>
            </button>
            <button class="text-gray-600 hover:text-indigo-600">
                <i class="fas fa-trash"></i>
            </button>
            <button class="text-gray-600 hover:text-indigo-600">
                <i class="fas fa-exclamation-circle"></i>
            </button>
            <button class="text-gray-600 hover:text-indigo-600">
                <i class="fas fa-ellipsis-h"></i>
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <!-- Table Container -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full table-auto text-sm">
        <thead class="bg-indigo-100 text-gray-700">
            <tr>
                <th class="px-6 py-3 text-left font-semibold">Name</th>
                <th class="px-6 py-3 text-left font-semibold">Phone</th>
                <th class="px-6 py-3 text-left font-semibold">Status</th>
                <th class="px-6 py-3 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($buyers as $buyer)
            <tr class="hover:bg-indigo-50" data-buyer-name="{{ strtolower($buyer->FULLNAME) }}">
                <td class="px-6 py-4 flex items-center">
                    <img src="{{ $buyer->PROFILE_IMAGE_URL != null ? asset($buyer->PROFILE_IMAGE_URL) : 'https://placehold.co/100x100' }}" 
                         alt="{{ $buyer->FULLNAME }}"
                         class="w-10 h-10 rounded-full mr-3" />
                    <div>
                        <p class="font-semibold text-gray-800">{{ $buyer->FULLNAME }}</p>
                        <p class="text-gray-500">{{ $buyer->MasterUser->EMAIL }}</p>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-500">{{ $buyer->PHONE_NUMBER }}</td>
                <td class="px-6 py-4">
                    @if($buyer->isActive())
                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                        Active
                    </span>
                    @else
                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                        Inactive
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('admin.buyer.activate', ['id' => $buyer->BUYER_ID]) }}" 
                       class="px-3 py-1 text-white rounded-md
                              @if($buyer->isActive()) bg-red-500 hover:bg-red-600 @else bg-green-500 hover:bg-green-600 @endif">
                        @if($buyer->isActive())
                            Deactivate Account
                        @else
                            Activate Account
                        @endif
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
        {{-- <p class="text-sm text-gray-500">Showing 1-10 of 50</p>
        <div class="flex space-x-2">
            <button class="px-3 py-1 bg-gray-200 text-gray-600 rounded-md hover:bg-gray-300">
                Previous
            </button>
            <button class="px-3 py-1 bg-gray-200 text-gray-600 rounded-md hover:bg-gray-300">
                Next
            </button>
        </div> --}}
    </div>
</div>
</div>
<!-- JavaScript for Search Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const buyerName = row.getAttribute('data-buyer-name');

                if (buyerName.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);
    });
</script>
@endsection
