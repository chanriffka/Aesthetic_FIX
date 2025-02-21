<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
  <div class="flex bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl w-full">
    
    <!-- Form Section (Left Side) -->
    <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
      <div class="flex items-center mb-6">
        <!-- Replace the Flowbite text with your image -->
        <img alt="Aesthetic Logo Text" class="w-24 h-8" src="{{ asset('images/aestheticlogo.png') }}" /> 
      </div>
      <h2 class="text-2xl md:text-3xl font-bold mb-2">Welcome back</h2>
      {{-- @foreach($errors->all() as $error)
      <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
        </svg>
        <span class="sr-only">Error</span>
        <div>
          {{-- <span class="font-medium">Error!</span> {{ $error }} --}}
        {{-- </div>
      </div>  --}}
      {{-- @endforeach --}}
      <p class="text-gray-600 mb-6">
        Start your website in seconds. Don't have an account?
        <a class="text-indigo-600" href="{{ url('register') }}">Sign up.</a>
      </p>
      @if(session('status'))
      <div class="p-4 mb-4 text-sm text--800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <span class="font-medium">{{ session('status') }}</span>
      </div>
      @endif
      @error('authorization')
      <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">{{ $message }}</span> Wrong Email Or Password
      </div>
      @enderror
      @error('Inactive')
      <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">{{ $message }}</span> Your Account is Inactive
      </div>
      @enderror
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Email</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="name@company.com" type="email" name="email" required/>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="••••••••" type="password" name="password" required/>
        </div>
        <div class="flex items-center justify-between mb-4">
          <a class="text-indigo-600 hover:underline" href="{{ url('resetpassword') }}">Forgot password?</a>
        </div>
        <button class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-6">
          Sign in to your account
        </button>
      </form>
    </div>

    <!-- Image Section (Right Side) -->
    <div class="hidden md:flex md:w-1/2 bg-gray-100 items-center justify-center">
      <img alt="Login page illustration" class="w-full h-full object-cover" src="{{ asset('images/loginpage.jpg') }}" />
    </div>
  </div>
</body>
</html>
