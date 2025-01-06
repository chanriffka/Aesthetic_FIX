<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Followers</title>
</head>
<body class="bg-gray-100">
        <div class="container mx-auto p-6 max-w-3xl">
        <div id="followersSection" class="bg-white rounded-lg shadow-md p-6 border border-gray-200 space-y-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Followers</h2>

        <div class="space-y-6">
            <!-- Follower Item 1 -->
        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
          <div class="flex items-center space-x-4">
            <img src="https://i.pinimg.com/474x/8e/16/19/8e16199929c4a57545af537dcd28a60e.jpg" alt="Profile picture" class="w-12 h-12 rounded-full object-cover">
            <div>
              <p class="text-lg font-semibold text-gray-800">geriwalker</p>
              <p class="text-gray-500 text-sm">Intuitive for art</p>
            </div>
          </div>
          <button onclick="toggleFollow(this)" class="bg-indigo-600 text-white px-4 py-2 rounded-full shadow hover:bg-indigo-700 transition duration-200">
            Follow
          </button>
        </div>

        <!-- Follower Item 2 -->
        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
          <div class="flex items-center space-x-4">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSn9ahvM1UyxQcSo9qd6ZVo7H5IaNVlUv6wBrzpUFyWN49P8MQwJM7mJU_whJTd4Sgo28&usqp=CAU" alt="Profile picture" class="w-12 h-12 rounded-full object-cover">
            <div>
              <p class="text-lg font-semibold text-gray-800">feature.art</p>
              <p class="text-gray-500 text-sm">Your feature heavenly art</p>
            </div>
          </div>
          <button onclick="toggleFollow(this)" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-full shadow hover:bg-gray-300 transition duration-200">
            Following
          </button>
        </div>

        <!-- Follower Item 3 -->
        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center space-x-4">
                  <img src="https://i.pinimg.com/236x/b3/82/7d/b3827d55254f65491b2b98f934866d40.jpg" alt="Profile picture" class="w-12 h-12 rounded-full object-cover">
                  <div>
                    <p class="text-lg font-semibold text-gray-800">arts.tech</p>
                    <p class="text-gray-500 text-sm">Art for your oil paint</p>
                  </div>
                </div>
                <button onclick="toggleFollow(this)" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-full shadow hover:bg-gray-300 transition duration-200">
                  Following
                </button>
              </div>
            <!-- Repeat more follower cards as needed -->
        </div>
    </div>

    <script>
        function toggleFollow(button) {
            if (button.classList.contains('bg-indigo-600')) {
                button.classList.remove('bg-indigo-600', 'text-white');
                button.classList.add('bg-gray-200', 'text-gray-800');
                button.textContent = 'Following';
            } else {
                button.classList.add('bg-indigo-600', 'text-white');
                button.classList.remove('bg-gray-200', 'text-gray-800');
                button.textContent = 'Follow Back';
            }
        }
    </script>
</body>
</html>
