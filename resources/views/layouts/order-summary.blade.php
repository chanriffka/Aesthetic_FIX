<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Order Summary</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
        font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans antialiased">
        <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
                <form action="#" class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                  <ol class="items-center flex w-full max-w-2xl text-center text-sm font-medium text-gray-500 dark:text-gray-400 sm:text-base">
                        <li class="relative flex items-center text-indigo-600 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
                                <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] sm:after:hidden">
                                  <svg class="mr-2 h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                  </svg>
                                  <span class="font-semibold text-gray-900">Cart</span>
                                </span>
                        </li>
              
                        <li class="relative flex items-center text-indigo-600 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
                                <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] sm:after:hidden">
                                  <svg class="mr-2 h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                  </svg>
                                  <span class="font-semibold text-gray-900">Checkout</span>
                                </span>
                        </li>
              
                        <li class="relative flex items-center text-indigo-600 after:mx-6 after:hidden after:h-1 after:w-full after:border-b after:border-gray-200 sm:after:inline-block sm:after:content-[''] md:w-full xl:after:mx-10">
                                <span class="flex items-center after:mx-2 after:text-gray-200 after:content-['/'] sm:after:hidden">
                                  <svg class="mr-2 h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                  </svg>
                                  <span class="font-semibold text-gray-900">Order Summary </span>
                                </span>
                        </li>
                  </ol>
  <!-- Main Container for Order Summary -->
  <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-lg space-y-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4 border-b border-gray-200 pb-4">📦 Order Summary</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- Order Summary Section -->
      <div class="space-y-6 lg:col-span-2">
        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">Your Items</h2>
          <div class="space-y-4">
            
            <!-- Item 1 -->
            @foreach($order->OrderItems as $orderItem)
            <div class="flex items-center order-item" data-price="{{ $orderItem->PRICE_PER_ITEM }}">
              <img alt="PC system All in One APPLE iMac (2023)" class="w-16 h-16 rounded-lg shadow" src="{{ Str::startsWith($orderItem->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($orderItem->Art->ArtImages()->first()->IMAGE_PATH) : $orderItem->Art->ArtImages()->first()->IMAGE_PATH }}"/>
              <div class="ml-4">
                <p class="text-gray-700 font-medium">{{ $orderItem->Art->ART_TITLE }}</p>
                <p class="text-gray-500 text-sm">x{{ $orderItem->QUANTITY }}</p>
              </div>
              <p class="ml-auto text-gray-700 font-semibold">Rp {{ number_format($orderItem->Art->PRICE, 0, ',', '.') }}</p>
            </div>
            @endforeach
          </div>
        </div>

        <!-- Delivery Address -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-sm space-y-4">
          <!-- Title -->
          <div class="flex items-center space-x-2">
              <i class="fas fa-map-marker-alt text-indigo-500 text-xl"></i>
              <h2 class="font-bold text-lg text-gray-800">Shipping Address</h2>
          </div>
          <hr class="border-gray-300">

          <!-- Address Details -->
          <div class="space-y-2">
              <p class="font-bold text-gray-800 text-lg">{{ $order->FULLNAME }}</p>
              <p class="text-gray-600">{{ $order->PHONE }}</p>
              <p class="text-gray-700 leading-relaxed">
                {{ $order->ADDRESS }}<br>
                {{ $order->PROVINCE }}, {{ $order->CITY }}, {{ $order->POSTAL_CODE }}
              </p>
          </div>
      </div>


        <!-- Payment Method -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">💳 Payment Method</h2>
          <p class="text-gray-700">{{ $order->PAYMENT }}</p>
        </div>
      </div>

      <!-- Summary Total Section -->
      <div>
        <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
          <h2 class="text-2xl font-semibold mb-4 text-gray-800">💵 Total Pesanan</h2>
          <div class="flex justify-between text-lg font-medium mb-2">
            <p>Subtotal</p>
            <p id="subtotalOrder">Rp 0</p>
          </div>
          <div class="flex justify-between text-lg font-medium mb-2">
            <p>Shipping</p>
            <p>Rp 50.000</p>
          </div>
          <div class="flex justify-between text-xl font-semibold">
            <p>Total</p>
            <p id="totalOrder">Rp 0</p>
          </div>
        </div>

        <!-- Button to Go Back or View Receipt -->
        <div class="space-y-4 mt-6">
        <a href="{{ route('order.history') }}" 
            class="w-full block text-center bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
            View Your Order
        </a>
          <a href={{ route('landing') }} class="w-full block text-center bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">Return to Shopping</a>
        </div>
      </div>

    </div>
  </div>
<script>
  const orders = document.querySelectorAll('.order-item');
const subtotalEl = document.getElementById('subtotalOrder');
const totalEl = document.getElementById('totalOrder');

function calculateSubtotal() {
  let subtotal = 0;
  orders.forEach(order => {
    subtotal += parseFloat(order.dataset.price);
  });

  const formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });

  subtotalEl.textContent = formatter.format(subtotal);
  totalEl.textContent = formatter.format(subtotal+50000);
}

calculateSubtotal();
</script>
</body>
</html>
