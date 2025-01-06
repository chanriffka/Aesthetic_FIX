@extends('layouts.app')

@section('title', 'landing')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aesthetic</title>
    <!-- Updated to match artist list font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 
    <link href="{{ URL::asset('/css/output.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> 
        body {
            font-family: 'Roboto', sans-serif; 
            background-color: #f7f8fa;
            color: #333;
        }
        h1, h2, h3 {
            font-family: 'Roboto', sans-serif; 
        }
        a {
            transition: color 0.3s ease, background-color 0.3s ease;
        }
    </style>
</head>
<body>


    <!-- Home Page Start -->
    <section id="artists" class="relative bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
        <div class="relative w-full h-[80vh] overflow-hidden flex items-center justify-center">
            <!-- Carousel -->
            <div class="relative w-full h-full">
                <div class="absolute inset-0 bg-white opacity-50"></div>
                <div class="relative w-full h-full flex transition-transform" id="carousel">
                    <!-- Slide 1 -->
                    <img src="{{ URL::asset('images/homepage6.JPG') }}" alt="Art Image 1" class="w-full h-full object-cover rounded-lg flex-shrink-0 opacity-75">
                    <!-- Slide 2 -->
                    <img src="{{ URL::asset('images/homepage7.JPG') }}" alt="Art Image 2" class="w-full h-full object-cover rounded-lg flex-shrink-0 opacity-75">
                    <!-- Slide 3 -->
                    <img src="{{ URL::asset('images/homepage3.jpeg') }}" alt="Art Image 3" class="w-full h-full object-cover rounded-lg flex-shrink-0 opacity-75">
                </div>
                <!-- Overlay Text -->
                <div class="absolute inset-0 flex flex-col justify-center items-center text-center p-8 z-10 text-white">
                  <h1 id="typing-text" class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">
                      DISCOVER EVERY ART THROUGH VARIOUS DESIGNER
                  </h1>
                  <p class="text-lg md:text-xl mb-6 max-w-2xl">
                      Embark on an Artistic Odyssey: Navigate the Expressive Universes Crafted by Our Featured Designers
                  </p>
                  <a href="#" class="bg-green-500 text-white px-6 py-3 rounded-full hover:bg-green-600">Explore</a>
              </div>
              
            <!-- Left Arrow -->
            <button id="prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 p-3 bg-white bg-opacity-50 rounded-full hover:bg-opacity-75 z-10">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <!-- Right Arrow -->
            <button id="next" class="absolute right-0 top-1/2 transform -translate-y-1/2 p-3 bg-white bg-opacity-50 rounded-full hover:bg-opacity-75 z-10">
                <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </section>
    <!-- Home Page End -->

    <!-- Services Section Start -->
    <section id="explore" class="py-16 bg-white scroll-animation">
        <div class="container mx-auto flex flex-wrap justify-between items-center">
            <div class="w-full md:w-1/2 px-4">
                <h2 class="text-4xl font-bold text-gray-800 leading-tight">
                    The Perfect Home For Designers and Art Enthusiasts
                </h2>
            </div>
            <div class="w-full md:w-1/2 px-4">
                <p class="text-gray-600 mb-4">
                    Crafting Inspiring Designs is Our Expertise. We elevate your vision with captivating Poster Designs, Distinctive Logo Creations, and Custom Commissions. <span class="font-bold">Your satisfaction and creative vision are our top priorities</span>.
                </p>
                <p class="text-gray-600 mb-6">
                    We provide a variety of <span class="font-bold">professional services</span> including Contemporary Art, 3D Art Design, and Custom Art Commissions.
                </p>
                <a href="{{ url('login') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700">See All Services</a>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Additional Services Section Start -->
    <section id="art-gallery" class="py-16 bg-gray-100 scroll-animation">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center">
                <!-- Card 1 -->
                <div class="w-full md:w-1/2 lg:w-1/5 p-4">
                    <a href="#" class="block bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105">
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800">Poster Design</h3>
                            <p class="text-gray-600 mb-4">
                                Our poster design service is curated by seasoned professionals, to leave a lasting impression on your audience.
                            </p>
                        </div>
                        <img src="{{ URL::asset('images/poster-design.PNG') }}" alt="Poster Design" class="w-full h-70 object-cover">
                    </a>
                </div>
                <!-- Card 2 -->
                <div class="w-full md:w-1/2 lg:w-1/5 p-4">
                    <a href="#" class="block bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105">
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800">Abstract Art</h3>
                            <p class="text-gray-600 mb-4">
                                Focused on non-representational and experimental works, playing with colors, shapes, and textures.
                            </p>
                        </div>
                        <img src="{{ URL::asset('images/3d-art.jpeg') }}" alt="Abstract Art" class="w-full h-70 object-cover">
                    </a>
                </div>
                <!-- Card 3 -->
                <div class="w-full md:w-1/2 lg:w-1/5 p-4">
                    <a href="#" class="block bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105">
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800">Contemporary Art</h3>
                            <p class="text-gray-600 mb-4">
                                Reflects modern-day themes, concepts, and innovations in art, often blending traditional and digital media.
                            </p>
                        </div>
                        <img src="{{ URL::asset('images/animate-art.jpeg') }}" alt="Contemporary Art" class="w-full h-90 object-cover">
                    </a>
                </div>
                <!-- Card 4 -->
                <div class="w-full md:w-1/2 lg:w-1/5 p-4">
                    <a href="#" class="block bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105">
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800">Illustration</h3>
                            <p class="text-gray-600 mb-4">
                                Covers hand-drawn and digital illustrations used for storytelling, design, or personal expression.
                            </p>
                        </div>
                        <img src="{{ URL::asset('images/custom-art.jpeg') }}" alt="Illustration" class="w-full h-90 object-cover">
                    </a>
                </div>
                <!-- Card 5 -->
                <div class="w-full md:w-1/2 lg:w-1/5 p-4">
                    <a href="#" class="block bg-white shadow-lg rounded-lg overflow-hidden transform hover:scale-105">
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800">Logo Creation</h3>
                            <p class="text-gray-600 mb-4">
                                Our logo creation service is curated by seasoned professionals, to leave a lasting impression on your audience.
                            </p>
                        </div>
                        <img src="{{ URL::asset('images/logo-art.png') }}" alt="Logo Creation" class="w-full h-70 object-cover">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Additional Services Section End -->

    <!-- Featured Section Start -->
    <section id="home" class="py-16 bg-white scroll-animation">
        <div class="container mx-auto">
            <div class="relative mb-16">
                <img src="{{ URL::asset('images/art-gallery.jpeg') }}" alt="Art Gallery" class="w-full h-96 object-cover rounded-lg">
                <div class="absolute inset-0 flex flex-col justify-center items-start text-white p-8 bg-black bg-opacity-50 rounded-lg">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Dive Into The Exquisite Realm of Imagination and Discover The Boundless Beauty of Creativity In Our Art Gallery</h2>
                    <p class="text-lg mb-6">Your Journey through the Masterpieces Begins Here.</p>
                    <a href="#" class="bg-indigo-600 text-white px-6 py-3 rounded-full hover:bg-indigo-700">Discover Now</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Community Board and Tips Section Start -->
