@extends('admin.admin')

@section('title', 'Upload Art Request')

@section('content')
<div class="flex-1 p-6">

    <!-- Top Section: Button and Search -->
    <div class="flex justify-between items-center mb-4">
        <!-- Search Bar -->
        <div class="flex-1 max-w-md">
            <input
                id="searchInput"
                type="text"
                placeholder="Search for Upload Art Request by Name..."
                class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none"
            />
        </div>
    </div>

    <!-- skills Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-indigo-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Title</th>
                    <th class="px-6 py-3 text-left font-semibold">Created Date</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Example Row -->
                @foreach($arts as $art)
                <tr class="hover:bg-indigo-50" data-join-name="{{ strtolower($art->ART_TITLE) }}" id="artUploadRequest" data-join-id="{{$art->ART_ID }}">
                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $art->ART_TITLE }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $art->created_at }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.artRequest.showDetail',['id'=>$art->ART_ID]) }}" class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 items-center">
                            Review Art
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

<!-- JavaScript for Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchText = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const buyerName = row.getAttribute('data-join-name');

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
