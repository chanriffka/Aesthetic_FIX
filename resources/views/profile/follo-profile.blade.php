<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    .tab-button {
      position: relative;
      padding-bottom: 4px;
    }

    .tab-button.active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 3px;
      background-color: #4f46e5; /* Indigo color for underline */
      border-radius: 3px;
      transition: width 0.3s ease-in-out;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto p-6 max-w-3xl">
    <!-- Toggle Navigation -->
    <div class="flex justify-center space-x-8 mb-8 border-b border-gray-200 pb-4">
      <button id="followersTab" class="tab-button text-lg font-semibold text-gray-600 active" onclick="showSection('followers')">
        Followers
      </button>
      <button id="followingTab" class="tab-button text-lg font-semibold text-gray-600" onclick="showSection('following')">
        Following
      </button>
    </div>

    <!-- Followers Section -->
    <div id="followersSection" class="bg-white rounded-lg shadow-md p-6 border border-gray-200 space-y-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Followers</h2>
      <div class="space-y-6">
        @foreach($followers as $follower)
        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
          <div class="flex items-center space-x-4">
            <img src="{{ $follower->Follower->Buyer->PROFILE_IMAGE_URL != null ? asset($follower->Follower->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Profile picture" class="w-12 h-12 rounded-full object-cover">
            <div>
              <p class="text-lg font-semibold text-gray-800">{{ $follower->Follower->Buyer->FULLNAME }}</p>
              <p class="text-gray-500 text-sm">{{ $follower->Follower->USERNAME }}</p>
            </div>
          </div>
          @if($follower->Follower->Artist)
            @if($follower->Follower->USER_ID != Auth::user()->USER_ID)
              @if(Auth::user()->isFollowing($follower->Follower->USER_ID))
              <button onclick="window.location.href='{{ route('unfollow', ['userId' => $follower->Follower->USER_ID]) }}'" class="bg-gray-600 text-white px-4 py-2 rounded-full shadow hover:bg-gray-700 transition duration-200">
                Followed
              </button>
              @else
              <button onclick="window.location.href='{{ route('follow', ['userId' => $follower->Follower->USER_ID]) }}'" class="bg-indigo-600 text-white px-4 py-2 rounded-full shadow hover:bg-indigo-700 transition duration-200">
                Follow
              </button>
              @endif
            @endif
          @endif
        </div>
        @endforeach
      </div>
    </div>

    <!-- Following Section -->
    <div id="followingSection" class="bg-white rounded-lg shadow-md p-6 border border-gray-200 space-y-6 hidden">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Following</h2>
      <div class="space-y-6">
        <!-- Following Item 1 -->
        @foreach($followings as $following)
        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
          <div class="flex items-center space-x-4">
            <img src="{{ $following->Followed->Buyer->PROFILE_IMAGE_URL != null ? asset($following->Followed->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Profile picture" class="w-12 h-12 rounded-full object-cover">
            <div>
              <p class="text-lg font-semibold text-gray-800">{{ $following->Followed->Buyer->FULLNAME }}</p>
              <p class="text-gray-500 text-sm">{{ $following->Followed->USERNAME }}</p>
            </div>
          </div>
          @if($following->Followed->Artist)
            @if($following->Followed->USER_ID != Auth::user()->USER_ID)
              @if(Auth::user()->isFollowing($following->Followed->USER_ID))
              <button onclick="window.location.href='{{ route('unfollow', ['userId' => $following->Followed->USER_ID]) }}'" class="bg-gray-600 text-white px-4 py-2 rounded-full shadow hover:bg-gray-700 transition duration-200">
                Followed
              </button>
              @else
              <button onclick="window.location.href='{{ route('follow', ['userId' => $following->Followed->USER_ID]) }}'" class="bg-indigo-600 text-white px-4 py-2 rounded-full shadow hover:bg-indigo-700 transition duration-200">
                Follow
              </button>
              @endif
            @endif
          @endif
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- JavaScript for Tab Switching and Follow Toggle -->
  <script>
    function showSection(section) {
      const followersTab = document.getElementById('followersTab');
      const followingTab = document.getElementById('followingTab');
      const followersSection = document.getElementById('followersSection');
      const followingSection = document.getElementById('followingSection');

      if (section === 'followers') {
        followersTab.classList.add('active', 'text-indigo-600');
        followingTab.classList.remove('active', 'text-indigo-600');
        followersSection.classList.remove('hidden');
        followingSection.classList.add('hidden');
      } else {
        followingTab.classList.add('active', 'text-indigo-600');
        followersTab.classList.remove('active', 'text-indigo-600');
        followingSection.classList.remove('hidden');
        followersSection.classList.add('hidden');
      }
    }

    function toggleFollow(button) {
      if (button.textContent.trim() === 'Follow') {
        button.textContent = 'Following';
        button.classList.replace('bg-indigo-600', 'bg-gray-200');
        button.classList.replace('hover:bg-indigo-700', 'hover:bg-gray-300');
        button.classList.replace('text-white', 'text-gray-800');
      } else {
        button.textContent = 'Follow';
        button.classList.replace('bg-gray-200', 'bg-indigo-600');
        button.classList.replace('hover:bg-gray-300', 'hover:bg-indigo-700');
        button.classList.replace('text-gray-800', 'text-white');
      }
    }
  </script>
</body>
</html>
