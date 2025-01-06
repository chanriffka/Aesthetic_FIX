<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Aesthetic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Overlay Effect */
        .overlay-content {
            background: rgba(31, 41, 55, 0.7);
            color: #ffffff;
            transition: opacity 0.3s ease;
        }
    </style>
</head>

<body class="bg-white text-gray-700 font-sans overflow-x-hidden">

    <!-- Parallax Header Section -->
    <header class="relative h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://plus.unsplash.com/premium_vector-1689096927149-d281c5cf4894?q=80&w=2920&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        <div class="absolute inset-0 bg-white opacity-90"></div>
        <div class="relative z-10 text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-indigo-700 mb-4 fade-in">About Aesthetic</h1>
            <p class="text-xl text-gray-600 max-w-xl mx-auto fade-in">Empowering Indonesia's Art Community and Inspiring Creativity</p>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 mt-8 rounded-full font-semibold transition duration-300 fade-in">What is Aesthetic? </button>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="container mx-auto px-6 md:px-12 py-16">

        <!-- What is Aesthetic Section -->
        <section class="text-center mb-20 fade-in">
            <h2 class="text-4xl font-semibold text-indigo-700 mb-8">What is Aesthetic?</h2>
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="w-full md:w-1/2 hover:shadow-lg transition-shadow duration-300 rounded-lg overflow-hidden">
                    <img src="https://plus.unsplash.com/premium_photo-1677609991615-0657859f0a8a?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="What is Aesthetic" class="w-full h-80 object-cover transform hover:scale-105 transition duration-300">
                </div>
                <p class="text-lg text-gray-600 max-w-lg leading-relaxed">Aesthetic is more than a marketplace; it’s a movement that celebrates the creativity and spirit of Indonesia's art community. We connect artists and art lovers, making it easy to discover, buy, and sell unique pieces from talented creators across Indonesia.</p>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="bg-indigo-50 text-center py-12 px-6 rounded-lg mb-20 hover:shadow-xl transition-shadow duration-300 fade-in">
            <h2 class="text-3xl font-semibold text-indigo-700 mb-6">Our Mission</h2>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">To empower artists and bring art into everyday life. We support local artists, foster a thriving creative economy, and make art accessible and appreciated in Indonesia. Our vision is a sustainable future for art and artists.</p>
        </section>

        <!-- Why Choose Aesthetic Section -->
        <section class="text-center mb-20 fade-in">
            <h2 class="text-4xl font-semibold text-indigo-700 mb-12">Why Choose Aesthetic?</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="relative group hover:shadow-lg transition-shadow duration-300 rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1582481426757-274f94eecb72?q=80&w=3058&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Curated Art Selections" class="w-full h-80 object-cover transition-transform duration-300 transform group-hover:scale-105">
                    <div class="absolute inset-0 flex items-center justify-center overlay-content opacity-0 group-hover:opacity-100">
                        <span class="text-lg font-semibold">Curated Art Selections</span>
                    </div>
                    <p class="text-lg text-gray-600 mt-4 px-4">Aesthetic offers carefully curated artwork, selected not only for beauty but for the unique story and passion of each artist.</p>
                </div>
                <div class="relative group hover:shadow-lg transition-shadow duration-300 rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1569783721854-33a99b4c0bae?q=80&w=2928&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Support for Local Artists" class="w-full h-80 object-cover transition-transform duration-300 transform group-hover:scale-105">
                    <div class="absolute inset-0 flex items-center justify-center overlay-content opacity-0 group-hover:opacity-100">
                        <span class="text-lg font-semibold">Support for Local Artists</span>
                    </div>
                    <p class="text-lg text-gray-600 mt-4 px-4">Every purchase directly supports Indonesian artists, helping them sustain their craft and continue creating.</p>
                </div>
                <div class="relative group hover:shadow-lg transition-shadow duration-300 rounded-lg overflow-hidden">
                    <img src="https://media.istockphoto.com/id/1398697045/photo/the-black-plastic-credit-card-is-in-3d-hands-of-two-women-holding-it-from-different-sides.webp?a=1&b=1&s=612x612&w=0&k=20&c=FqmjAUE-MrIor9_CduDVeWen6on2JXOl-gKbbzOgKKg=" alt="Safe and Simple Transactions" class="w-full h-80 object-cover transition-transform duration-300 transform group-hover:scale-105">
                    <div class="absolute inset-0 flex items-center justify-center overlay-content opacity-0 group-hover:opacity-100">
                        <span class="text-lg font-semibold">Safe and Simple Transactions</span>
                    </div>
                    <p class="text-lg text-gray-600 mt-4 px-4">Our platform ensures secure and transparent transactions, so you can focus on finding art you love without hassle.</p>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="text-center mb-20 fade-in">
            <h2 class="text-4xl font-semibold text-indigo-700 mb-12">Our Features</h2>
            <div class="grid md:grid-cols-3 gap-12">
                <div class="relative group hover:shadow-lg transition-shadow duration-300 rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1561926797-fa9e23386fe6?q=80&w=2942&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Discover New Artists" class="w-full h-80 object-cover transition-transform duration-300 transform group-hover:scale-105">
                    <div class="absolute inset-0 flex items-center justify-center overlay-content opacity-0 group-hover:opacity-100">
                        <span class="text-lg font-semibold">Discover New Artists</span>
                    </div>
                    <p class="text-lg text-gray-600 mt-4 px-4">Explore artworks by both emerging and established artists from across Indonesia.</p>
                </div>
                <div class="relative group hover:shadow-lg transition-shadow duration-300 rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1565799515768-2dcfd834625c?q=80&w=3019&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Customizable Collections" class="w-full h-80 object-cover transition-transform duration-300 transform group-hover:scale-105">
                    <div class="absolute inset-0 flex items-center justify-center overlay-content opacity-0 group-hover:opacity-100">
                        <span class="text-lg font-semibold">Customizable Collections</span>
                    </div>
                    <p class="text-lg text-gray-600 mt-4 px-4">Curate your favorite pieces and personalize your experience with our customizable features.</p>
                </div>
                <div class="relative group hover:shadow-lg transition-shadow duration-300 rounded-lg overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1693829957089-671ff2b0a5de?q=80&w=2960&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Insights and Stories" class="w-full h-80 object-cover transition-transform duration-300 transform group-hover:scale-105">
                    <div class="absolute inset-0 flex items-center justify-center overlay-content opacity-0 group-hover:opacity-100">
                        <span class="text-lg font-semibold">Insights and Stories</span>
                    </div>
                    <p class="text-lg text-gray-600 mt-4 px-4">Gain insights into each artwork’s inspiration, techniques, and background.</p>
                </div>
            </div>
        </section>

        <!-- Join Us Section -->
        <section class="bg-indigo-600 text-white rounded-lg py-12 px-6 text-center mb-20 hover:shadow-2xl transition-shadow duration-300 fade-in">
            <h2 class="text-4xl font-semibold mb-6">Join Us on This Journey</h2>
            <p class="text-lg max-w-3xl mx-auto mb-8">Whether you’re an artist or a collector, Aesthetic is here to support your journey. Join our community and help us make the world a more creative and inspiring place.</p>
            <button class="bg-white text-indigo-600 hover:text-indigo-700 font-semibold px-8 py-3 rounded-full transition duration-300">Get Started</button>
        </section>
    </main>
    
        <!-- Footer Section -->
        <footer class="bg-indigo-600 text-white py-12 mt-16 fade-in" id="footer">
            <div class="container mx-auto px-6">
                <div class="flex flex-wrap justify-between">
                    <div class="w-full lg:w-1/3 mb-8 lg:mb-0">
                        <h3 class="text-lg font-bold text-yellow-300">About Aesthetic</h3>
                        <p class="mt-4 text-white leading-relaxed">
                            Aesthetic connects artists and art enthusiasts across Indonesia. Join us in building a thriving artistic community that celebrates creativity and local talent.
                        </p>
                    </div>
                    
                    <div class="w-full lg:w-1/3 mb-8 lg:mb-0">
                        <h3 class="text-lg font-bold text-yellow-300">Have a Question?</h3>
                        <form class="mt-4 space-y-4">
                            <div>
                                <label for="faqName" class="block text-sm font-medium text-white">Your Name</label>
                                <input type="text" id="faqName" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-800 text-white focus:ring-2 focus:ring-yellow-300 focus:outline-none" placeholder="Your Name" required>
                            </div>
                            <div>
                                <label for="faqEmail" class="block text-sm font-medium text-white">Your Email</label>
                                <input type="email" id="faqEmail" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-800 text-white focus:ring-2 focus:ring-yellow-300 focus:outline-none" placeholder="Your Email" required>
                            </div>
                            <div>
                                <label for="faqMessage" class="block text-sm font-medium text-white">Your Question</label>
                                <textarea id="faqMessage" rows="3" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-800 text-white focus:ring-2 focus:ring-yellow-300 focus:outline-none" placeholder="Type your question..." required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-yellow-300 text-primary font-bold px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-400 transition">
                                Submit Question
                            </button>
                        </form>
                    </div>
                </div>
                <div class="mt-12 text-center border-t border-secondary pt-6">
                    <p class="text-sm text-white">
                        © 2024 Aesthetic. All rights reserved. | <a href="#" class="text-yellow-300 hover:underline">Privacy Policy</a> | <a href="#" class="text-yellow-300 hover:underline">Terms of Service</a>
                    </p>
                </div>
            </div>
        </footer>

    <script>
        // Scroll Animation for Fade-In
        const fadeInElements = document.querySelectorAll('.fade-in');
        window.addEventListener('scroll', () => {
            fadeInElements.forEach(element => {
                const position = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                if (position < screenPosition) {
                    element.classList.add('show');
                }
            });
        });
    </script>

</body>

</html>
