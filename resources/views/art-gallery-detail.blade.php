<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Fantasy World Creation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-white text-black font-sans">
  @if(Auth::Check())
    @include('layouts.navbar-login')
    @else
    @include('layouts.navbar')
  @endif
  <div class="container mx-auto p-6">
    <!-- Back Button with Arrow Icon -->
    <a href="javascript:history.back()" 
      class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-300 transition duration-300 shadow-sm mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
        </svg>
        <span class="text-sm font-medium text-white">Back</span>
    </a>
    <div class="flex flex-wrap lg:flex-nowrap">
      <!-- Main Content -->
      <div class="w-full lg:w-3/4 lg:pr-6 mt-6">
        <!-- Artwork Image -->
        <img src="{{ Str::startsWith($portfolio->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($portfolio->ArtImages()->first()->IMAGE_PATH) : $portfolio->ArtImages()->first()->IMAGE_PATH }}" alt="{{ $portfolio->ARTWORK_TITLE }}" class="w-full h-auto rounded-lg shadow-md"/>
        
        <!-- Title, Made by, and Meta Info Section -->
        <div class="flex justify-between items-center">
         <!-- Left Section: Title and Info -->
        <div class="flex items-center space-x-4 space-y-8">
        <img alt="Profile picture of the creator" class="w-16 h-16 rounded-lg" height="64" src="{{ $portfolio->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($portfolio->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" width="64"/>
        <div>
        <h1 class="text-3xl font-bold">{{ $portfolio->ART_TITLE }}</h1>
        <p class="text-gray-400 mt-2">Made by <span class="text-black">{{ $portfolio->MasterUser->Buyer->FULLNAME }}</span></p>
        </div>
  </div>

  <!-- Right Section: Published, Likes, and Comments -->
  <div class="flex flex-col items-end">
    <!-- Published Date -->
    <p class="text-gray-600 mb-1">Published: {{ (new \DateTime($portfolio->created_at))->format('M d, Y') }}</p>

    <!-- Likes and Comments -->
    <div class="flex items-center space-x-3">
      <div class="flex items-center space-x-2">
        <!-- Custom Heart Icon -->
        @if(Auth::user() != null)
        <a href="{{ route('portfolio.like',['id'=>$portfolio->ART_ID]) }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="@if($portfolio->isLiked()) currentColor @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-pink-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
          </svg>
        </a>
        @else
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-pink-500">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        @endif
        <span>{{ $portfolio->ArtLikes->count() }}</span>
      </div>
      {{-- <div class="flex items-center space-x-2">
        <!-- Custom Comment Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
        </svg>
        <span>Comment</span>
      </div> --}}
    </div>
  </div>
