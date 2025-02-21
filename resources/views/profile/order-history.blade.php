<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Order History</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .order-item {
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .order-item:hover {
      background-color: #f9fafb;
      transform: translateY(-2px);
    }

    .order-details {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease;
    }

    .order-item.open .order-details {
      max-height: 600px; /* Adjust to accommodate content */
    }

    .item-image {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 0.375rem;
    }

    .rotate-180 {
      transform: rotate(180deg);
    }
  </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

  <div class="max-w-7xl mx-auto py-12 px-4">
    <a href="{{ route('landing') }}"
      class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-300 transition duration-300 shadow-sm mt-4">
       <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
           <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
       </svg>
       <span class="text-sm font-medium text-white">Back</span>
    </a>
        <!-- Total Spend Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8 mt-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-700">💰 Total Spend</h2>
            <p class="text-gray-500 mt-1">Your total spend across all orders</p>
        </div>
        <div class="text-3xl font-bold text-indigo-600">
            Rp {{ number_format(Auth::user()->total_spending, 0, ',', '.') }}
        </div>
    </div>
    <!-- Profile Heading -->
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🛒 Order History</h1>

    <!-- Order History List -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <div class="px-6 py-4 bg-gray-50 border-b">
        <h3 class="text-lg leading-6 font-semibold text-gray-900">Your Orders</h3>
        <p class="mt-1 text-sm text-gray-500">Click on an order to view more details.</p>
      </div>

      <!-- Orders List -->
      
      <div class="divide-y divide-gray-200 order">
        <!-- Example of an order item -->
        @foreach($orders as $order)
        <div class="order-item px-6 py-5 hover:bg-gray-50 transition" onclick="toggleOrderDetails(this)">
          <!-- Order Summary -->
          <div class="flex justify-between items-center">
            <div>
              <h4 class="text-gray-800 font-semibold">Order #{{ $order->ORDER_ID }}</h4>
              <p class="text-sm text-gray-600">Date: {{ (new \DateTime($order->created_at))->format('M d, Y') }}</p>
              <p class="text-sm text-gray-600">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
              <p class="text-sm text-green-600 font-semibold">Status: {{ $order->status_text }}</p>
            </div>
            <div class="flex items-center text-indigo-600 font-semibold">
              <span class="mr-2">Details</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6"/>
              </svg>
            </div>
          </div>

          <!-- Order Details (Collapsible Section) -->
          <div class="order-details mt-4 space-y-4">
            <div class="text-gray-700">
              <p><strong>Items:</strong></p>
              <ul class="space-y-4">
                <!-- Item 1 -->
                @foreach($order->OrderItems as $orderItem)
                <li class="flex items-center">
                  <img src="{{ Str::startsWith($orderItem->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($orderItem->Art->ArtImages()->first()->IMAGE_PATH) : $orderItem->Art->ArtImages()->first()->IMAGE_PATH }}" alt="Product 1" class="item-image mr-4"/>
                  <div class="flex-1">
                    <p class="text-gray-900 font-medium">{{ $orderItem->Art->ART_TITLE }}</p>
                    <p class="text-sm text-gray-500">Quantity: {{ $orderItem->QUANTITY }}</p>
                  </div>
                  <p class="text-gray-900 font-medium">Rp {{ number_format($orderItem->Art->PRICE, 0, ',', '.') }}</p>
                </li>
                @endforeach
              </ul>
            </div>
            <div>
              <p class="text-gray-700"><strong>Delivery Address:</strong> {{ $order->ADDRESS }}, {{ $order->CITY }}, {{ $order->PROVINCE }}, {{ $order->POSTAL_CODE }}</p>
              <p class="text-gray-700"><strong>Payment Method:</strong> {{ $order->PAYMENT }}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Pagination Links -->
  </div>

<script>
  // Function to toggle the order details visibility
  function toggleOrderDetails(orderElement) {
    const details = orderElement.querySelector('.order-details');
    const arrowIcon = orderElement.querySelector('svg');

    // Toggle the open class to expand/collapse the order
    orderElement.classList.toggle('open');
    arrowIcon.classList.toggle('rotate-180');  // Rotate the arrow on click
  }
</script>

</body>
</html>
