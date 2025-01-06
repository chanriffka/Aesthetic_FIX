@extends('admin.admin')

@section('title', 'Contact Us Message #'.$message->CONTACT_US_ID)

@section('content')
<div class="flex-1 p-6">
    <!-- Card -->
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-3xl mx-auto">
        <!-- Heading -->
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Message Details</h2>

        <!-- Full Name -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Full Name</h3>
            <p class="text-gray-600">{{ $message->FULLNAME }}</p>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Email</h3>
            <p class="text-gray-600">{{ $message->EMAIL }}</p>
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Phone</h3>
            <p class="text-gray-600">{{ $message->PHONE_NUMBER }}7</p>
        </div>

        <!-- Message -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Message</h3>
            <p class="text-gray-600 leading-relaxed">
                {{ $message->MESSAGE }}
            </p>
        </div>

        <!-- Back Button -->
        <div class="flex justify-end">
            <a href="{{ route('admin.contact.all') }}" 
               class="px-4 py-2 mr-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                Back
            </a>
            <a href="{{ ROUTE('admin.contact.update',['id'=>$message->CONTACT_US_ID]) }}" class="px-4 py-2 bg-{{ $message->status_color }}-300 text-{{ $message->status_color }}-800 rounded-md hover:bg-{{ $message->status_color }}-400">
                {{ $message->status_text }}
            </a>
        </div>
    </div>
</div>
@endsection
