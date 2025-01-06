<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Checkout</title>
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
              
                        <li class="flex items-center text-gray-500">
                                <svg class="mr-2 h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="font-semibold">Order Summary</span>
                        </li>
                  </ol>
  <!-- Main Container -->
  <div class="max-w-7xl mx-auto bg-white p-8 rounded-lg shadow-lg space-y-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4 border-b border-gray-200 pb-4">🛒 Checkout</h1>

    @if(session('status'))
    <div class="p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ session('status') }}
    </div>
    @endif

    @foreach($errors->all() as $error)
    <div class="flex items-center p-4 my-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Error</span>
        <div>
        {{ $error }}
        </div>
    </div>
    @endforeach

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <div class="lg:col-span-2 space-y-8">
        
        <!-- Delivery Address Section -->
        <div class="flex items-center mb-4">
            <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>
            <h2 class="font-bold text-lg">Shipping Address</h2>
        </div>
        <hr class="border-gray-300 mb-4">
        @if($activeAddress != null)
        <div class="mb-4">
            <p class="font-bold text-gray-800">{{ $activeAddress->FULLNAME }}</p>
            <p class="text-gray-600">{{ $activeAddress->PHONE }}</p>
            <p class="text-gray-700">{{ $activeAddress->ADDRESS }}</p>
            <p class="text-gray-700">{{ $activeAddress->PROVINCE }}, {{ $activeAddress->CITY }}, {{ $activeAddress->POSTAL_CODE}}</p>
        </div>
        @else
        <div class="mb-4">
          <p class="font-bold text-gray-800">No active address</p>
        </div>
        @endif

        <hr class="border-gray-300 mb-4">

        <!-- Choose Address Button -->
        <a href="{{ route('order.address.show') }}" 
          class="w-full block text-center bg-white border border-gray-400 rounded-full px-4 py-2 text-gray-700 hover:bg-gray-200 transition">
            Choose Address
        </a>

  <!-- Store Pickup Option -->
  <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">🏬 Store Pickup</h2>
    <div class="flex items-center">
      <input type="radio" id="delivery_address" name="delivery_address" class="mr-2" checked>
      <label for="delivery_address" class="text-gray-700">Kirim ke alamat yang sama</label>
    </div>
    <div class="flex items-center mt-2">
      <input type="radio" id="store_pickup" name="delivery_address" class="mr-2">
      <label for="store_pickup" class="text-gray-700">Ambil di Toko</label>
    </div>
    <p class="text-gray-500 text-sm mt-2">(Pilih toko dari mana Anda ingin mengambil produk)</p>
    <div class="mt-2 hidden" id="seller_info">
      <p class="text-gray-700">Alamat Toko: Jl. Thamrin, Jakarta</p>
      <p class="text-gray-700">Telepon: 0812-3456-7890</p>
    </div>
  </div>

  <!-- Payment Method Section -->
  <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
        <h2 class="text-2xl font-semibold mb-4 text-gray-800">Payment Method</h2>
        <div class="flex space-x-4">
          <button class="px-4 py-2 bg-gray-200 border-2 border-transparent rounded-md" id="cod" onclick="selectPayment('COD')">COD</button>
          <button class="px-4 py-2 bg-gray-200 border-2 border-transparent rounded-md" id="transfer-bank" onclick="selectPayment('Transfer Bank')">Transfer Bank</button>
        </div>
      </div>

      <!-- Bank List Section (only appears if Transfer Bank is selected) -->
      <div id="bank-list-section" class="bg-gray-50 p-6 rounded-lg shadow-sm hidden">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Pilih Bank</h2>
        <ul class="space-y-4">
          <li class="flex items-center">
            <input type="radio" name="bank" value="SeaBank" class="mr-2">
            <span class="font-medium text-gray-700">SeaBank</span>
          </li>
          <li class="flex items-center">
            <input type="radio" name="bank" value="Bank BCA" class="mr-2">
            <span class="font-medium text-gray-700">Bank BCA</span>
          </li>
          <li class="flex items-center">
            <input type="radio" name="bank" value="Bank Mandiri" class="mr-2">
            <span class="font-medium text-gray-700">Bank Mandiri</span>
          </li>
          <li class="flex items-center">
            <input type="radio" name="bank" value="Bank BNI" class="mr-2">
            <span class="font-medium text-gray-700">Bank BNI</span>
          </li>
          <li class="flex items-center">
            <input type="radio" name="bank" value="Bank BRI" class="mr-2">
            <span class="font-medium text-gray-700">Bank BRI</span>
          </li>
        </ul>
      </div>

</div>

