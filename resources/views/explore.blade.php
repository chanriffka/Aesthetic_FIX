@extends('layouts.app')

@section('title', 'explore')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore - Aesthetic</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> 
    <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
     .custom-search {
      border-radius: 9999px;
      display: flex;
      background-color: white;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .custom-input {
      flex-grow: 1;
      padding-left: 20px;
      border: none;
      border-radius: 9999px 0 0 9999px;
      background-color: white;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    .custom-button {
      background-color: #6366f1;
      color: white;
      padding: 12px 24px;
      border-radius: 0 9999px 9999px 0;
      cursor: pointer;
      display: inline-block;
      font-size: 16px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .custom-button:hover {
      background-color: #4f46e5;
      transform: scale(1.05);
    }
    .artist-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
    .custom-input:focus {
      outline: none;
      box-shadow: 0 0 8px rgba(99, 102, 241, 0.5);
    }
  </style>
</head>
<body class="bg-gray-100 font-roboto text-gray-700">

<!-- Hero Section Start -->
<section id="hero" class="relative">
    <img alt="Abstract background with pastel colors" class="w-full h-96 object-cover" src="https://storage.googleapis.com/a1aa/image/GAqmcA8MPrZZFpbPetB7noYQN2t7Zka9P9lOBK7fvgmucEjTA.jpg" width="1920" height="400"/>
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white">
        <h1 class="text-5xl font-bold">Discover Inspiring Design Ideas</h1>
        <p class="text-lg mt-4">Find The Perfect Design For Your Next Project</p>
        
        <!-- Search Bar -->
      <div class="mt-8 w-full flex justify-center">
        <div class="relative w-full max-w-xl custom-search">
            <input class="custom-input text-gray-700" placeholder="Search for artists..." type="text" id="searchInput">
            <button class="custom-button" onclick="">Search</button>
        </div>
      </div>
    </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Content Section with white background -->
<div class="bg-white py-10">
    <div class="container mx-auto px-6">
      <!-- Job Count and Filters -->
      <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-bold text-gray-800">{{ number_format($arts->count(), 0, ',', '.') }} Assets</h2>
          <div class="flex items-center space-x-4">
              <div class="relative">
                  <select class="appearance-none pl-4 pr-10 py-2 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500" id="sortSelection">
                      <option value="keywords">Sort by Name</option>
                      <option value="like">Sort by Likes</option>
                      <option value="time">Most Recent</option>
                  </select>
                  <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              </div>
              <div class="relative">
                  <select id="filterField" class="appearance-none pl-4 pr-10 py-2 bg-white border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All</option>
                    @foreach($artCategories as $category)
                      <option value="{{ $category->DESCR }}">{{ $category->DESCR }}</option>
                    @endforeach
                  </select>
                  <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              </div>
          </div>
      </div>

    <!-- Art Gallery Grid Start -->
    <section id="art-gallery" class="py-8">
        <div id="container-art-gallery" class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Example Card 1 -->
            @foreach($arts as $art)
                <div onclick="window.location.href='@if($art->IS_SALE == 0) {{ route('artGallery.show', $art->ART_ID) }} @else {{ route('artwork.show', $art->ART_ID) }} @endif'" class="card art-gallery-card bg-white rounded-lg shadow-md hover:shadow-lg transform transition-transform duration-300 hover:-translate-y-1" data-time="{{ $art->created_at }}" data-like="{{ $art->ArtLikes->count() }}" data-keywords="
                    {{ $art->ART_TITLE }}
                    @foreach($art->ArtCategories as $category)
                        {{ $art->ArtCategories->map(fn($category) => $category->ArtCategoryMaster->DESCR)->implode(' ') }}
                    @endforeach">
                    <img src="{{ Str::startsWith($art->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($art->ArtImages()->first()->IMAGE_PATH) : $art->ArtImages()->first()->IMAGE_PATH }}" alt="Night Kingdom of Fantasy" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900">{{ $art->ART_TITLE }}</h3>
                        <p class="text-sm text-gray-500">{{ $art->MasterUser->Buyer->FULLNAME }}</p>
                        <div class="flex justify-between items-center mt-2 text-gray-500 text-sm">
                            <div class="flex items-center space-x-1">
                                @if(Auth::user() != null)
                                <a href="{{ route('artwork.like',['id'=>$art->ART_ID]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="@if($art->isLiked()) currentColor @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-pink-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                </a>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-pink-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                @endif
                                <span>{{ $art->ArtLikes->count() }}</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                                <span>{{ $art->VIEW }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        
    </section>

    <!-- Art Gallery Grid End -->
</div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const items = document.querySelectorAll('.art-gallery-card');

            items.forEach(item => {

                const itemName = item.getAttribute('data-keywords').toLowerCase();
                console.log(itemName)
                if (itemName.includes(searchValue)) {
                    item.style.display = 'block'; // Show the item
                } else {
                    item.style.display = 'none'; // Hide the item
                }
            });
        });

        document.getElementById('filterField').addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const items = document.querySelectorAll('.art-gallery-card');

            items.forEach(item => {

                const itemName = item.getAttribute('data-keywords').toLowerCase();
                console.log(itemName)
                if (itemName.includes(searchValue)) {
                    item.style.display = 'block'; // Show the item
                } else {
                    item.style.display = 'none'; // Hide the item
                }
            });
        });

        document.getElementById('sortSelection').addEventListener('input', function () {
            const sortValue = this.value.toLowerCase();
            if (sortValue == "like") {
                orderByLike()
            } else if (sortValue == "keywords") {
                orderByKeyword()
            } else {
                orderByTime()
            }
        });

        orderByKeyword()

        function orderByLike() {
            // Get the container element
            const container = document.getElementById('container-art-gallery');

            // Select all divs with a data-like attribute inside the container
            const divs = Array.from(container.querySelectorAll('.art-gallery-card'));

            // Sort the divs based on the data-like attribute in descending order
            divs.sort((a, b) => {
                const likeA = parseInt(a.getAttribute('data-like'), 10);
                const likeB = parseInt(b.getAttribute('data-like'), 10);
                console.log("a")
                console.log("a"+likeA)
                console.log("b")
                console.log("b"+likeB)

                return likeB - likeA; // Descending order
            });

            // Append the sorted divs back to the container
            divs.forEach(div => container.appendChild(div));
        }


        function orderByKeyword() {
            // Get the container element
            const container = document.getElementById('container-art-gallery');

            // Select all divs with a data-keywords attribute inside the container
            const divs = Array.from(container.querySelectorAll('.art-gallery-card'));

            // Sort the divs based on the data-keywords attribute (case-insensitive comparison)
            divs.sort((a, b) => {
                const nameA = a.getAttribute('data-keywords').toLowerCase();
                const nameB = b.getAttribute('data-keywords').toLowerCase();

                return nameA.localeCompare(nameB); // Ascending order
            });

            // Append the sorted divs back to the container
            divs.forEach(div => container.appendChild(div));
        }

        function orderByTime() {
            // Get the container element
            const container = document.getElementById('container-art-gallery');

            // Select all divs with a data-keywords attribute inside the container
            const divs = Array.from(container.querySelectorAll('.art-gallery-card'));

            // Sort the divs based on the data-keywords attribute (case-insensitive comparison)
            divs.sort((a, b) => {
                const timeA = new Date(a.getAttribute('data-time')).getTime();
                const timeB = new Date(b.getAttribute('data-time')).getTime();

                return timeB - timeA; // Latest first
            });

            // Append the sorted divs back to the container
            divs.forEach(div => container.appendChild(div));
        }

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('.scroll-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Typing Effect for Heading
        const typingText = document.getElementById('typing-text');
        const textArray = typingText.textContent.split('');
        typingText.textContent = '';
        let i = 0;
        const typingEffect = setInterval(() => {
            if (i < textArray.length) {
                typingText.textContent += textArray[i];
                i++;
            } else {
                clearInterval(typingEffect);
            }
        }, 100);

        // Carousel Auto-Sliding
        const slides = document.querySelectorAll('#carousel img');
        const totalSlides = slides.length;
        let currentIndex = 0;

        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');
        const carousel = document.getElementById('carousel');

        function updateSlide(newIndex) {
            carousel.style.transform = `translateX(-${newIndex * 100}%)`;
            currentIndex = newIndex;
        }

        prevButton.addEventListener('click', () => {
            const newIndex = currentIndex > 0 ? currentIndex - 1 : totalSlides - 1;
            updateSlide(newIndex);
        });

        nextButton.addEventListener('click', () => {
            const newIndex = currentIndex < totalSlides - 1 ? currentIndex + 1 : 0;
            updateSlide(newIndex);
        });

        let autoSlideInterval = setInterval(() => {
            const newIndex = currentIndex < totalSlides - 1 ? currentIndex + 1 : 0;
            updateSlide(newIndex);
        }, 5000);

        carousel.addEventListener('mouseover', () => clearInterval(autoSlideInterval));
        carousel.addEventListener('mouseout', () => {
            autoSlideInterval = setInterval(() => {
                const newIndex = currentIndex < totalSlides - 1 ? currentIndex + 1 : 0;
                updateSlide(newIndex);
            }, 5000);
        });

        // Scroll Animations
        const scrollElements = document.querySelectorAll('.scroll-animation');
        
        const elementInView = (el, dividend = 1) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <= (window.innerHeight || document.documentElement.clientHeight) / dividend
            );
        };
        
        const displayScrollElement = (element) => {
            element.classList.add('is-visible');
        };
        
        const handleScrollAnimation = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 1.25)) {
                    displayScrollElement(el);
                }
            });
        };
        
        window.addEventListener('scroll', () => {
            handleScrollAnimation();
        });

        handleScrollAnimation();

        // Filter Gallery by Category
        const categoryFilter = document.getElementById('categoryFilter');
        const cards = document.querySelectorAll('.card');

        categoryFilter.addEventListener('change', function() {
            const selectedCategory = this.value;

            cards.forEach(card => {
                if (selectedCategory === 'all' || card.classList.contains(`category-${selectedCategory}`)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
@endsection