<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Following</title>
</head>
<body class="bg-gray-100">
        <div class="container mx-auto p-6 max-w-3xl">
        <div id="followersSection" class="bg-white rounded-lg shadow-md p-6 border border-gray-200 space-y-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Following</h2>

        <div class="space-y-6">
            <!-- Sample Following Card -->
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

    <script>
        function toggleFollow(button) {
            if (button.classList.contains('bg-gray-200')) {
                button.classList.remove('bg-gray-200', 'text-gray-800');
                button.classList.add('bg-indigo-600', 'text-white');
                button.textContent = 'Follow';
            } else {
                button.classList.add('bg-gray-200', 'text-gray-800');
                button.classList.remove('bg-indigo-600', 'text-white');
                button.textContent = 'Following';
            }
        }
    </script>
</body>
</html>
