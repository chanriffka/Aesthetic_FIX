<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aesthetic')</title>
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f7f8fa;
            color: #333;
        }

            /* Grid Styles */
    .grid {
        display: grid;
        gap: 1.5rem;
    }
    .grid-cols-1 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
    .sm\:grid-cols-2 {
        @media (min-width: 640px) {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    .lg\:grid-cols-3 {
        @media (min-width: 1024px) {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    /* Artist Card Styles */
    .artist-card {
        background-color: white;
        padding: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .artist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .artist-card img {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
        border: 2px solid #4F46E5;
    }

    .artist-card h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1F2937;
    }

    .artist-card p {
        font-size: 0.875rem;
        color: #6B7280;
    }

    /* Flex Containers for Artist Info */
    .flex {
        display: flex;
        align-items: center;
    }

    .justify-between {
        justify-content: space-between;
    }

    .text-xs {
        font-size: 0.75rem;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-lg {
        font-size: 1.125rem;
    }

    .text-gray-800 {
        color: #1F2937;
    }

    .text-gray-500 {
        color: #6B7280;
    }

    .text-gray-400 {
        color: #9CA3AF;
    }

    .hover\:underline:hover {
        text-decoration: underline;
    }

    /* Footer Styles */
    footer {
        background-color: #F3F4F6;
        padding: 2rem 0;
    }

    footer p {
        font-size: 0.875rem;
        color: #6B7280;
    }

    /* Navbar Styles */
    .navbar {
        background-color: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .navbar a {
        font-size: 1rem;
        color: #4B5563;
        transition: color 0.3s ease;
    }

    .navbar a:hover {
        color: #4F46E5;
    }

    </style>
</head>
<body>

    @if (Auth::check())
    @include('layouts.navbar-login')
    @else
    @include('layouts.navbar')
    @endif
    <!-- Navbar -->
    

    <!-- Main Content -->
    
    @yield('content')
    

    <!-- Include the Footer -->
    @include('layouts.footer')

    <!-- Add your JavaScript here -->
    @stack('scripts')
</body>
</html>
