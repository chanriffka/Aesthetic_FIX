<!DOCTYPE html>
<html lang="en">
<head>
  <title>Create New Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
  <div class="flex bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl w-full">
    <!-- Form Section (Left Side) -->
    <div class="w-full md:w-1/2 p-8">
      <a href="javascript:history.back()" class="flex items-center text-gray-500 hover:text-gray-700 mb-5">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
          Back
      </a>
      <div class="flex items-center mb-6">
        <!-- Replace the Flowbite text with your logo -->
        <img alt="Aesthetic Logo Text" class="w-24 h-8" src="{{ asset('images/aestheticlogo.png') }}" /> 
      </div>
      <h2 class="text-2xl md:text-3xl font-bold mb-2">Create new password</h2>
      <p class="text-gray-600 mb-6">Your new password must be different from previously used passwords.</p>
      @error('authorization')
      <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <span class="font-medium">{{ $message }}</span>
      </div>
      @enderror
      <form action="{{ route('resetPassword') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="email" name="email" placeholder="name@company.com" type="email" required/>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700" for="old-password">Old Password</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="oldPassword" name="password" placeholder="••••••••" type="password" required/>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700" for="new-password">New Password</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="newPassword" name="newPassword" placeholder="••••••••" type="password" required/>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700" for="confirm-password">Confirm Password</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="confirm-password" name="confirm-password" placeholder="••••••••" type="password" required/>
        </div>
        <button class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">
          Reset Password
        </button>
      </form>
    </div>

    <!-- Image Section (Right Side) -->
    <div class="hidden md:flex md:w-1/2 bg-gray-100 items-center justify-center">
      <img alt="Password Reset Illustration" class="w-full h-full object-cover" src="{{ asset('images/resetpassword.jpg') }}"/>
    </div>
  </div>
</body>
</html>