<section id="community-board" class="py-16 bg-white">
   <div class="container mx-auto">
       <div class="flex flex-wrap md:flex-nowrap space-y-6 md:space-y-0 md:space-x-12">
           <!-- Community Board Section -->
           <a href="{{ route('blog.preview',['slug'=>$latestBlog->SLUG]) }}" class="w-full md:w-2/3">
               <h2 class="text-3xl font-bold text-indigo-800 mb-6">{{ $latestBlog->TITLE }}</h2>
               <p class="text-gray-600 mb-6">
                {{ \Illuminate\Support\Str::limit($latestBlog->CONTENT, 128) }}
               </p>
               <img src="{{ asset($latestBlog->IMAGE_PATH) }}" alt="{{ $latestBlog->TITLE }}" class="w-full h-56 object-cover rounded-xl shadow-lg mb-6 transform hover:scale-105 transition">
            </a>
           <!-- Separator Line -->
           <div class="hidden md:block w-px bg-gray-300"></div>
           <!-- Tips, Trends, and Guides Section -->
           <div class="w-full md:w-1/3">
               <h2 class="text-2xl font-bold text-indigo-800 mb-6">Tips, Trends, and Guides</h2>
               <div class="space-y-6">
                   @foreach($blogs as $blog)
                   <a href="{{ route('blog.preview',['slug'=>$blog->SLUG]) }}"  class="flex items-center">
                       <img src="{{ asset($blog->IMAGE_PATH) }}" alt="{{ $blog->TITLE }}" class="w-20 h-20 object-cover rounded-xl shadow-lg mr-6 transform hover:scale-105 transition">
                       <div>
                           <h3 class="text-gray-800 font-semibold mb-1">{{ $blog->TITLE }}</h3>
                           <p class="text-gray-500 text-sm">{{ $blog->created_at->diffForHumans() }}</p>
                       </div>
                    </a>
                   @endforeach
               </div>
               <a href="{{ route('blog.all') }}" class="text-indigo-600 font-semibold hover:underline mt-8 block">Take Me to the Blog →</a>
           </div>
       </div>
   </div>
