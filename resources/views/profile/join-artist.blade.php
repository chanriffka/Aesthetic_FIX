<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Aesthetic as an Artist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5', // Indigo
                        secondary: '#E0E7FF', // Light Indigo
                        accent: '#F9FAFB', // Background White
                        text: '#374151', // Text Gray
                    },
                },
            },
        };
    </script>
    <style>
        .modal {
            display: none;
        }

        .modal.active {
            display: flex;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 1s ease, transform 1s ease;
            transform: translateY(20px);
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-pattern {
            background: url('https://plus.unsplash.com/premium_photo-1706571538809-004cea5a5518?q=80&w=2910&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center;
            background-size: cover;
        }
    </style>
</head>

<body class="bg-accent text-text leading-relaxed">
    <!-- Hero Section -->
    <header class="relative hero-pattern text-white py-32">
        <div class="absolute inset-0 bg-primary bg-opacity-70"></div>
        <div class="container mx-auto px-6 relative z-10 flex flex-wrap items-center fade-in">
            <div class="w-full lg:w-1/2 mb-10 lg:mb-0 text-center lg:text-left">
                <h1 class="text-5xl font-extrabold leading-tight">
                    Unleash Your Creativity,<br> Showcase Your Masterpieces
                </h1>
                <p class="mt-6 text-lg">
                    Join Aesthetic, the premier platform for artists in Indonesia. Share your art, connect with buyers, and grow your career today!
                </p>
                @if(Auth::check())
                    @if(Auth::user()->Artist == null)
                    <button onclick="openJoinModal()" class="mt-8 px-8 py-3 bg-secondary text-primary font-semibold rounded-lg shadow-lg hover:bg-primary hover:text-white transition">
                        Join as an Artist
                    </button>
                    @else
                    <p class="mt-6 text-lg">
                        <button class="mt-8 px-8 py-3 bg-secondary text-primary font-semibold rounded-lg shadow-lg hover:bg-secondary hover:text-primary transition">
                            @if(Auth::user()->Artist->isActive())
                                You are already being Artist
                            @else
                                Admin is reviewing, check on your email for all update
                            @endif
                        </button>
                    </p>
                    @endif
                @else
                <a href="{{ url('login') }}">
                    <button class="mt-8 px-8 py-3 bg-secondary text-primary font-semibold rounded-lg shadow-lg hover:bg-primary hover:text-white transition">
                        Join as an Artist
                    </button>
                </a>
                @endif
            </div>
            <div class="w-full lg:w-1/2">
                <img src="https://plus.unsplash.com/premium_photo-1704835116060-d88d18bd4727?q=80&w=2910&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Artistic Hero" class="rounded-lg shadow-lg">
            </div>
        </div>
    </header>

    <!-- Welcome Section -->
    <section class="py-16 bg-white fade-in" id="welcome">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold text-primary mb-6">Welcome to Aesthetic</h2>
            <div class="flex flex-wrap justify-center gap-8">
                <img src="https://plus.unsplash.com/premium_photo-1706445408078-7d629e7a3edf?q=80&w=3132&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Art Connection" class="rounded-lg shadow-lg w-1/2 lg:w-1/3">
                <p class="text-lg max-w-4xl text-gray-700 leading-relaxed">
                    Aesthetic connects buyers with talented artists from Indonesia. Artists showcase their creations while buyers discover and purchase unique pieces that reflect Indonesia’s rich culture and artistry. Celebrate creativity, build connections, and empower Indonesia’s art community.
                </p>
            </div>
        </div>
    </section>

    <!-- Why Join Section -->
    <section class="py-16 bg-secondary fade-in" id="why-join">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold text-primary">Why Join Aesthetic?</h2>
            <p class="text-lg text-gray-700 mt-4">
                Be part of a platform that celebrates creativity, supports local artists, and connects you with passionate buyers.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/photo-1558522195-e1201b090344?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Reach" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-primary">Reach Art Enthusiasts</h3>
                    <p class="text-gray-600 mt-2">
                        Showcase your work to an audience that loves unique and meaningful art.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <img src="https://images.unsplash.com/flagged/photo-1573832453372-7670afd5abd4?q=80&w=2942&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Sell" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-primary">Sell Your Creations</h3>
                    <p class="text-gray-600 mt-2">
                        Manage sales seamlessly and securely through our platform.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition">
                    <img src="https://plus.unsplash.com/premium_photo-1694658517551-0f956750ea33?q=80&w=3174&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Grow" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold text-primary">Grow Your Career</h3>
                    <p class="text-gray-600 mt-2">
                        Build your reputation and expand your reach in Indonesia’s vibrant art scene.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-primary text-white py-12 mt-16 fade-in" id="footer">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-between">
                <div class="w-full lg:w-1/3 mb-8 lg:mb-0">
                    <h3 class="text-lg font-bold text-yellow-300">About Aesthetic</h3>
                    <p class="mt-4 text-gray-300 leading-relaxed">
                        Aesthetic connects artists and art enthusiasts across Indonesia. Join us in building a thriving artistic community that celebrates creativity and local talent.
                    </p>
                </div>
                
                <div class="w-full lg:w-1/3 mb-8 lg:mb-0">
                    <h3 class="text-lg font-bold text-yellow-300">Have a Question?</h3>
                    <form class="mt-4 space-y-4">
                        <div>
                            <label for="faqName" class="block text-sm font-medium text-gray-300">Your Name</label>
                            <input type="text" id="faqName" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-800 text-white focus:ring-2 focus:ring-yellow-300 focus:outline-none" placeholder="Your Name" required>
                        </div>
                        <div>
                            <label for="faqEmail" class="block text-sm font-medium text-gray-300">Your Email</label>
                            <input type="email" id="faqEmail" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-800 text-white focus:ring-2 focus:ring-yellow-300 focus:outline-none" placeholder="Your Email" required>
                        </div>
                        <div>
                            <label for="faqMessage" class="block text-sm font-medium text-gray-300">Your Question</label>
                            <textarea id="faqMessage" rows="3" class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-800 text-white focus:ring-2 focus:ring-yellow-300 focus:outline-none" placeholder="Type your question..." required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-yellow-300 text-primary font-bold px-4 py-2 rounded-lg shadow-lg hover:bg-yellow-400 transition">
                            Submit Question
                        </button>
                    </form>
                </div>
            </div>
            <div class="mt-12 text-center border-t border-secondary pt-6">
                <p class="text-sm text-gray-200">
                    © 2024 Aesthetic. All rights reserved. | <a href="#" class="text-yellow-300 hover:underline">Privacy Policy</a> | <a href="#" class="text-yellow-300 hover:underline">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>
    <!-- Join Artist Modal -->
    @if(Auth::check())
    <div id="joinArtistModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 fade-in overflow-y-auto max-h-[80vh]">
            <div class="flex justify-between items-center">
                <h3 class="text-3xl font-bold text-primary">Join as an Artist</h3>
                <button onclick="closeJoinModal()" class="text-gray-500 hover:text-gray-700 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                </button>
            </div>
            <p class="mt-3 text-gray-600">
                Fill out the form below to apply as an artist on Aesthetic.
            </p>
            <form class="mt-6 space-y-6" method="POST" action="{{ route('register-artist') }}">
                @csrf
                <div>
                    <label for="name" class="block text-gray-700 font-medium">Full Name</label>
                    <input type="text" id="name" class="w-full px-4 py-3 border rounded-lg disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200" placeholder="Your Full Name" value="{{ $BUYER_DATA->FULLNAME }}" disabled>
                </div>
                <div>
                    <label for="email" class="block text-gray-700 font-medium">Email Address</label>
                    <input type="email" id="email" class="w-full px-4 py-3 border rounded-lg disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200" placeholder="Your Email" value="{{ $USER->EMAIL }}" disabled>
                </div>
                <!-- <div>
                    <label for="dob" class="block text-gray-700 font-medium">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="w-full px-4 py-3 border border-2 rounded-lg focus:ring-2 focus:ring-primary" placeholder="Select your date of birth" >
                </div> -->

                <!-- <div>
                <label for="gender" class="block text-gray-700 font-medium">Gender</label>
                <select id="gender" name="gender" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary" onchange="toggleOtherInput(this)">
                        <option value="">Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="prefer_not_to_say">Prefer not to say</option>
                        <option value="other">Other</option>
                </select>
                <input type="text" id="otherGender" name="otherGender" class="w-full px-4 py-3 mt-4 border rounded-lg focus:ring-2 focus:ring-primary hidden" placeholder="Please specify" disabled>
                </div> -->
                <div>
                    <label for="mobile_number" class="block text-gray-700 font-medium">Mobile Number</label>
                    <input type="text" id="mobile_number" class="w-full px-4 py-3 border rounded-lg disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200" placeholder="Your number" value="{{ $BUYER_DATA->PHONE_NUMBER }}" disabled>
                </div>
                {{-- <div>
                    <label for="portfolio" class="block text-gray-700 font-medium">Portfolio Link</label>
                    <input type="url" id="portfolio" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary" placeholder="Portfolio or Social Media Link">
                </div> --}}
                {{-- <div>
                    <label for="location" class="block text-gray-700 font-medium">Location <Style></Style></label>
                    <select id="location" name="location"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                        required>
                        <option value="USA">USA</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Russia">Russia</option>
                        <option value="Singapore">Singapore</option>
                    </select>
                </div> --}}
                <div>
                    <label for="role" class="block text-gray-700 font-medium">Headline <Style></Style></label>
                    <select id="headline" name="role"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                    required>
                        {{-- Ubah ketika join yang pertama di select "select one" --}}
                        <option value="Select One..." selected>Select One</option>
                        {{-- End --}}
                         @foreach($skillsMaster as $skill)
                            <option value="{{ $skill->DESCR }}">{{ $skill->DESCR }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bio" class="block text-gray-700 font-medium">Bio</label>
                    <textarea id="bio" name="bio" class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary" rows="4" placeholder="Tell us about yourself" required></textarea>
                </div>
                <div class="flex justify-between items-center mt-6">
                    <label class="block text-gray-700 font-medium">
                        <input type="checkbox" id="terms" class="mr-2" required>
                        I agree to the <span onclick="openTermsModal()" class="text-primary underline cursor-pointer">Terms and Conditions</span>.
                    </label>
                    <button type="submit"class="bg-primary text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Terms and Thank You Modals -->
    <div id="termsModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-xl w-full p-8 fade-in overflow-y-auto max-h-[80vh]">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-primary">Terms and Conditions</h3>
                <button onclick="closeTermsModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mt-4 text-gray-700 space-y-4">
                <p><strong>1. Introduction</strong><br>Welcome to Aesthetic! By using our website, you agree to follow these terms. If you don’t agree, please don’t use the site.</p>
                <p><strong>2. Use of Website</strong><br>- You can use Aesthetic to buy and sell artwork or services.<br> - You must be at least 18 years old to use certain parts of the site. <br> - Keep your login information safe. You are responsible for all activities under your account.</p>
                <p><strong>3. Accounts</strong><br>- You may need to create an account to buy or sell on Aesthetic. <br> - You agree to provide accurate information when creating your account.</p>
                <p><strong>4. Content</strong><br>- All artwork and content you upload must be your own or you must have permission to use it. <br> - We may remove any content that violates the rules or is inappropriate.</p>
                <p><strong>5. Buying and Selling</strong><br>- When you make a purchase, you agree to pay the listed price. <br> - When you sell something, you agree to service as described.</p>
                <p><strong>6. Payments</strong><br>Payments are handled securely through our platform. You agree to follow the payment process provided.</p>
                <p><strong>7. Privacy</strong><br>We respect your privacy. Please review our Privacy Policy to understand how we collect and use your personal data.</p>
                <p><strong>8. Prohibited Activities</strong><br>- Don’t upload harmful files, spam, or illegal content. <br> - Don’t misuse the platform or harm other users.</p>
                <p><strong>9. Limitation of Liability</strong><br>We are not responsible for any damages or losses caused by the use of the website or its content.</p>
                <p><strong>10. Contact Us</strong><br>If you have any questions or need help, feel free to contact us at contact information</p>
            </div>
            <div class="text-center mt-6">
                <button onclick="closeTermsModal()" class="bg-primary text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                    Close
                </button>
            </div>
        </div>
    </div>
    <div id="thankYouModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-8 fade-in text-center">
            <h3 class="text-2xl font-bold text-primary">Thank You!</h3>
            <p class="mt-4 text-gray-600">
                Your application has been submitted. We will review it and get back to you soon.
            </p>
            <button onclick="closeThankYouModal()" class="mt-6 bg-primary text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                Close
            </button>
        </div>
    </div>

    {{-- submitJoinForm() --}}
    @if(session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            submitJoinForm();
        });
    </script>
    @endif

    <!-- JavaScript for Animations -->
    <script>
        function openJoinModal() {
            document.getElementById('joinArtistModal').classList.add('active');
        }

        function closeJoinModal() {
            document.getElementById('joinArtistModal').classList.remove('active');
        }

        function submitJoinForm() {
            closeJoinModal();
            document.getElementById('thankYouModal').classList.add('active');
        }

        function closeThankYouModal() {
            document.getElementById('thankYouModal').classList.remove('active');
        }

        function openTermsModal() {
            document.getElementById('termsModal').classList.add('active');
        }

        function closeTermsModal() {
            document.getElementById('termsModal').classList.remove('active');
        }
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.3
            };

            const fadeInElements = document.querySelectorAll('.fade-in');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            fadeInElements.forEach(el => observer.observe(el));
        });
        function toggleOtherInput(select) {
        const otherInput = document.getElementById('otherGender');
        if (select.value === 'other') {
            otherInput.classList.remove('hidden');
            otherInput.disabled = false;
        } else {
            otherInput.classList.add('hidden');
            otherInput.disabled = true;
            otherInput.value = ''; // Clear the input if switching away from "Other"
        }
    }
    </script>
</body>

</html>
