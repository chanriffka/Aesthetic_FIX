@extends('layouts.template')

@section('content')
<div class="container mx-auto mt-10" x-data="carousel()" x-init="init()">
    <div class="relative w-full overflow-hidden">
        <!-- Carousel Images -->
        <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
            <div class="w-full flex-shrink-0">
                <img src="images/homepage6.JPG" alt="Slide 1" class="w-full object-cover">
            </div>
            <div class="w-full flex-shrink-0">
                <img src="images/homepage7.JPG" alt="Slide 2" class="w-full object-cover">
            </div>
            <div class="w-full flex-shrink-0">
                <img src="images/homepage3.jpeg" alt="Slide 3" class="w-full object-cover">
            </div>
        </div>

        <!-- Previous Button -->
        <button class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1"
                @click="prev()">
            Prev
        </button>

        <!-- Next Button -->
        <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1"
                @click="next()">
            Next
        </button>
    </div>

    <!-- Indicator Dots -->
    <div class="flex justify-center space-x-2 mt-4">
        <template x-for="(slide, index) in slides" :key="index">
            <button :class="{'bg-gray-800': currentIndex === index, 'bg-gray-400': currentIndex !== index}" 
                    class="w-3 h-3 rounded-full" 
                    @click="goToSlide(index)">
            </button>
        </template>
    </div>
</div>

@endsection
