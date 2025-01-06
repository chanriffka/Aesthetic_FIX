<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans">
  <div class="bg-gray-100 min-h-screen py-10">
    <div class="container mx-auto px-6 lg:px-8">
      <h1 class="text-4xl font-bold text-gray-800 text-center mb-10">Blog</h1>

      <!-- Blog Articles Container -->
      <div id="blogContainer" class="grid gap-10 lg:grid-cols-3 sm:grid-cols-2 grid-cols-1">
        @foreach($blogs as $blogItem)
          <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition duration-300">
            <img src="{{ asset($blogItem->IMAGE_PATH) }}" alt="Blog Image" class="w-full h-48 rounded-t-lg object-cover">
            <div class="p-6">
              <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $blogItem->TITLE }}</h3>
              <p class="text-gray-600 mb-4">{{ \Illuminate\Support\Str::limit($blogItem->CONTENT, 64) }}</p>
              <div class="flex justify-between items-center">
                <a href="{{ route('blog.preview',['slug'=>$blogItem->SLUG]) }}" class="text-indigo-600 hover:text-indigo-700 font-medium">Read More &rarr;</a>
                <span class="text-gray-400 text-sm">{{ (new \DateTime($blogItem->created_at))->format('M d, Y') }}</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <!-- Load More Button -->
      <div class="text-center mt-10">
        <button id="loadMoreButton" class="px-8 py-3 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 transition">
          Load More
        </button>
      </div>
    </div>
    <footer class="bg-indigo-600 border-t border-slate-50 mt-10">
        <div class="container mx-auto py-8 px-6 lg:px-8 text-center">
          
          <!-- Navigation Links -->
          <div class="flex justify-center space-x-8 mb-6 text-white">
            <a href="#" class="hover:text-yellow-300 transition">About</a>
            <a href="#" class="hover:text-yellow-300 transition">Blog</a>
            <a href="#" class="hover:text-yellow-300 transition">Jobs</a>
            <a href="#" class="hover:text-yellow-300 transition">Press</a>
            <a href="#" class="hover:text-yellow-300 transition">Accessibility</a>
            <a href="#" class="hover:text-yellow-300 transition">Partners</a>
          </div>
      
          <!-- Social Media Icons -->
          <div class="flex justify-center space-x-6 text-yellow-300 mb-4">
            <a href="#" class="hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="hover:text-white transition"><i class="fab fa-instagram"></i></a>
            <a href="#" class="hover:text-white transition"><i class="fab fa-twitter"></i></a>
            <a href="#" class="hover:text-white transition"><i class="fab fa-github"></i></a>
            <a href="#" class="hover:text-white transition"><i class="fab fa-youtube"></i></a>
          </div>
      
          <!-- Copyright Text -->
          <p class="text-white text-sm">&copy; 2024 Aesthetic, Inc. All rights reserved.</p>
        </div>
      </footer>
</body>

</html>
