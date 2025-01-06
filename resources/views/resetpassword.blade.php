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
      <div class="flex items-center mb-6">
        <!-- Replace the Flowbite text with your logo -->
        <img alt="Aesthetic Logo Text" class="w-24 h-8" src="{{ asset('images/aestheticlogo.png') }}" /> 
      </div>
      <h2 class="text-2xl md:text-3xl font-bold mb-2">Create new password</h2>
      <p class="text-gray-600 mb-6">Your new password must be different from previously used passwords.</p>
      <form>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="email" name="email" placeholder="name@company.com" type="email" required/>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700" for="new-password">New Password</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="new-password" name="new-password" placeholder="••••••••" type="password" required/>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700" for="confirm-password">Confirm Password</label>
          <input class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" id="confirm-password" name="confirm-password" placeholder="••••••••" type="password" required/>
        </div>
        <div class="flex items-center mb-6">
          <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded mr-2" id="terms" name="terms" type="checkbox" required/>
          <label class="text-sm font-medium text-gray-700" for="terms">
            I agree to the
            <a class="text-indigo-600 hover:underline" href="#">Terms of Use</a>
            and
            <a class="text-indigo-600 hover:underline" href="#">Privacy Policy</a>.
          </label>
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
