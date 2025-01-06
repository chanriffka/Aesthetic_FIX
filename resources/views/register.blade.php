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
      <h2 class="text-3xl font-bold mb-2">Create your Account</h2>
      <p class="text-gray-600 mb-6">
        Start your website in seconds. Already have an account?
        <a class="text-indigo-600" href="{{ url('login') }}">Login here.</a>
      </p>
      <form action="{{ route('register') }}" method="POST">
        @csrf
        <!-- Full Name -->
        <div class="mb-4">
          <label class="block text-gray-700">First Name</label>
          <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('firstName') is-invalid @else is-valid @enderror" placeholder="Enter your first name" type="text" name="firstName" value="{{old('firstName')}}" required/>
          @error('firstName')
            <div class="text-red-500">
              {{ $message }}
            </div>
          @enderror
        </div>
        <!-- Last Name -->
        <div class="mb-4">
          <label class="block text-gray-700">Last Name</label>
          <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('lastName') is-invalid @else is-valid @enderror" placeholder="Enter your last name" type="text" name="lastName" value="{{old('lastName')}}" required/>
          @error('lastName')
            <div class="text-red-500">
              {{ $message }}
            </div>
          @enderror
        </div>
        <!-- Username -->
        <div class="mb-4">
          <label class="block text-gray-700">Phone Number</label>
          <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('phone') is-invalid @else is-valid @enderror" placeholder="+62-XXXXXXXXXXX" type="text" name="phone" value="{{old('phone')}}" required/>
          @error('phone')
            <div class="text-red-500">
              {{ $message }}
            </div>
          @enderror
        </div>
        <!-- Username -->
        <div class="mb-4">
          <label class="block text-gray-700">Username</label>
          <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('username') is-invalid @else is-valid @enderror" placeholder="Username" type="text" name="userName" value="{{old('userName')}}" required/>
          @error('username')
            <div class="text-red-500">
              {{ $message }}
            </div>
          @enderror
        </div>
        <!-- Email -->
        <div class="mb-4">
          <label class="block text-gray-700">Email</label>
          <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('email') is-invalid @else is-valid @enderror" placeholder="name@company.com" type="email" name="email" value="{{old('email')}}" required/>
          @error('email')
            <div class="text-red-500">
              {{ $message }}
            </div>
          @enderror
        </div>
        <!-- Password -->
        <div class="mb-4">
          <label class="block text-gray-700">Password</label>
          <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('password') is-invalid @else is-valid @enderror" placeholder="••••••••" type="password" name="password" required/>
          @error('password')
            <div class="text-red-500">
              {{ $message }}
            </div>
          @enderror
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Password Confirmation</label>
          <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-600 @error('password_confirmation') is-invalid @else is-valid @enderror" placeholder="••••••••" type="password" name="password_confirmation" required/>
          @error('password')
            <div class="text-red-500">
              {{ $message }}
            </div>
          @enderror
        </div>
        <!-- Terms Checkbox -->
        <div class="flex items-center mb-6">
          <input class="mr-2" type="checkbox"/>
          <label class="text-gray-600">
            By signing up, you agree to the
            <a class="text-indigo-600" href="#">Terms of Use</a> and
            <a class="text-indigo-600" href="#">Privacy Policy</a>.
          </label>
        </div>
        <button class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-6">
          Create an Account
        </button>
      </form>
    </div>

    <!-- Image Section (Right Side) -->
    <div class="hidden md:flex md:w-1/2 bg-gray-100 items-center justify-center">
      <img alt="Login page illustration" class="w-full h-full object-cover" src="{{ asset('images/signup.jpg') }}" />
    </div>
  </div>
</body>
</html>


