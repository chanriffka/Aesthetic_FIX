<!DOCTYPE html>
<html lang="en">

<head>
    <title>Buyer Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Container -->
    <div class="max-w-4xl mx-auto mt-10 bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white p-8 flex flex-col items-center relative">
            <!-- Back Button -->
            <a href="{{ route('landing') }}" class="absolute top-4 left-4 flex items-center text-gray-200 hover:text-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Back
            </a>
            <!-- Profile Image -->
            <img src="{{ $user->Buyer->PROFILE_IMAGE_URL != null ? asset($user->Buyer->PROFILE_IMAGE_URL) : 'https://placehold.co/100x100'}}" alt="Buyer Avatar" class="w-32 h-32 rounded-full shadow-lg border-4 border-white">
            <!-- Buyer Info -->
            <div class="text-center mt-4">
                <h1 class="text-3xl font-bold">{{ $user->Buyer->FULLNAME }}</h1>
                <p class="text-indigo-200 text-sm">Buyer since {{ (new \DateTime($user->created_at))->format('F Y') }}</p>
            </div>
            <!-- Edit Profile Button -->
            <button onclick="openEditProfileModal()" class="mt-4 px-6 py-2 bg-white text-indigo-600 rounded-full shadow-md hover:bg-indigo-100 transition">
                Edit Profile
            </button>
        </div>

        <!-- Profile Stats -->
        <div class="grid grid-cols-3 text-center gap-4 bg-gray-50 p-6">
            <div>
                <h2 class="text-2xl font-bold text-indigo-600">{{ $user->total_purchased_item }}</h2>
                <p class="text-gray-700">Artworks Purchased</p>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-indigo-600">Rp {{ number_format($user->total_spend, 0, ',', '.') }}</h2>
                <p class="text-gray-700">Total Spend</p>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-indigo-600">{{ $user->Followings->count() }}</h2>
                <p class="text-gray-700">Artists Following</p>
            </div>
        </div>

        <!-- Recent Purchases Section -->
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Recent Purchases</h2>
            @if($user->Orders()->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Artwork Card -->
                @foreach($user->Orders()->orderBy('created_at','DESC')->get() as $order)
                    @foreach($order->OrderItems as $item)
                        <div onclick="window.location.href='{{ route('artwork.show', $item->Art->ART_ID) }}'"
                             class="bg-gray-100 rounded-lg shadow-md p-4 hover:shadow-lg transition cursor-pointer">
                            <img src="{{ Str::startsWith($item->Art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($item->Art->ArtImages()->first()->IMAGE_PATH) : $item->Art->ArtImages()->first()->IMAGE_PATH }}" 
                                 alt="Artwork Title" 
                                 class="w-full h-40 object-cover rounded-lg mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $item->Art->ART_TITLE }}</h3>
                            <p class="text-sm text-gray-600">by {{ $item->Art->MasterUser->Buyer->FULLNAME }}</p>
                            <p class="text-sm text-gray-500">Rp {{ number_format($item->PRICE_PER_ITEM, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                @endforeach
            </div>
            @else
            <!-- No Purchases -->
            <div class="text-center mt-8">
                <h2 class="text-lg font-semibold text-gray-600">You don’t have any art purchased yet.</h2>
                <a href="{{ url('explore') }}" class="text-indigo-500 hover:underline mt-2 block">Explore Artworks</a>
            </div>
            @endif
        </div>
    </div>
    
<!-- Edit Profile Modal -->
<div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl h-[90vh] overflow-hidden relative">
        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b px-8 py-4">
            <h2 class="text-3xl font-bold text-gray-800">Edit Profile</h2>
            <button onclick="closeEditProfileModal()" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-8 overflow-y-auto h-[calc(100%-120px)]">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Profile Image Upload Section -->
                <div class="flex justify-center mb-6">
                    <div class="relative w-32 h-32">
                        <!-- Image Preview -->
                        <img id="profileImagePreview" src="{{ Auth::user()->Buyer->PROFILE_IMAGE_URL != null ? asset(Auth::user()->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Profile Picture"
                            class="w-full h-full object-cover rounded-full border-4 border-gray-200">
                        <!-- Upload Icon -->
                        <label for="profilePictureUpload"
                            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white rounded-full cursor-pointer hover:bg-opacity-70">
                            <i class="fas fa-camera text-2xl"></i>
                        </label>
                        <input type="file" id="profilePictureUpload" name="picture" accept="image/*" class="hidden"
                            onchange="previewProfileImage(event)">
                    </div>
                </div>
            
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                    <input id="name" name="name" type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="John Doe" value="{{ Auth::user()->Buyer->FULLNAME }}">
                </div>

                <!-- Username -->
                <div class="mb-6">
                    <label for="username" class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                    <input id="username" name="username" type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="@johndoe" value="{{ Auth::user()->USERNAME }}">
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 rounded-l-lg text-gray-500">+62</span>
                        <input id="phone" name="phone" type="text" class="w-full px-4 py-2 border rounded-r-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="8123456789" value="{{ Auth::user()->Buyer->PHONE_NUMBER }}">
                    </div>
                </div>

                {{-- <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Address</label>
                    <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="123 Main St, Jakarta, Indonesia">{{ Auth::user()->Buyer->ADDRESS }}</textarea>
                </div> --}}

                <!-- Location -->
                {{-- <div class="mb-6">
                    <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Location</label>
                    <input id="location" type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Jakarta, Indonesia">
                </div> --}}

                <!-- Buttons -->
                <div class="flex justify-end">
                    <button type="button" onclick="closeEditProfileModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 mr-4">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        function openEditProfileModal() {
            document.getElementById('editProfileModal').classList.remove('hidden');
        }

        function closeEditProfileModal() {
            document.getElementById('editProfileModal').classList.add('hidden');
        }
            // Image Preview Functionality
        function previewProfileImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
    </script>
</body>

</html>