</div>
                    @if(Auth::check())
                        @if (Auth::user()->USER_ID == $portfolio->USER_ID )
                        <button id="editPortfolioButton" 
                                onclick="openEditPortfolioModal()" 
                                class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600 transition btn">
                            <i class="fas fa-pen"></i>
                            <span>EDIT</span>
                        </button>
                            <a href={{ route('portfolio.destroy', ['portfolioId' => $portfolio->ART_ID]) }} class="border border-red-500 text-red-500 py-2 px-4 rounded-lg hover:bg-red-50 transition btn" onclick="return confirm('Are you sure you want to delete this portfolio?');">
                                <i class="fas fa-trash"></i>
                                <span>DELETE</span>
                            </a>
                        @endif
                    @endif
          <!-- Stats -->
          <div class="flex items-center space-x-6 mt-4">
            <div class="flex items-center space-x-2">
              <!-- Custom Eye Icon -->
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              <span>{{ $portfolio->VIEW }} Views</span>
            </div>
            {{-- <div class="flex items-center space-x-2">
              <!-- Custom Comment Icon -->
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
              </svg>
              <span>20 Comments</span>
            </div> --}}
            {{-- <i class="fas fa-ellipsis-h cursor-pointer"></i> --}}
          </div>
          
          <!-- Tags -->
          <div class="flex flex-wrap mt-6 space-x-2">
            @foreach($portfolio->ArtCategories as $category)
              <span class="px-3 py-1 border border-gray-600 rounded-lg">{{ $category->ArtCategoryMaster->DESCR }}</span>
            @endforeach
          </div>

          <!-- Artwork Details -->
          <p class="mt-6">{{ $portfolio->DESCRIPTION }}</p>
          <p class="text-gray-600 mt-4">Image Size: {{ $portfolio->WIDTH }}x{{ $portfolio->HEIGHT }} {{ $portfolio->UNIT }}</p>
          {{-- <p class="text-gray-600">Total Size: 3.5 MB</p> --}}
          <p class="text-gray-600">© {{ (new \DateTime($portfolio->created_at))->format('Y') }} {{ $portfolio->MasterUser->Buyer->FULLNAME }}</p>

        <!-- Divider Line Before Comments Section -->
        {{-- <hr class="my-8 border-gray-700"/> --}}

        <!-- Comment Sections -->
        {{-- <div class="max-w-1xl ml-1 py-4">
          <h2 class="text-xl font-semibold mb-4">20 Comments</h2>
          <div class="space-y-4 max-h-80 overflow-y-auto pr-4">
            <!-- Comment 1 -->
            <div class="space-y-2">
              <div class="flex space-x-4">
                <img alt="Profile picture of Alexander R." class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/oSFDe0Yiu5zzUCE8P9cjJFfTFmVHsSvDdYLCABOIFLGR5onTA.jpg" width="50"/>
                <div class="bg-zinc-400 p-4 flex-1">
                  <div class="font-semibold">Alexander R.</div>
                  <div class="mt-1">Nice Drawing! Can you teach me?</div>
                </div>
              </div>
              <div class="flex space-x-4 pl-16">
                <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span>Reply</span>
                </button>
                <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Comment 2 -->
            <div class="space-y-2">
              <div class="flex space-x-4">
                <img alt="Profile picture of Brown D. J." class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/yg8jirLpfYT6H6SbO7z6ebRZHFheLSaidTZhg6JwbVe4kjecC.jpg" width="50"/>
                <div class="bg-zinc-400 p-4 flex-1">
                  <div class="font-semibold">Brown D. J.</div>
                  <div class="mt-1">What could I say? I love it!</div>
                </div>
              </div>
              <div class="flex space-x-4 pl-16">
                <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span>Reply</span>
                </button>
                <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                  </svg>
                </button>
              </div>
            </div>

            <!-- Comment 3 (Reply to Comment 2) -->
            <div class="space-y-2 pl-12">
              <div class="flex space-x-4">
                <img alt="Profile picture of Beary the Bear" class="w-12 h-12" height="50" src="https://storage.googleapis.com/a1aa/image/PBBg3GtJgrKJMBk7KvvHJBryUYdVsnHBr7NIjEeICYRpc0zJA.jpg" width="50"/>
                <div class="bg-zinc-400 p-4 flex-1">
                  <div class="font-semibold">Beary the Bear</div>
                  <div class="mt-1">It's like we've been through a long journey and arrive at this hidden kingdom</div>
                </div>
              </div>
              <div class="flex space-x-4 pl-16">
                <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                  </svg>
                  <span>Reply</span>
                </button>
                <button class="flex items-center space-x-1 text-gray-600 hover:text-gray-200">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div> --}}
      </div>

      <!-- Sidebar Content -->
      <div class="w-1/4 ml-4">
        <div class="flex justify-between items-center">
          <h2 class="text-xl">More by {{ $portfolio->MasterUser->Buyer->FULLNAME }}</h2>
          <a href="{{ route('artist.show', ['id'=>$portfolio->MasterUser->Artist->ARTIST_ID,'section'=>'portfolio']) }}" class="text-black hover:text-indigo-500 transition">more →</a>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-2">
          @foreach($morePortfolios as $item)
          <img src="{{ Str::startsWith($item->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($item->ArtImages()->first()->IMAGE_PATH) : $item->ArtImages()->first()->IMAGE_PATH }}" alt="{{ $item->ARTWORK_TITLE }}" alt="Artwork thumbnail" class="w-full h-32 object-cover rounded-lg">
          @endforeach
        </div>  

        <!-- New Content Section -->
        <div class="bg-zinc-800 rounded-lg overflow-hidden max-w-lg mt-8">
        <!-- Main Image -->
        <img alt="A cyberpunk styled character with vibrant colors and a futuristic look" class="w-full h-40 object-cover" src="/images/assets/gallery/11.jpg" />
  
        <!-- Profile Info Section -->
        <div class="p-4 flex items-center">
          <img alt="Profile picture of the user" class="w-8 h-8 rounded-lg mr-4" src="{{ $portfolio->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($portfolio->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}"/>
        <div>
        <div class="text-white text-lg">
          {{ $portfolio->MasterUser->Buyer->FULLNAME }}
        </div>
        <div class="text-gray-400">
          {{ $portfolio->MasterUser->Artist->ROLE }}
        </di>
    </div>
  </div>
