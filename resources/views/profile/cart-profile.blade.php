<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Art Cart - Full Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .product-card:hover {
      transform: scale(1.02);
    }
    .product-card img {
      transition: transform 0.3s ease-in-out;
    }
    .product-card:hover img {
      transform: scale(1.1);
    }
    .custom-checkbox {
      width: 24px;
      height: 24px;
      border: 2px solid #4F46E5;
      appearance: none;
      border-radius: 0.25rem;
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }
    .custom-checkbox:checked {
      background-color: #4F46E5;
      border-color: #4F46E5;
      background-image: url('https://cdn-icons-png.flaticon.com/512/130/130906.png');
      background-position: center;
      background-size: 16px;
      background-repeat: no-repeat;
    }
  </style>
</head>
<body class="bg-gray-100 p-8">

<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
  <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
    <h1 class="text-3xl font-semibold">Your Art Cart</h1>
    <a href="{{ url('artists') }}" class="text-indigo-600 hover:text-red-600"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
  </div>

  <!-- Cart Items Section -->
  <div class="product-list space-y-4 overflow-y-auto max-h-[600px] border-b border-gray-200 pb-4">
    <!-- Each item in the cart -->
    @foreach($carts as $cart)
    <div class="product-card hover:shadow-lg transform transition-transform duration-300 bg-gray-50 rounded-lg p-4 flex items-start mb-4">
      <input type="hidden" class="mr-4 mt-2 custom-checkbox item-checkbox" data-price="{{ $cart->Art->PRICE }}" @if($cart->Art->isInStock()) checked @endif>
      <div class="flex items-center justify-between w-full">
        <div class="flex items-start">
          <img src="{{ Str::startsWith($cart->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($cart->Art->ArtImages()->first()->IMAGE_PATH) : $cart->Art->ArtImages()->first()->IMAGE_PATH }}" alt="Abstract Illustration" class="w-24 h-24 object-cover rounded-lg shadow-md">
          <div class="ml-6">
            <h2 class="text-lg font-semibold text-gray-800">{{ $cart->Art->ART_TITLE }}</h2>
            <p class="text-sm text-gray-500 mt-1">
              @if($cart->Art->ArtCategories->count() > 0)
                @foreach($cart->Art->ArtCategories as $category)
                  {{ $cart->Art->ArtCategories->map(fn($category) => $category->ArtCategoryMaster->DESCR)->implode(', ') }}
                @endforeach
              @endif
            </p>
            <a href="{{ route('artist.show',['id'=>$cart->Art->MasterUser->Artist->ARTIST_ID]) }}" class="text-indigo-600 font-semibold artist-link mt-1 inline-block">{{ $cart->Art->MasterUser->Buyer->FULLNAME }}</a>
            @if($cart->Art->isInStock())
            <div class="flex items-center mt-3 text-green-500 font-medium text-sm"><i class="fas fa-check-circle"></i><span class="ml-2">In stock</span></div>
            @else
            <div class="flex items-center mt-3 text-yellow-500 font-medium text-sm"><i class="fas fa-clock"></i><span class="ml-2">Out of stock</span></div>
            @endif
          </div>
        </div>
        <div class="text-right">
          <p class="text-lg font-semibold text-gray-800">Rp {{ number_format($cart->Art->PRICE, 0, ',', '.') }}</p>
          <a href="{{ route('cart.remove', ['id'=>$cart->CART_ID]) }}" class="text-indigo-600 font-medium mt-1 hover:text-purple-800 transition text-sm">Remove</a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Subtotal and Checkout Section -->
  @if($carts->count() > 0)
  <div class="flex justify-between items-center mt-8">
    <p class="text-xl font-semibold">Subtotal</p>
    <p class="text-xl font-semibold" id="subtotal">$1,575.00</p>
  </div>
  <p class="text-sm text-gray-500 mt-2">Shipping and taxes will be calculated at checkout.</p>
  <button onclick="window.location.href='{{ route('order.process') }}'" class="w-full bg-indigo-600 text-white py-3 mt-6 rounded-lg text-lg font-semibold hover:bg-indigo-800 transition">Checkout</button>
  @else
  <span class="text-gray-500">Add some art to cart to checkout</span>
  @endif
</div>

<script>
    // Calculate subtotal based on checked items
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const subtotalEl = document.getElementById('subtotal');

    function calculateSubtotal() {
      let subtotal = 0;
      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          subtotal += parseFloat(checkbox.dataset.price);
        }
      });
      const formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      });
      subtotalEl.textContent = formatter.format(subtotal);
    }

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', calculateSubtotal);
    });

    // Initial calculation on page load
    calculateSubtotal();
</script>

</body>
</html>