</section>

    <!-- CTA Section Start -->
    <section id="cta-section" class="relative py-20 bg-gradient-to-b from-white to-white white-900 to-white-800 scroll-animation">
       <div class="container mx-auto">
           <div class="relative rounded-lg overflow-hidden shadow-lg">
               <img src="{{ URL::asset('images/sign-in-cta.jpeg') }}" alt="Star Background" class="w-full h-80 object-cover">
               <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-start text-white p-10">
                   <h2 class="text-3xl md:text-4xl font-extrabold mb-5 leading-tight">
                       Suddenly Grasping Your Elusive Stars Becomes a Tangible Reality
                   </h2>
                   <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-transform duration-300">
                       Sign In
                   </a>
               </div>
           </div>
       </div>
    </section>
    <!-- CTA Section End -->
<!-- Questions & Answers Section -->
<section id="questions-answers" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-lg text-indigo-600 mb-2">Most asked questions</h2>
            <h1 class="text-3xl font-bold text-gray-800">Questions & Answers</h1>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                        <i class="fas fa-question text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">How can I contact customer support?</h3>
                    <p class="text-gray-600">To contact customer support, look for a "Contact us" button or link on the website or platform. You may be able to email or chat with customer support for assistance.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                        <i class="fas fa-question text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">How do I find my purchase history?</h3>
                    <p class="text-gray-600">To find your purchase history, log in and go to the account or purchase history page. Look for a list of your past purchases or orders, and click on any item to see more details.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                        <i class="fas fa-question text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">How to create an Account?</h3>
                    <p class="text-gray-600">To create an account, find the 'Join' button, fill out the registration form with your personal information, and click 'Sign up.' Verify your email address if needed, and then log in to start using the platform.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center">
                        <i class="fas fa-question text-white text-xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-indigo-600 mb-2">How can I join as an artist?</h3>
                    <p class="text-gray-600">To join as an artist, you need to sign up first. Once you have created an account, navigate to your profile and click on the 'Join Artist' option. You will be required to fill out a form with your details and portfolio. </p>
                </div>
            </div>
        </div>
        <div class="mt-12 text-center">
            <div class="bg-indigo-400 rounded-2xl shadow-lg px-6 py-8 inline-block">
                <p class="text-white">
                    Didn’t find the answer you are looking for? 
                    <a href="#" class="text-indigo-600 font-semibold hover:underline">CONTACT SUPPORT</a>
                </p>
            </div>
        </div>
    </div>
</section>

    <script>
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
    </script>
</body>
</html>
@endsection