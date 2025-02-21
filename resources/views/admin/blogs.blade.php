@extends('admin.admin')

@section('title', 'Blogs')

@section('content')
<div class="flex-1 p-6">

    <!-- Top Section: Button and Search -->
    <div class="flex justify-between items-center mb-4">
        <!-- Add New skills Button -->
        <div>
            <a href="{{ route('admin.blog.create') }}" class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700">
                Add new blogs
            </a>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 max-w-md">
            <input
                id="searchInput"
                type="text"
                placeholder="Search for Blogs..."
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
                    <th class="px-6 py-3 text-left font-semibold">View</th>
                    <th class="px-6 py-3 text-left font-semibold">Created Date</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Example Row -->
                @foreach($blogs as $blog)
                <tr class="hover:bg-indigo-50" data-join-name="{{ strtolower($blog->TITLE) }}" id="blog" data-join-id="{{$blog->BLOG_ID }}">
                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $blog->TITLE }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $blog->VIEW }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $blog->created_at }}</td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('blog.preview',['slug'=>$blog->SLUG]) }}" class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 items-center">
                            Preview 
                        </a>
                        <a href="{{ route('admin.blog.edit',['id'=>$blog->BLOG_ID]) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 items-center">
                            Edit 
                        </a>
                        <a href="{{ route('admin.blog.destroy',['id'=>$blog->BLOG_ID]) }}" onclick="return confirm('Are you sure you want to delete the blog?');" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 items-center">
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
