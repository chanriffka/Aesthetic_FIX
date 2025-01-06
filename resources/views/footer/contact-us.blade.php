<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Aesthetic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body class="bg-gray-100">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 bg-white shadow-lg rounded-lg my-10">
        <!-- Heading Section -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800">Contact Us</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">
                Got a technical issue? Want to send feedback about a beta feature? Need details about our Business plan? Let us know.
            </p>
            @if(session('status'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('status') }}
            </div>
            @endif
        </div>

        <!-- Contact Form and Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
            <!-- Contact Form -->
            <div class="p-6 bg-white rounded-lg shadow-inner">
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="first-name" class="block text-sm font-semibold text-gray-700">First Name</label>
                            <input type="text" name="firstName" id="first-name" placeholder="First Name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 bg-white" required>
                        </div>
                        <div>
                            <label for="last-name" class="block text-sm font-semibold text-gray-700">Last Name</label>
                            <input type="text" name="lastName" id="last-name" placeholder="Last Name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 bg-white" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700">Your Email</label>
                            <input type="email" name="email" id="email" placeholder="you@example.com"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 bg-white" required>
                        </div>
                        <div>
                            <label for="phone-number" class="block text-sm font-semibold text-gray-700">Phone Number</label>
                            <input type="tel" name="phoneNumber" id="phone-number" placeholder="+1 (555) 555-5555"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 bg-white" required>
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700">Your Message</label>
                        <textarea id="message" name="message" rows="4"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 bg-white"
                            placeholder="Write your message..." required></textarea>
                    </div>
                    <p class="text-sm text-gray-500">
                        By submitting this form, you agree to our <a href="#" class="text-indigo-600 hover:underline">terms and conditions</a> and <a href="#" class="text-indigo-600 hover:underline">privacy policy</a>.
                    </p>
                    <div>
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-md shadow-lg transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <div class="text-center">
                    <div class="bg-gray-100 p-4 w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-building text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Company Information</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Aesthetic<br>
                        Indonesia
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-gray-100 p-4 w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-map-marker-alt text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Address</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        3M5J+8QG, Jl. Araya Mansion No.8 - 22, Genitri, Tirtomoyo <br>
                        Kec. Pakis, Kabupaten Malang, Jawa Timur. Zip code: 65154
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-gray-100 p-4 w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-phone text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Call Us</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Call us to speak to a member of our team.<br>
                        <a href="tel:+16467865060" class="text-indigo-600 font-medium">+62 887-4498-2114</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
