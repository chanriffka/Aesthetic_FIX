<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Detail</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans leading-relaxed text-gray-800">
  <div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-6 lg:px-10 space-y-10">
      
      <!-- Blog Header Section -->
      <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden transition hover:shadow-2xl">
        <div class="relative">
          <img src="{{ asset($blog->IMAGE_PATH) }}" alt="Blog Header Image" class="w-full h-[500px] object-cover transition-transform duration-500 hover:scale-105">
          <div class="absolute bottom-0 bg-gradient-to-t from-black via-transparent w-full p-8 text-white">
            <h1 class="text-5xl font-bold mb-2">{{ $blog->TITLE }}</h1>
            <div class="mt-2 text-lg flex items-center space-x-3">
              <span>By <span class="font-semibold">Aesthetic</span></span>
              <span>&bull;</span>
              <span>{{ (new \DateTime($blog->created_at))->format('M d, Y') }}</span>
            </div>
          </div>
        </div>
        
        <!-- Blog Content -->
        <div class="p-10 md:p-14 lg:p-16 bg-gray-50">
          <div class="prose prose-xl max-w-none leading-relaxed text-gray-700">
            <p>{!! nl2br(e($blog->CONTENT)) !!}</p>
            
            {{-- <h2 class="text-3xl font-semibold text-gray-800 mt-10 mb-4">Getting Started with Digital Art</h2>
            <img src="https://images.unsplash.com/photo-1541233349642-6e425fe6190e?q=80&w=2400&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Digital Art Tools" class="w-full h-80 rounded-lg object-cover my-6 shadow-lg transition-transform duration-500 hover:scale-105">
            <p>For beginners, start by choosing the right software and tools. Programs like Adobe Photoshop, Procreate, and Clip Studio Paint offer powerful features that let you create professional-level artwork from the comfort of your home. These programs come with customizable brushes, layers, and color adjustment tools, which make them ideal for all kinds of artwork.</p>
            
            <h2 class="text-3xl font-semibold text-gray-800 mt-10 mb-4">Exploring Different Art Styles</h2>
            <p>Digital art allows you to easily switch between art styles, from realism to abstract, and even 3D rendering. Experimenting with styles is crucial as it helps you discover what resonates most with your creative vision. Try everything from pixel art to hyperrealism and find what works best for you.</p>

            <blockquote class="border-l-4 border-indigo-600 pl-4 my-8 text-gray-700 italic">
              “Art is not what you see, but what you make others see.” – Edgar Degas
            </blockquote>

            <h2 class="text-3xl font-semibold text-gray-800 mt-10 mb-4">Tools to Enhance Your Workflow</h2>
            <p>Aside from art software, hardware tools like graphic tablets and styluses are essential for digital artists. Tablets like the Wacom Intuos or iPad Pro with the Apple Pencil provide precise control over brush strokes and enhance the creative experience. These tools are especially helpful for artists aiming to achieve intricate details.</p> --}}
          </div>
          
          <!-- Back to Blog Link -->
          <a href="{{ route('admin.blog.show') }}" class="text-indigo-600 hover:text-indigo-700 font-medium mt-10 inline-block">← Back to Blog</a>
        </div>
      </div>
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