<!-- Order Summary Section -->
<div class="space-y-6">
  <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
    <h2 class="text-2xl font-semibold mb-4 text-gray-800">📦 Ordered Product</h2>
    <div class="space-y-4">
      <!-- Item 1 -->
      @foreach($carts as $order)
      <div class="flex items-center order-item" data-price="{{ $order->Art->PRICE }}">
        <img alt="Paint in the night" class="w-16 h-16 rounded-lg shadow" src="{{ Str::startsWith($order->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($order->Art->ArtImages()->first()->IMAGE_PATH) : $order->Art->ArtImages()->first()->IMAGE_PATH }}"/>
        <div class="ml-4">
          <p class="text-gray-700 font-medium">{{ $order->Art->ART_TITLE }}</p>
          <p class="text-gray-500 text-sm">{{ $order->Art->MasterUser->Buyer->FULLNAME }}</p>
        </div>
        <p class="ml-auto text-gray-700 font-semibold">Rp {{ number_format($order->Art->PRICE, 0, ',', '.') }}</p>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Total Summary -->
  <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
    <h2 class="text-xl font-semibold mb-4 text-gray-800">💳 Total Payment</h2>
    <div class="flex justify-between text-lg font-medium mb-2">
      <p>Subtotal</p>
      <p id="subtotalOrder">Rp 0</p>
    </div>
    <div class="flex justify-between text-lg font-medium mb-2">
      <p>Ongkir</p>
      <p>Rp 50.000</p>
    </div>
    <div class="flex justify-between text-xl font-semibold">
      <p>Total</p>
      <p id="totalOrder">Rp 0</p>
    </div>
        <!-- Payment Button -->
        <a href="{{ route('order.checkout') }}"
            onclick="showSuccessModal();"
            class="w-full block text-center bg-indigo-600 text-white py-3 rounded-lg font-semibold mt-4 hover:bg-indigo-700 transition">
            Lanjutkan ke Pembayaran
        </a>
  </div>
</div>

</div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center success-modal">
            <i class="fas fa-check-circle text-indigo-600 text-5xl mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-800">Your Payment Was Successful!</h2>
            <p class="text-gray-600 mt-2">Thank you for your purchase.</p>
        </div>
  </div>

<!-- Scripts -->
<script>
function showSuccessModal() {
    // Show success modal
    const successModal = document.getElementById('successModal');
    successModal.classList.remove('hidden');

    // Hide the success modal after 3 seconds
    setTimeout(() => {
    successModal.classList.add('hidden');
    }, 5000);
}
const orders = document.querySelectorAll('.order-item');
console.log(orders);
const subtotalEl = document.getElementById('subtotalOrder');
const totalEl = document.getElementById('totalOrder');

function calculateSubtotal() {
  let subtotal = 0;
  orders.forEach(order => {
    // console.log(order.dataset.price);
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

// function showSuccessModal() {
//     // Show success modal
//     const successModal = document.getElementById('successModal');
//     successModal.classList.remove('hidden');

//     // Hide the success modal after 3 seconds
//     setTimeout(() => {
//     successModal.classList.add('hidden');
//     // Optionally, redirect to another route
//     }, 3000);
// }

function selectPayment(method) {
      // Reset all buttons
      document.getElementById('cod').classList.remove('border-indigo-600');
      document.getElementById('transfer-bank').classList.remove('border-indigo-600');
      document.getElementById('qris').classList.remove('border-indigo-600');

      // Hide bank list section initially
      document.getElementById('bank-list-section').classList.add('hidden');

      // Highlight selected payment button
      if (method === 'COD') {
        document.getElementById('cod').classList.add('border-indigo-600');
      } else if (method === 'Transfer Bank') {
        document.getElementById('transfer-bank').classList.add('border-indigo-600');
        document.getElementById('bank-list-section').classList.remove('hidden');
      } else if (method === 'QRIS') {
        document.getElementById('qris').classList.add('border-indigo-600');
      }
}

function openSavedAddressModal() {
document.getElementById('saved-address-modal').classList.remove('hidden');
document.getElementById('saved-address-modal').classList.add('scale-100');
}

function openNewAddressModal() {
document.getElementById('saved-address-modal').classList.add('hidden');
document.getElementById('new-address-modal').classList.remove('hidden');
}

function closeModal() {
document.getElementById('saved-address-modal').classList.add('hidden');
document.getElementById('new-address-modal').classList.add('hidden');
}

function confirmAddress() {
const selectedAddress = document.querySelector('input[name="saved_address"]:checked').value;
document.getElementById('selected-address').innerText = selectedAddress;
closeModal();
}

function saveNewAddress() {
const fullName = document.getElementById('full-name').value;
const phoneNumber = document.getElementById('phone-number').value;
const province = document.getElementById('province').value;
const city = document.getElementById('city').value;
const kecamatan = document.getElementById('kecamatan').value;
const addressDetails = document.getElementById('address-details').value;
const newAddress = `${fullName}, ${phoneNumber}, ${province}, ${city}, ${kecamatan}, ${addressDetails}`;

if (document.getElementById('save_address').checked) {
        const savedAddressList = document.getElementById('saved-address-list');
        const newAddressIndex = savedAddressList.children.length;
        const newAddressHTML = `
          <li data-index="${newAddressIndex}">
            <label class="block text-gray-700">
              <input type="radio" name="saved_address" value="${newAddress}" class="mr-2">
              ${newAddress}
            </label>
            <button class="text-indigo-600 hover:text-indigo-800 transition font-semibold mt-2" onclick="editAddress(${newAddressIndex})">Edit</button>
            </li>
            `;
            savedAddressList.insertAdjacentHTML('beforeend', newAddressHTML);
      }
      
      document.getElementById('selected-address').innerText = newAddress;
      closeModal();
    }

    function editAddress(index) {
      const addressItem = document.querySelector(`li[data-index="${index}"] label`).innerText.split(', ');
      document.getElementById('full-name').value = addressItem[0];
      document.getElementById('phone-number').value = addressItem[1];
      document.getElementById('province').value = addressItem[2];
      updateCities();
      document.getElementById('city').value = addressItem[3];
      updateKecamatan();
      document.getElementById('kecamatan').value = addressItem[4];
      document.getElementById('address-details').value = addressItem[5];
      document.getElementById('address-modal-title').innerText = 'Edit Alamat';
      
      openNewAddressModal();
    }
  </script>

</body>
</html>