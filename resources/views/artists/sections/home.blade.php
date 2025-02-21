<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Sidebar</title>
</head>

<body>
    <!-- Latest Works Section -->
    <div class="bg-white p-4 rounded-lg shadow-lg mt-4">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold">Latest Works</h3>
            <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section'=>'artwork']) }}" class="text-gray-600 hover:text-gray-800">See all</a>
        </div>
        <div class="mt-4">
            @if($artWorks->isEmpty())
                @if(Auth::check())
                    @if (Auth::user()->USER_ID == $artist->USER_ID )
                    <div class="flex justify-center items-center h-24">
                        <p class="text-gray-500 italic">You haven't made any upload artwork yet.</p>
                    </div>
                    @else
                    <div class="flex justify-center items-center h-24">
                        <p class="text-gray-500 italic">This user hasn't made any upload artwork yet.</p>
                    </div>
                    @endif
                @else
                <div class="flex justify-center items-center h-24">
                    <p class="text-gray-500 italic">This user hasn't made any upload artwork yet.</p>
                </div>
                @endif
            @else
                <!-- Display the artworks if available -->
                <div class="grid grid-cols-3 gap-4 mt-4">
                    @foreach($artWorks->take(3) as $artWork)
                    <a href="{{ route('artwork.show', $artWork->ART_ID) }}">
                        <img src="{{ Str::startsWith($artWork->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($artWork->ArtImages()->first()->IMAGE_PATH) : $artWork->ArtImages()->first()->IMAGE_PATH }}"
                             alt="{{ $artWork->ART_TITLE }}" class="rounded-lg object-cover">
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Portfolio Section -->
    <div class="bg-white p-4 rounded-lg shadow-lg mt-4">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold">Portfolio</h3>
            <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section'=>'portfolio']) }}" class="text-gray-600 hover:text-gray-800">See all</a>
        </div>
        <div class="mt-4">
            @if($portfolios->isEmpty())
                @if(Auth::check())
                    @if (Auth::user()->USER_ID == $artist->USER_ID )
                    <div class="flex justify-center items-center h-24">
                        <p class="text-gray-500 italic">You haven't made any upload portfolio yet.</p>
                    </div>
                    @else
                    <div class="flex justify-center items-center h-24">
                        <p class="text-gray-500 italic">This user hasn't made any upload portfolio yet.</p>
                    </div>
                    @endif
                @else
                <div class="flex justify-center items-center h-24">
                    <p class="text-gray-500 italic">This user hasn't made any upload portfolio yet.</p>
                </div>
                @endif
            @else
            <div class="grid grid-cols-3 gap-4 mt-4">
                @foreach($portfolios->take(3) as $portfolio)
                <a href="{{ route('artGallery.show', $portfolio->ART_ID) }}">
                    <img src="{{ Str::startsWith($portfolio->ArtImages()->first()->IMAGE_PATH, 'images/art/') ? asset($portfolio->ArtImages()->first()->IMAGE_PATH) : $portfolio->ArtImages()->first()->IMAGE_PATH }}"
                    alt="{{ $portfolio->ART_TITLE }}" class="rounded-lg object-cover">
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

</body>

</html>
