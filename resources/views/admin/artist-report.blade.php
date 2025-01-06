@extends('admin.admin')

@section('title', 'Artists')

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
                        #
                    </th>
                    <th class="px-6 py-3 text-left font-semibold">Date & Time</th>
                    <th class="px-6 py-3 text-left font-semibold">Artist</th>
                    <th class="px-6 py-3 text-left font-semibold">Reason</th>
                    <th class="px-6 py-3 text-left font-semibold">Status</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Example User Rows -->
                @foreach($reports as $report)
                <tr class="hover:bg-indigo-50">
                    <td class="px-6 py-4">
                        {{ $report->ARTIST_REPORT_ID }}
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        {{ $report->created_at }}
                    </td>
                    <td class="px-6 py-4 flex items-center">
                        <img
                            src="{{ $report->Artist->MasterUser->buyer->PROFILE_IMAGE_URL != null ? asset($report->Artist->MasterUser->buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="{{ $report->Artist->MasterUser->buyer->FULLNAME }}"
                            alt="Avatar"
                            class="w-10 h-10 rounded-full mr-3"
                        />
                        <div>
                            <p class="font-semibold text-gray-800">{{ $report->Artist->MasterUser->Buyer->FULLNAME }}</p>
                            <p class="text-gray-500">reported by {{ $report->MasterUser->Buyer->FULLNAME }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500">{{ $report->CONTENT }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-{{ $report->getStatusColor() }}-700 bg-{{ $report->getStatusColor() }}-100 rounded-full">
                            {{ $report->getStatus() }}
                        </span>
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('admin.report.mark',['id'=>$report->ARTIST_REPORT_ID]) }}" class="px-3 py-1 text-white rounded-md
                                bg-blue-500
                                hover:bg-blue-600"
                        >
                            {{ $report->getNextAction() }}
                        </a>
                    </td>
                </tr>
                @endforeach
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