</div>
</div>

<!-- Suggested Artists -->
@if($artistRecommendations->count() > 0)
<div class="w-full mt-8">
    <h2 class="text-xl font-bold text-black">Suggested Artists</h2>
    <div class="grid grid-cols-2 gap-4 mt-4">
        
        <!-- Artist 1 -->
        @foreach($artistRecommendations as $artist)
        <a href="{{ route('artist.show', ['id'=>$artist->ARTIST_ID,'section'=>'home']) }}">
          <div class="flex flex-col items-center">
              <!-- Name and More Button -->
              <div class="flex justify-between w-full px-2 mb-2">
                  <p class="text-black font-bold">{{ $artist->MasterUser->Buyer->FULLNAME }}</p>
              </div>
              <!-- Image Border -->
              <div class="relative w-full">
                  <img src="{{ $artist->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($artist->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Sosaku Artwork" class="w-full h-40 object-cover rounded-lg">
              </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
</div>
@endif

  <!-- Edit Portfolio Modal -->
<div id="editPortfolioModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-5xl h-[90vh] overflow-y-auto" 
  x-data="{ 
     uploadOption: '{{ Str::startsWith($portfolio->ArtImages()->first()->IMAGE_PATH, "images/art/") ? "file" : "link" }}', 
     imagePreview: '{{ Str::startsWith($portfolio->ArtImages()->first()->IMAGE_PATH, "images/art/") ? asset($portfolio->ArtImages()->first()->IMAGE_PATH) : $portfolio->ArtImages()->first()->IMAGE_PATH }}' 
  }">

 <!-- Modal Header -->
 <div class="flex justify-between items-center border-b pb-4 mb-6">
     <h2 class="text-2xl font-bold text-gray-800">Edit Portfolio</h2>
     <button type="button" onclick="closeEditModal()" class="text-gray-500 hover:text-red-500 text-2xl">&times;</button>
 </div>

 <!-- Form -->
 <form method="POST" action="{{ route('portfolio.update',['portfolioId'=>$portfolio->ART_ID]) }}" enctype="multipart/form-data" class="space-y-6">
     @csrf
     @method('PUT')

     <!-- Title -->
     <div>
         <label for="portfolioTitleEdit" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
         <input type="text" name="title" id="portfolioTitleEdit" value="{{ $portfolio->ART_TITLE }}" 
                class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
     </div>

     <!-- Dimensions -->
     <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
         <div>
             <label for="portfolioHeightEdit" class="block text-sm font-medium text-gray-700 mb-1">Height</label>
             <input type="number" name="portfolioHeight" id="portfolioHeightEdit" value="{{ $portfolio->HEIGHT }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
         </div>
         <div>
             <label for="portfolioWidthEdit" class="block text-sm font-medium text-gray-700 mb-1">Width</label>
             <input type="number" name="portfolioWidth" id="portfolioWidthEdit" value="{{ $portfolio->WIDTH }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
         </div>
         <div>
             <label for="dimensionUnitEdit" class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
             <select name="dimensionUnit" id="dimensionUnitEdit" 
                     class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" required>
                 <option value="CM" {{ $portfolio->UNIT == 'CM' ? 'selected' : '' }}>CM</option>
                 <option value="MM" {{ $portfolio->UNIT == 'MM' ? 'selected' : '' }}>MM</option>
                 <option value="M" {{ $portfolio->UNIT == 'M' ? 'selected' : '' }}>M</option>
             </select>
         </div>
     </div>

     <!-- Description -->
     <div>
         <label for="portfolioDescriptionEdit" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
         <textarea name="description" id="portfolioDescriptionEdit" rows="5" maxlength="150"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500" 
                   oninput="updateCharCount(this)" required>{{ $portfolio->DESCRIPTION }}</textarea>
         <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
             <span id="charCountEdit">0 / 150</span>
             <span id="errorMessageEdit" class="text-red-600 hidden">Maximum 150 characters allowed</span>
         </div>
     </div>

     <!-- Category Selection -->
     <div>
         <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
         <div class="flex items-center gap-3">
             <input type="text" id="selectedCategories" readonly
                 class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-gray-100 cursor-not-allowed" 
                 placeholder="Select categories (max 3)">
             <button type="button" onclick="toggleCategorySelection()" 
                     class="text-indigo-600 hover:text-indigo-800 transition">
                 <i class="fas fa-plus"></i>
             </button>
         </div>

         <!-- Category Dropdown -->
         <div id="categorySelection" class="hidden mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm">
             <h3 class="text-gray-700 font-semibold mb-2">Select Categories</h3>
             <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
             {{-- @foreach($artCategoriesMaster as $artCategorie) --}}
                 <label class="flex items-center space-x-2">
                     <input type="checkbox" class="category-checkbox w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                     <span class="text-gray-700"> {{-- {{ $artCategorie->DESCR }} --}}</span>
                 </label>
             {{--  @endforeach --}}
             </div>
             <span id="portfolioCategoryError" class="text-red-600 text-sm hidden">You can select up to 3 categories only.</span>
         </div>
     </div>

     <!-- Image Upload Section -->
     <div>
         <label class="block text-sm font-medium text-gray-700 mb-2">Image Upload Option</label>
         <div class="flex items-center gap-4 mb-4">
             <label class="flex items-center">
                 <input type="radio" name="imageOption" value="link" x-model="uploadOption" class="mr-2">
                 <span>Image URL</span>
             </label>
             <label class="flex items-center">
                 <input type="radio" name="imageOption" value="file" x-model="uploadOption" class="mr-2">
                 <span>Upload New File</span>
             </label>
         </div>

         <div x-show="uploadOption === 'link'" class="transition">
             <label for="imageLinkEdit" class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
             <input type="text" name="imageLink" id="imageLinkEdit"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                    @input="imagePreview = $event.target.value">
         </div>

         <div x-show="uploadOption === 'file'" class="transition">
             <label for="imageFileEdit" class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
             <input type="file" name="imageFile" id="imageFileEdit" accept="image/*"
                    @change="imagePreview = URL.createObjectURL($event.target.files[0])"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
         </div>

         <!-- Image Preview -->
         <div>
             <p class="text-sm font-medium text-gray-700 mb-2">Image Preview</p>
             <img :src="imagePreview" alt="Image Preview" 
                  class="w-full h-64 object-cover rounded-lg border border-gray-200">
         </div>
     </div>

     <!-- Buttons -->
     <div class="flex justify-end space-x-4 border-t pt-4">
         <button type="button" onclick="closeEditModal()" 
                 class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">Cancel</button>
         <button type="submit" 
                 class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">Save Changes</button>
     </div>
 </form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    function openEditPortfolioModal() {
        document.getElementById('editPortfolioModal').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('editPortfolioModal').classList.add('hidden');
    }
    function updateCharCount(textarea) {
        const maxLength = 150;
        const charCount = textarea.value.length;

        const charCountSpan = document.getElementById('charCount');
        const errorMessage = document.getElementById('errorMessage');

        charCountSpan.textContent = `${charCount} / ${maxLength}`;

        if (charCount > maxLength) {
            errorMessage.classList.remove('hidden');
            textarea.value = textarea.value.substring(0, maxLength); // Truncate excess characters
            charCountSpan.textContent = `${maxLength} / ${maxLength}`;
        } else {
            errorMessage.classList.add('hidden');
        }
    }
    // Update the selected categories display
    document.querySelectorAll('.category-checkbox').forEach((checkbox) => {
        checkbox.addEventListener('change', () => {
            const selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(
                (checkbox) => checkbox.nextSibling.textContent.trim()
            );
            if (selectedCategories.length > 3) {
                checkbox.checked = false;
                alert('You can select up to 3 categories.');
            } else {
                document.getElementById('selectedCategories').value = selectedCategories.join(', ');
            }
        });
    });
</script>

</body>
</html>
