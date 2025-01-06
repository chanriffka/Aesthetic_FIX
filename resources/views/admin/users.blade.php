@extends('admin.admin')

@section('title', 'Users')

@section('content')
<div class="flex-1 p-6">
    <!-- Search and Controls -->
    <div class="flex items-center mb-4">
        <!-- Search Bar -->
        <input
            type="text"
            placeholder="Search for users..."
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
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-indigo-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">
                        <input type="checkbox" />
                    </th>
                    <th class="px-6 py-3 text-left font-semibold">Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Phone</th>
                    <th class="px-6 py-3 text-left font-semibold">Role</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Example User Rows -->
                <tr class="hover:bg-indigo-50">
                    <td class="px-6 py-4">
                        <input type="checkbox" />
                    </td>
                    <td class="px-6 py-4 flex items-center">
                        <img
                            src="https://placehold.co/40x40"
                            alt="Avatar"
                            class="w-10 h-10 rounded-full mr-3"
                        />
                        <div>
                            <p class="font-semibold text-gray-800">Neil Sims</p>
                            <p class="text-gray-500">neil.sims@flowbite.com</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">+62877446345</td>
                    <td class="px-6 py-4 text-gray-500">ARTIST</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full"
                        >
                            Active
                        </span>
                    </td>
                    <td class="px-6 py-4 flex space-x-2">
                        <button class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Deactive Account
                        </button>
                    </td>
                </tr>
                <!-- Repeat for additional users -->
                <td class="px-6 py-4">
                        <input type="checkbox" />
                    </td>
                    <td class="px-6 py-4 flex items-center">
                        <img
                            src="https://placehold.co/40x40"
                            alt="Avatar"
                            class="w-10 h-10 rounded-full mr-3"
                        />
                        <div>
                            <p class="font-semibold text-gray-800">Cacaoooo</p>
                            <p class="text-gray-500">cacao@email.com</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">+62877446345</td>
                    <td class="px-6 py-4 text-gray-500">BUYER</td>
                    <td class="px-6 py-4">
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full"
                        >
                            Inactive
                        </span>
                    </td>
                    <td class="px-6 py-4 flex space-x-2">
                        <button class="px-3 py-1 bg-green-500 text-white rounded-md hover:bg-green-600">
                            Active Account
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
            <p class="text-sm text-gray-500">Showing 1-10 of 50</p>
            <div class="flex space-x-2">
                <button class="px-3 py-1 bg-gray-200 text-gray-600 rounded-md hover:bg-gray-300">
                    Previous
                </button>
                <button class="px-3 py-1 bg-gray-200 text-gray-600 rounded-md hover:bg-gray-300">
                    Next
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
