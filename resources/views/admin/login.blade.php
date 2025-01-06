<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://source.unsplash.com/1600x900/?gradient,blue,purple');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen gradient-overlay">

    <!-- Login Container -->
    <div class="w-full max-w-md bg-white bg-opacity-90 rounded-2xl shadow-2xl p-8 space-y-6 backdrop-blur-lg">
        <!-- Aesthetic Logo -->
        <div class="flex justify-center">
            <div class="w-20 h-20 bg-indigo-600 text-white flex items-center justify-center rounded-full shadow-md">
                <span class="text-3xl font-extrabold tracking-wide">A</span>
            </div>
        </div>
        
        <!-- Header -->
        <h2 class="text-3xl font-extrabold text-center text-gray-800">Welcome Admin!</h2>
        <p class="text-center text-sm text-gray-500">Login to access your dashboard</p>

        <!-- Login Form -->
        <form action="{{ route('admin.dashboard') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Enter your email"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none focus:border-indigo-500"
                />
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Enter your password"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none focus:border-indigo-500"
                />
            </div>

            <!-- Login Button -->
            <button 
                type="submit" 
                class="w-full px-4 py-3 text-white bg-gradient-to-r from-indigo-600 to-blue-500 rounded-lg font-semibold hover:from-indigo-700 hover:to-blue-600 transition duration-300"
            >
                Login
            </button>
        </form>

        <!-- Footer Links -->
        <div class="flex justify-center items-center space-x-4 text-sm text-gray-600">
            <a href="#" class="hover:text-indigo-600 hover:underline">Forgot Password?</a>
        </div>
    </div>

</body>
</html>
