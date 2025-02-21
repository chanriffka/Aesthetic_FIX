<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="bg-white font-sans text-gray-900">

<!-- Page Container -->
<div class="max-w-7xl mx-auto py-6 px-4 bg-white rounded-lg shadow">

        <!-- Back Button -->
        <div class="mb-4">
                <a href="{{ route('landing') }}" 
                class="inline-flex items-center px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 hover:text-gray-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back
                </a>
        </div>

        <!-- Header Section -->
        <div class="pb-4 border-b mb-4">
            <h3 class="text-2xl font-bold text-gray-800">📦 Order Status</h3>
            <p class="text-sm text-gray-500">Manage and update the delivery status of your orders below.</p>
        </div>

        @if(session('status'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  {{ session('status') }}
                </div>
            </div>
        @endif
    
        <!-- Search and Filter -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            <!-- Search Bar -->
            <div class="w-full md:w-2/3">
                <input id="searchInput"
                    type="text"
                    placeholder="Search by order ID, buyer, or art name..."
                    class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Filter Dropdown -->
            <div class="w-full md:w-1/3 flex items-center md:justify-end">
                <label for="statusFilter" class="text-gray-600 font-medium mr-2">Filter by Status:</label>
                <select id="statusFilter"
                        class="px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none text-gray-700">
                    <option value="all">All</option>
                    <option value="packed">Packed</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <!-- Table for Orders -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="border-b bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Order ID</th>
                        <th class="px-6 py-3 text-left font-semibold">Buyer</th>
                        <th class="px-6 py-3 text-left font-semibold">Date</th>
                        <th class="px-6 py-3 text-left font-semibold">Art Name</th>
                        <th class="px-6 py-3 text-left font-semibold">Price</th>
                        <th class="px-6 py-3 text-left font-semibold">Address</th>
                        <th class="px-6 py-3 text-left font-semibold">Payment Method</th>
                        <th class="px-6 py-3 text-center font-semibold">Status</th>
                        <th class="px-6 py-3 text-center font-semibold">Update</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                    <tr class="border-b hover:bg-gray-50"
                        data-status="{{ strtolower($order->status_text) }}"
                        data-art-name="{{ $order->OrderItems->pluck('Art.ART_TITLE')->implode(' ') }}"> <!-- Art names -->
                        <td class="px-6 py-4 font-semibold text-gray-800">#{{ $order->ORDER_ID }}</td>
                        <td class="px-6 py-4">{{ $order->MasterUser->Buyer->FULLNAME }}<br><span class="text-sm text-gray-500">{{ $order->MasterUser->EMAIL }}</span></td>
                        <td class="px-6 py-4">{{ (new \DateTime($order->created_at))->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <ol>
                                @foreach($order->OrderItems as $item)
                                <li>{{ $item->Art->ART_TITLE }},</li>
                                @endforeach
                            </ol>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            {{ $order->ADDRESS }}<br>
                            {{ $order->CITY }}, {{ $order->PROVINCE }} {{ $order->POSTAL_CODE }}
                        </td>
                        <td class="px-6 py-4">{{ $order->PAYMENT }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 text-xs font-semibold text-{{ $order->status_color }}-700 bg-{{ $order->status_color }}-100 rounded-full">{{ $order->status_text }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex space-x-2 items-center justify-center">
                                <form action="{{ route('order.update', ['id'=>$order->ORDER_ID]) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <select class="px-3 py-1 border rounded-md focus:ring-2 focus:ring-indigo-500" name="STATUS">
                                        <option value="0" @if($order->STATUS == 5) selected @endif>CANCELED</option>
                                        <option value="1" @if($order->STATUS == 0) selected @endif>NEW</option>
                                        <option value="2" @if($order->STATUS == 1) selected @endif>PAID</option>
                                        <option value="3" @if($order->STATUS == 2) selected @endif>PACKED</option>
                                        <option value="4" @if($order->STATUS == 3) selected @endif>SHIPPED</option>
                                        <option value="5" @if($order->STATUS == 4) selected @endif>DELIVERED</option>
                                    </select>
                                    <button type="submit" class="px-3 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    <!-- Add this script at the bottom -->
    <!-- JavaScript for Filtering and Search -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const rows = document.querySelectorAll('tbody tr');

            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const selectedStatus = statusFilter.value.toLowerCase();

                rows.forEach(row => {
                    const status = row.getAttribute('data-status');
                    const artName = row.getAttribute('data-art-name').toLowerCase();

                    const matchesSearch = artName.includes(searchText);
                    const matchesStatus = selectedStatus === 'all' || status === selectedStatus;

                    if (matchesSearch && matchesStatus) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
        });
    </script>
</body>
    
