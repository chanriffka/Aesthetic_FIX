{{-- @extends('layouts.app')

@section('title', 'Artist show')

@section('content') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Chat Container */
    #chatContainer {
        transition: width 0.3s ease, height 0.3s ease;
    }
    
    /* Expanded Chat */
    #chatContainer.expanded {
        width: 100vw;
        height: 100vh;
        bottom: 0;
        right: 0;
    }

    /* Messages area with scrolling */
    #chatContainer .chat-messages {
        height: calc(100% - 120px); /* Adjust for header and input area */
        overflow-y: auto;
        padding: 1rem;
    }

    /* Input area with padding */
    #chatContainer .chat-input {
        padding: 10px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Input field with proper sizing */
    #chatContainer .chat-input input {
        flex: 1;
        padding: 10px 12px;
        border-radius: 20px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 14px;
    }

    /* Send button */
    #chatContainer .chat-input button {
        background-color: #4f46e5; /* Indigo color */
        color: white;
        padding: 8px 12px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Options Menu styling */
    .optionsMenu {
            position: absolute;
            top: 40px;
            right: 10px;
            background-color: white;
            border: 1px solid #e5e7eb;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 150px;
            z-index: 10;
        }

        .ellipsisButton:focus+.optionsMenu,
        .optionsMenu:hover {
            display: block;
        }

        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        .modal.active {
            display: flex;
        }

        .reason-tag {
            padding: 0.5rem 1rem;
            background-color: #e2e8f0;
            color: #1a202c;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .reason-tag:hover {
            background-color: #cbd5e0;
        }

        .reason-tag.selected {
            background-color: #4a5568;
            color: white;
        }

        /* Subtle animations for showing and hiding elements */
        .hidden {
            display: none;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
</style>

</head>

<body class="bg-gray-100 font-roboto">
    <!-- Navbar Start -->   
    @if(Auth::Check())
    @include('layouts.navbar-login')
    @else
    @include('layouts.navbar')
    @endif
    <!-- Navbar End -->

    <div class="bg-white">
        <!-- Profile Banner Section -->
        <div class="relative">
            <img src="" alt="" class="w-full h-48 object-cover">
            <div class="absolute top-0 left-0 w-full h-full bg-lime-500 opacity-50"></div>
        </div>

        <!-- Sidebar: Profile Information -->
        {{-- @include('artists.artist-profile-sidebar') --}}
        <div class="container mx-auto px-4 py-6">
            <div class="flex">
                <!-- Sidebar: Profile Information -->
                <div class="w-1/4 relative">
                    <div class="bg-white p-4 rounded-lg shadow-lg relative">
                        <!-- Ellipsis Button -->

                        <div class="text-center">
                            <img src="{{ $artist->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($artist->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Profile picture"
                                class="w-24 h-24 rounded-full mx-auto object-cover">
                            <h2 class="text-xl font-bold mt-4">{{ $artist->MasterUser->Buyer->FULLNAME }}</h2>
                            <p class="text-gray-600">{{ $artist->ROLE }}</p>
                            <p class="text-gray-600">{{ $artist->BIO }}</p>
                            <p class="text-gray-600"><i class="fas fa-map-marker-alt"></i> {{ $artist->LOCATION }}</p>
                            @if($artistItSelf == false)
                                @if(Auth::user() != null)
                                @if($artist->ArtistRatings->where('USER_ID',Auth::user()->USER_ID)->count() == 0)
                                <button onclick="openReviewModal()" class="bg-yellow-500 text-white px-4 py-2 rounded-full w-full mt-4">
                                    <i class="fas fa-star mr-3 text-white"></i>
                                    <span id="followText">Review Artist</span>
                                </button>
                                @endif

                                <button onclick="openReportModal()" class="bg-red-500 text-white px-4 py-2 rounded-full w-full mt-4">
                                    <i class="fa fa-flag mr-3 text-white"></i>
                                    <span id="followText">Report</span>
                                </button>
                                @if(Auth::user()->isFollowing($artist->USER_ID))
                                <button onclick="window.location.href='{{ route('unfollow', ['userId' => $artist->USER_ID]) }}'" class="bg-gray-500 text-white px-4 py-2 rounded-full w-full mt-4">
                                    <i id="followIcon" class="fas fa-user-check mr-2"></i>
                                    <span id="followText">Followed</span>
                                </button>
                                @else
                                <button onclick="window.location.href='{{ route('follow', ['userId' => $artist->USER_ID]) }}'" class="bg-green-500 text-white px-4 py-2 rounded-full w-full mt-4">
                                    <i id="followIcon" class="fas fa-user-plus mr-2"></i>
                                    <span id="followText">Follow</span>
                                </button>
                                @endif
                                @endif
                            {{-- <button onclick="openChatWindow()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full w-full mt-1">
                                <i class="fas fa-envelope mr-2"></i> Message
                            </button> --}}
                            @else
                                <button onclick="openEditProfileModal()" class="bg-indigo-500 text-white px-4 py-2 rounded-full w-full mt-4">
                                    <i class="fas fa-user-edit mr-3 text-white-500"></i>
                                    <span id="followText">Edit Profile</span>
                                </button>
                                @if(!isset($hire))
                                <!-- Hire Freelance Button -->
                                <button onclick="openHireFormModal()" class="bg-blue-500 text-white px-4 py-2 rounded-full w-full mt-4">
                                    <i class="fas fa-file mr-3 text-white-500"></i>
                                    <span id="followText">Hire Freelance</span>
                                </button>
                                @endif
                            @endif
                        </div>

                        @if($artist->ArtistHire != null)
                        <div class="mt-4 flex justify-center items-center">
                            <button onclick="window.location.href='{{ route('artist.hiring',['id'=>$artist->ArtistHire->ARTIST_HIRE_ID]) }}'" class="bg-white border border-indigo-500 rounded-lg p-2 px-4 shadow-md">
                                <h1 class="text-sm font-semibold text-center">Hire {{ $artist->MasterUser->Buyer->FULLNAME }}</h1>
                                <div class="flex items-center mt-1">
                                    <i class="fas fa-clipboard-list text-indigo-500 mr-2"></i>
                                    <div>
                                        <p class="text-sm font-small">Freelance/Project</p>
                                        <p class="text-gray-500 text-xs">Available</p>
                                    </div>
                                </div>
                            </button>
                        </div>
                        @endif

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Project Views</span>
                                <span class="text-gray-800">{{ $artist->MasterUser->total_art_view }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Project likes</span>
                                <span class="text-gray-800">{{ $artist->MasterUser->total_art_like }}</span>
                            </div>
                            <div class="flex justify-between">
                                <a href="{{ route('artist.viewfollower',['id'=>$artist->MasterUser->USER_ID]) }}" class="text-gray-600 hover:underline">Followers</a>
                                <a href="{{ route('artist.viewfollower',['id'=>$artist->MasterUser->USER_ID]) }}" class="text-gray-800">{{ $artist->MasterUser->Followers->count() }}</a>
                            </div>
                            <div class="flex justify-between">
                                <a href="{{ route('artist.viewfollowing',['id'=>$artist->MasterUser->USER_ID]) }}" class="text-gray-600 hover:underline">Following</a>
                                <a href="{{ route('artist.viewfollowing',['id'=>$artist->MasterUser->USER_ID]) }}" class="text-gray-800">{{ $artist->MasterUser->Followings->count() }}</a>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Artist Overall Rating</span>
                                <span class="text-gray-800">{{ $artist->average_artist_rating }}</span>
                            </div>
                        </div>

                        <div class="flex justify-center mt-4 space-x-4">
                            @if($artist->INSTAGRAM != null)
                            <button onclick="window.open('{{ $artist->INSTAGRAM }}','_blank')" class="text-gray-600"><i class="fab fa-instagram"></i></button>
                            @endif
                            @if($artist->PINTEREST != null)
                            <button onclick="window.open('{{ $artist->PINTEREST }}','_blank')" class="text-gray-600"><i class="fab fa-pinterest"></i></button>
                            @endif
                            @if($artist->X != null)
                            <button onclick="window.open('{{ $artist->X }}','_blank')" class="text-gray-600"><i class="fab fa-twitter"></i></button>
                            @endif
                            @if($artist->LINKEDIN != null)
                            <button onclick="window.open('{{ $artist->LINKEDIN }}','_blank')" class="text-gray-600"><i class="fab fa-linkedin"></i></button>
                            @endif
                        </div>

                    </div>

                    <!-- Posts Section -->
                    <div class="bg-white p-4 rounded-lg shadow-lg mt-4">
                        <h3 class="text-lg font-bold">Posts</h3>
                        <div class="mt-4">
                            <div class="flex items-start">
                                <img src="https://placehold.co/50x50"
                                    alt="Post profile picture" class="w-12 h-12 rounded-full object-cover">
                                <div class="ml-4">
                                    <h4 class="font-bold">username</h4>
                                    <p class="text-gray-600">content</p>
                                    <img src="https://placehold.co/200x100"
                                        alt="Post image" class="mt-2 rounded-lg object-cover w-full h-32">
                                    <div class="flex justify-between items-center mt-2">
                                        <div class="flex space-x-10">
                                            <!-- like button -->
                                            <button class="text-gray-600 flex flex-col items-center">
                                                <img src="/images/heart.svg" alt="Shopping Cart"
                                                    class="w-5 h-5">
                                                <span class="text-xs mt-1">Like</span>
                                            </button>
                                            <!-- comment button -->
                                            <button class="text-gray-600 flex flex-col items-center">
                                                <img src="/images/comment.svg" alt="Shopping Cart"
                                                    class="w-5 h-5">
                                                <span class="text-xs mt-1">Comment</span>
                                            </button>
                                            <!-- share button -->
                                            <button class="text-gray-600 flex flex-col items-center">
                                                <img src="/images/share.svg" alt="Shopping Cart"
                                                    class="w-5 h-5">
                                                <span class="text-xs mt-1">Share</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="w-3/4 ml-4">
                    <!-- Navigation Tabs -->
                    <nav class="flex space-x-4">
                        <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'home']) }}"
                            class="text-gray-600 hover:text-gray-800">Home</a>
                        <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'portfolio']) }}"
                            class="text-gray-600 hover:text-gray-800">Portfolio</a>
                        <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'collection']) }}"
                            class="text-gray-600 hover:text-gray-800">Collection</a>
                        <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'posts']) }}"
                            class="text-gray-600 hover:text-gray-800">Posts</a>
                        <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'artwork']) }}"
                            class="text-gray-600 hover:text-gray-800">ArtWork</a>
                        <a href="{{ route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'about']) }}"
                            class="text-gray-600 hover:text-gray-800">About</a>
                    </nav>

                    <!-- Section Rendering -->
                    <div class="mt-4">
                        @if ($section === 'home')
                            @include('artists.sections.home', ['artist' => $artist])
                        @elseif($section === 'portfolio')
                            @include('artists.sections.portfolio',['artist' => $artist,'portfolios' => $portfolios, 'artCategoriesMaster' => $artCategoriesMaster])
                        @elseif($section === 'collection')
                            @include('artists.sections.collection',['artist' => $artist])
                        @elseif($section === 'posts')
                            @include('artists.sections.posts', ['artist' => $artist])
                        @elseif($section === 'artwork')
                            @include('artists.sections.artwork', ['artist' => $artist,'artWorks' => $artWorks])
                        @elseif($section === 'about')   
                            @include('artists.sections.about', ['artist' => $artist])
                        @endif
                    </div>
                </div>
            </div>
               
          

            <!-- Chat Container -->
            <div id="chatContainer" class="hidden fixed bottom-5 right-5 w-80 h-96 bg-white shadow-lg rounded-lg overflow-hidden z-50">
                <!-- Chat Header with Expand and Close Buttons -->
                <div class="flex justify-between items-center p-4 bg-gray-100 border-b border-gray-300">
                    <h3 class="text-gray-800 text-lg font-semibold">Chat with Shanay Cruz</h3>
                    <div class="flex space-x-2">
                        <!-- Expand Button -->
                        <button onclick="toggleChatSize()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-expand"></i>
                        </button>
                        <!-- Close Button -->
                        <button onclick="closeChatWindow()" class="text-gray-500 hover:text-gray-700">
                            &times;
                        </button>
                    </div>
                </div>

                <!-- Chat Messages Area with scrolling -->
                <div class="chat-messages">
                    <div class="grid pb-11">
                        <!-- Message from the artist -->
                        <div class="flex gap-2.5 mb-4">
                            <img src="https://pagedone.io/asset/uploads/1710412177.png" alt="Shanay image" class="w-10 h-11">
                            <div class="grid">
                                <h5 class="text-gray-900 text-sm font-semibold leading-snug pb-1">Shanay Cruz</h5>
                                <div class="px-3.5 py-2 bg-gray-100 rounded-lg inline-flex">
                                    <h5 class="text-gray-900 text-sm font-normal leading-snug">Guts, I need a review of work. Are you ready?</h5>
                                </div>
                                <div class="text-gray-500 text-xs font-normal leading-4 py-1 text-right">05:14 PM</div>
                            </div>
                        </div>
                        <!-- Your message -->
                        <div class="flex gap-2.5 justify-end mb-4">
                            <div>
                                <div class="px-3 py-2 bg-indigo-600 text-white rounded-lg">
                                    <h2 class="text-sm font-normal leading-snug">Yes, let’s see, send your work here</h2>
                                </div>
                                <div class="text-gray-500 text-xs font-normal leading-4 py-1">05:14 PM</div>
                            </div>
                            <img src="https://pagedone.io/asset/uploads/1704091591.png" alt="Your image" class="w-10 h-11">
                        </div>
                    </div>
                </div>

                <!-- Chat Input Area -->
                <div class="chat-input">
                    <input type="text" placeholder="Type here..." class="w-full text-gray-700 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-600" />
                    <button class="bg-indigo-600 text-white p-2 rounded-full">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
            
            <!-- Edit Profile Modal -->
        <div id="editModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden overflow-y-auto">
            <div
                class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 fade-in overflow-y-auto max-h-[80vh] relative">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold text-primary">📝 Edit Profile</h2>
                    <button onclick="closeEditModal()"
                        class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                        &times;
                    </button>
                </div>

                <!-- Make the content area scrollable by setting a fixed height -->
                <div class="relative max-h-[70vh] overflow-y-auto p-6 space-y-5">
                    <form action="{{ route('artist.update',['artistId' => $artist->ARTIST_ID]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Profile Cover Image -->
                        {{-- <div class="relative">
                            <img id="bannerPicturePreview   " src="https://via.placeholder.com/600x200" alt="Background image"
                                class="w-full h-48 object-cover">
                            <button
                                class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition duration-200">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div> --}}

                        <!-- Profile Avatar Image -->
                        <label class="block text-gray-700 font-medium">📸 Profile Pics</label>
                        <div class="relative mt-12 flex justify-center">
                            
                            <div class="relative">
                                
                                <img id="profilePicturePreview" src="{{ $artist->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($artist->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Profile picture"
                                    class="w-28 h-28 rounded-full border-4 border-white object-cover shadow-lg">

                                <!-- Image Upload Button -->
                                
                                <label for="profilePictureUpload" 
                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-70 transition duration-200 cursor-pointer">
                                    <i class="fas fa-camera" id="cameraIcon"></i>
                                </label>
                                <input type="file" id="profilePictureUpload" name="picture" accept="image/*" class="hidden">
                            </div>
                        </div>
                        <span id="profilePictureUploadError" class="text-red-600"></span>

                        <!-- Form Section -->
                        <div class="space-y-6">
                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-gray-700 font-medium">📌 Name</label>
                                <input type="text" id="name" name="name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                    placeholder="Enter your name" required value="{{ $artist->MasterUser->Buyer->FULLNAME }}">
                                <span id="usernameExistError" class="text-red-600"></span>
                            </div>

                            <!-- Headline Field -->
                            <div>
                                <label for="headline" class="block text-gray-700 font-medium">📋 Headline</label>
                                <select id="headline" name="role"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                    required>
                                    @foreach($skillsMaster as $skill)
                                    <option value="{{ $skill->DESCR }}" @if($artist->ROLE == "{{ $skill->DESCR }}") selected @endif>{{ $skill->DESCR }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <!-- Phone Field -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">📞 Phone</label>
                            <div class="flex">
                                <!-- Static Prefix -->
                                <span class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 rounded-l-lg text-gray-500">
                                    +62
                                </span>
                                <!-- Input Field -->
                                <input 
                                    id="phone" 
                                    name="phone" 
                                    type="text" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" 
                                    placeholder="8123456789" 
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13)" 
                                    required 
                                    value="{{ $artist->MasterUser->Buyer->PHONE_NUMBER ?? '' }}"
                                />
                            </div>
                        </div>
                            <!-- Bio Field -->
                            
                            <div>
                                <label for="bio" class="block text-gray-700 font-medium">📝 Bio</label>
                                <textarea id="bio" rows="3" name="bio"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                    placeholder="Write a short bio..." maxlength="30" required>{{ $artist->BIO }}</textarea>
                            </div>

                            <div>
                                <label for="location" class="block text-gray-700 font-medium">📍 Location
                                    Level</label>
                                <select id="location" name="location"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                    required>
                                    <option value="USA" @if($artist->LOCATION == "USA") selected @endif>USA</option>
                                    <option value="Indonesia" @if($artist->LOCATION == "Indonesia") selected @endif>Indonesia</option>
                                    <option value="Russia" @if($artist->LOCATION == "Russia") selected @endif>Russia</option>
                                    <option value="Singapore" @if($artist->LOCATION == "Singapore") selected @endif>Singapore</option>
                                </select>
                            </div>

                            <!-- Social Media Links -->
                            <div>
                                <label class="block text-gray-700 font-medium">🌐 Social Media</label>
                                <!-- Two Columns Layout -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                    <!-- Twitter Field -->
                                    <div class="flex items-center">
                                        <i class="fab fa-twitter text-blue-400 mr-3 text-xl"></i>
                                        <input type="url" id="twitter" name="X"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                            placeholder="Twitter Profile URL" value="{{ $artist->X }}">
                                    </div>

                                    <!-- Pinterest Field -->
                                    <div class="flex items-center">
                                        <i class="fab fa-pinterest text-red-600 mr-3 text-xl"></i>
                                        <input type="url" id="pinterest" name="PINTEREST"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                            placeholder="Pinterest Profile URL" value="{{ $artist->PINTEREST }}">
                                    </div>

                                    <!-- Instagram Field -->
                                    <div class="flex items-center">
                                        <i class="fab fa-instagram text-pink-500 mr-3 text-xl"></i>
                                        <input type="url" id="instagram" name="INSTAGRAM"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                            placeholder="Instagram Profile URL" value="{{ $artist->INSTAGRAM }}">
                                    </div>

                                    <!-- LinkedIn Field -->
                                    <div class="flex items-center">
                                        <i class="fab fa-linkedin text-blue-600 mr-3 text-xl"></i>
                                        <input type="url" id="linkedin" name="LINKEDIN"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                                            placeholder="LinkedIn Profile URL" value="{{ $artist->LINKEDIN }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition duration-200 flex items-center">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Review Artist Modal -->
        <div id="reviewModal" class="modal flex hidden">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-800">Submit a Review</h2>
                    <button onclick="closeReviewModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <form action="{{ route('artist.review',['id'=>$artist->ARTIST_ID]) }}" method="post">
                    @method('PUT')
                    @csrf
                    <!-- Star Rating -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Rating</label>
                        <div class="flex space-x-2">
                            <!-- Stars with dynamic highlighting based on selection -->
                            <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="1"
                                onclick="setRating(1)">&#9733;</span>
                            <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="2"
                                onclick="setRating(2)">&#9733;</span>
                            <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="3"
                                onclick="setRating(3)">&#9733;</span>
                            <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="4"
                                onclick="setRating(4)">&#9733;</span>
                            <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="5"
                                onclick="setRating(5)">&#9733;</span>
                        </div>
                    </div>

                    {{-- rating input --}}
                    <input type="hidden" id="ratingInput" name="rating">

                    <!-- Review Text -->
                    <div>
                        <label for="content" class="block text-gray-700 font-medium mb-1">Review</label>
                        <textarea id="content" name="content" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Write your review..."></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition duration-200">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Review Submitted Confirmation Modal -->
        <div id="reviewSubmittedModal" class="modal flex hidden">
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-800">Review Submitted</h2>
                    <button onclick="closeReviewSubmittedModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-gray-700">Your review has been successfully submitted. Thank you for your
                        feedback!</p>
                    <div class="flex justify-end">
                        <button onclick="closeReviewSubmittedModal()"
                            class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Report Modal -->
        <div id="reportModal" class="modal flex hidden">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-800">Report or Block</h2>
                    <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-gray-800 font-medium">Select an action</p>
                    <div class="flex justify-between items-center border-b border-gray-200 py-3 cursor-pointer hover:bg-gray-100"
                        onclick="openBlockConfirmation()">
                        <span>Block Something4U</span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-200 py-3 cursor-pointer hover:bg-gray-100"
                        onclick="openReportProfileModal()">
                        <span>Report Something4U or entire account</span>
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg mt-4 text-sm text-gray-500">
                        If you found a problem with a post, comment, or message, use the reporting option located in
                        those experiences.
                    </div>
                </div>
            </div>
        </div>

        <!-- Block Confirmation Modal -->
        <div id="blockConfirmationModal" class="modal flex hidden">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
                <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                    <h2 class="text-xl font-semibold text-gray-800">Block</h2>
                    <button onclick="closeBlockConfirmationModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-gray-800 font-medium">You’re about to block Something4U</p>
                    <p class="text-gray-600 text-sm">You’ll no longer be connected, and will lose any endorsements
                        or recommendations from this person.</p>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button onclick="closeBlockConfirmationModal()"
                            class="px-4 py-2 border rounded-full text-gray-700 hover:bg-gray-100">Back</button>
                        <button onclick="confirmBlock()"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700">Block</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Block Confirmation Success Modal -->
        <div id="blockSuccessModal" class="modal flex hidden">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden p-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">Something4U Blocked</h2>
                    <button onclick="closeBlockSuccessModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-gray-600 mt-4">The blocked member won’t receive any notification on this action.</p>
                <div class="flex justify-end mt-6">
                    <button onclick="closeBlockSuccessModal()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-all">Close</button>
                </div>
            </div>
        </div>

        <!-- Report Profile Modal with Steps -->
        <div id="reportProfileModal" class="modal flex hidden">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
                <!-- Step 1: Select Reason -->
                <div class="p-6 space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold text-gray-800">Report this Profile</h2>
                        <button onclick="closeReportProfileModal()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                    <p class="text-gray-600 text-base font-medium">Please select a reason that best describes your
                        report</p>
                    <div class="flex flex-wrap gap-3 mb-6">
                        <!-- Enhanced Report Reasons as Tags -->
                        <button class="reason-tag" onclick="selectReason('Fraud or scam')">Fraud or scam</button>
                        <button class="reason-tag"
                            onclick="selectReason('Misinformation')">Misinformation</button>
                        <button class="reason-tag" onclick="selectReason('Harassment')">Harassment</button>
                        <button class="reason-tag" onclick="selectReason('Graphic content')">Graphic
                            content</button>
                        <button class="reason-tag" onclick="selectReason('Infringement')">Infringement</button>
                        <button class="reason-tag" onclick="selectReason('Illegal activities')">Illegal
                            activities</button>
                    </div>

                    <!-- Step 2: Confirm Reason (Hidden initially) -->
                    <div id="reportConfirmation" class="hidden fade-in">
                        <p class="text-gray-700 font-semibold">You've selected:</p>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <p id="selectedReasonText" class="font-semibold text-gray-800"></p>
                            <p class="text-gray-500 text-sm">Please confirm your reason for reporting.</p>
                        </div>
                        <form action="{{ route('artist.report',['artistId'=>$artist->ARTIST_ID]) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="CONTENT" id="reason-content">
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition-all">Submit report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thank You Modal -->
        <div id="thankYouModal" class="modal flex hidden">
            <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden p-6 space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Thank You</h2>
                    <button onclick="closeThankYouModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <p class="text-gray-700 text-base">We appreciate you helping to keep our community safe. Your
                    report has been submitted successfully.</p>
                <div class="flex justify-end">
                    <button onclick="closeThankYouModal()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-all">Close</button>
                </div>
            </div>
        </div>

        <!-- Hire Freelancer Modal -->
        @if(isset($hire))
        <div id="hireFreelancerModal"
            class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden overflow-y-auto">
            <div
                class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 fade-in overflow-y-auto max-h-[80vh] relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-3xl font-bold text-primary">🚀 Hire a Freelancer</h3>
                    <button onclick="closeHireModal()"
                        class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                        &times;
                    </button>
                </div>

                <!-- Project Title -->
                <div class="mt-6">
                    <h4 class="text-xl font-bold text-gray-700">📌 Project Title</h4>
                    <p class="text-lg text-gray-600 mt-2">{{ $hire->PROJECT_TITLE}}</p>
                </div>

                <!-- Project Description -->
                <div class="mt-6">
                    <h4 class="text-xl font-bold text-gray-700">📝 Project Description</h4>
                    <p class="text-gray-700 mt-2">
                        <strong>Overview:</strong> {{ $hire->PROJECT_DESCR }}
                    </p>
                    <p class="text-gray-700 mt-2">
                        <strong>Timeline:</strong> {{ (new \DateTime($hire->PROJECT_TIMELINE))->format('M d, Y') }}
                    </p>
                </div>

                <!-- Budget/Salary -->
                <div class="mt-6">
                    <h4 class="text-xl font-bold text-gray-700">💰 Budget/Salary</h4>
                    <p class="text-gray-700 mt-2">
                        <strong>Compensation:</strong> {{ $hire->PROJECT_BUDGET }}
                    </p>
                </div>

                <!-- Requirements -->
                <div class="mt-6">
                    <h4 class="text-xl font-bold text-gray-700">📋 Requirements</h4>
                    <p class="text-gray-700 mt-2">
                        <strong>Skills Needed:</strong> {{ $hire->PROJECT_SKILLS }}
                    </p>
                    <p class="text-gray-700 mt-2">
                        <strong>Experience Level:</strong> {{ $hire->PROJECT_EXPERIENCE_LEVEL }}
                    </p>
                    <p class="text-gray-700 mt-2">
                        <strong>Other Requirements:</strong> {{ $hire->OTHER_REQUIREMENTS }}
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between items-center mb-6 mt-12">
                    <div class="flex space-x-4">
                        @if($artistItSelf)
                        <!-- Edit Button -->
                        <button onclick="openHireUpdateFormModal()"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 transition">
                            Edit
                        </button>
                        <!-- Delete Button -->
                        <button onclick="openDeleteHireConfirmation()"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-700 transition">
                            Delete
                        </button>
                        @endif
                    </div>
                    <!-- Contact Button -->
                    <button onclick="openChatWindow()"
                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                        Contact Something4U
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- @if($hire != null) --}}
        <!-- Delete Confirmation Modal -->
        <div id="deleteHireConfirmationModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Confirm Deletion</h3>
                <p class="text-gray-700 mb-6">Are you sure you want to delete this commission?</p>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeDeleteHireConfirmation()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <a href="{{ route('hire.destroy',['hireId'=>$hire->ARTIST_HIRE_ID ?? 0]) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">delete</a>
                </div>
            </div>
        </div>
        {{-- @endif --}}

        <!-- Hire Freelancer Form Modal -->
        <div id="hireFreelancerFormModal" class="modal">
            <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 overflow-y-auto max-h-[80vh] relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-3xl font-bold text-primary">🚀 Hire a Freelancer</h3>
                    <button onclick="closeHireFormModal()"
                        class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                        &times;
                    </button>
                </div>

                <form class="space-y-6" action="{{ route('hire.store') }}" method="post">
                    @csrf
                    <!-- Project Title -->
                    <div>
                        <label for="projectTitle" class="block text-gray-700 font-medium">📌 Project Title</label>
                        <input type="text" id="projectTitle" name="projectTitle"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="Enter the project title" required>
                    </div>

                    <!-- Project Description -->
                    <div>
                        <label for="projectDescription" class="block text-gray-700 font-medium">📝 Project
                            Description</label>
                        <textarea id="projectDescription" name="projectDescription"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="4"
                            placeholder="Provide a brief description of the project" required></textarea>
                        <p class="text-gray-500 text-sm mt-2">Include goals, any unique requirements, and the
                            estimated timeline or deadline for the project.</p>
                    </div>

                    <!-- Timeline -->
                    <div class="mt-6">
                        <label for="timeline" class="block text-gray-700 font-medium">⏳ Timeline</label>
                        <input type="date" id="timeline" name="timeline"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary mt-2"
                            placeholder="Specify estimated duration or deadline" required>
                    </div>

                    <!-- Budget/Salary -->
                    <div>
                        <label for="budget" class="block text-gray-700 font-medium">💰 Budget/Salary</label>
                        <input type="text" id="budget" name="budget"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="Enter the budget range (e.g., $500 - $1000)" required>
                        <p class="text-gray-500 text-sm mt-2">Specify payment terms: milestone-based, per hour, or
                            per project completion.</p>
                    </div>

                    <!-- Requirements -->
                    <div>
                        <label for="skills" class="block text-gray-700 font-medium">📋 Skills Needed</label>
                        <input type="text" id="skills" name="skills"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="List essential skills (e.g., graphic design, HTML, JavaScript)" required>
                    </div>
                    <div>
                        <label for="experienceLevel" class="block text-gray-700 font-medium">📈 Experience
                            Level</label>
                        <select id="experienceLevel" name="experienceLevel"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            required>
                            <option value="" disabled selected>Select experience level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label for="otherRequirements" class="block text-gray-700 font-medium">🔍 Other
                            Requirements</label>
                        <textarea id="otherRequirements" name="otherRequirements"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="2"
                            placeholder="Additional requirements, like language proficiency or certifications" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                            📲 Post Project
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($hire != null)
        <div id="hireFreelancerUpdateFormModal" class="modal">
            <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 overflow-y-auto max-h-[80vh] relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-3xl font-bold text-primary">🚀 Update Hire a Freelancer</h3>
                    <button onclick="closeHireUpdateFormModal()"
                        class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                        &times;
                    </button>
                </div>

                <form class="space-y-6" action="{{ route('hire.update',['hireId' => $hire->ARTIST_HIRE_ID]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- Project Title -->
                    <div>
                        <label for="projectTitle" class="block text-gray-700 font-medium">📌 Project Title</label>
                        <input type="text" id="projectTitleUpdate" name="projectTitle"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="Enter the project title" value="{{ $hire->PROJECT_TITLE }}" required>
                    </div>

                    <!-- Project Description -->
                    <div>
                        <label for="projectDescription" class="block text-gray-700 font-medium">📝 Project
                            Description</label>
                        <textarea id="projectDescriptionUpdate" name="projectDescription"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="4"
                            placeholder="Provide a brief description of the project" required>{{ $hire->PROJECT_DESCR }}</textarea>
                        <p class="text-gray-500 text-sm mt-2">Include goals, any unique requirements, and the
                            estimated timeline or deadline for the project.</p>
                    </div>

                    <!-- Timeline -->
                    <div class="mt-6">
                        <label for="timeline" class="block text-gray-700 font-medium">⏳ Timeline</label>
                        <input type="date" id="timelineUpdate" name="timeline"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary mt-2"
                            placeholder="Specify estimated duration or deadline" value="{{ (new \DateTime($hire->PROJECT_TIMELINE))->format('Y-m-d') }}" required>
                    </div>

                    <!-- Budget/Salary -->
                    <div>
                        <label for="budget" class="block text-gray-700 font-medium">💰 Budget/Salary</label>
                        <input type="text" id="budgetUpdate" name="budget"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="Enter the budget range (e.g., $500 - $1000)" value="{{ $hire->PROJECT_BUDGET }}" required>
                        <p class="text-gray-500 text-sm mt-2">Specify payment terms: milestone-based, per hour, or
                            per project completion.</p>
                    </div>

                    <!-- Requirements -->
                    <div>
                        <label for="skills" class="block text-gray-700 font-medium">📋 Skills Needed</label>
                        <input type="text" id="skillsUpdate" name="skills"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="List essential skills (e.g., graphic design, HTML, JavaScript)" value="{{ $hire->PROJECT_SKILLS }}" required>
                    </div>
                    <div>
                        <label for="experienceLevel" class="block text-gray-700 font-medium">📈 Experience
                            Level</label>
                        <select id="experienceLevelUpdate" name="experienceLevel"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            required>
                            <option value="Beginner" @if($hire->PROJECT_EXPERIENCE_LEVEL == "Beginer") selected @endif>Beginner</option>
                            <option value="Intermediate" @if($hire->PROJECT_EXPERIENCE_LEVEL == "Intermediate") selected @endif>Intermediate</option>
                            <option value="Advanced" @if($hire->PROJECT_EXPERIENCE_LEVEL == "Advanced") selected @endif>Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label for="otherRequirements" class="block text-gray-700 font-medium">🔍 Other
                            Requirements</label>
                        <textarea id="otherRequirementsUpdate" name="otherRequirements"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="2"
                            placeholder="Additional requirements, like language proficiency or certifications" required>{{ $hire->OTHER_REQUIREMENTS }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-8">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                            📲 Update Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif


<script>
    document.getElementById('profilePictureUpload').addEventListener('change', function (event) {
        const file = event.target.files[0]; // Get the selected file
        const labelElement = document.querySelector('label[for="profilePictureUpload"]'); // Select the label

        if (file) {
            const reader = new FileReader(); // Create a FileReader to read the file
            reader.onload = function (e) {
                // Update the image preview with the uploaded picture
                document.getElementById('profilePicturePreview').src = e.target.result;

                // Change the bg-opacity class
                labelElement.classList.remove('bg-opacity-50');
                labelElement.classList.add('bg-opacity-30'); // Adjust as needed

                labelElement.classList.remove('hover:bg-opacity-70');
                labelElement.classList.add('hover:bg-opacity-50');
            };
            reader.readAsDataURL(file); // Read the file as a Data URL
        }
    });

    // Open chat window
    function openChatWindow() {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.classList.remove('hidden');
    }

    // Close chat window
    function closeChatWindow() {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.classList.add('hidden');
    }

    // Toggle chat size (expand/collapse)
    function toggleChatSize() {
        const chatContainer = document.getElementById('chatContainer');
        chatContainer.classList.toggle('expanded'); // Apply expanded style
    }

    function toggleFollow() {
        const button = document.getElementById("followButton");
        const icon = document.getElementById("followIcon");
        const text = document.getElementById("followText");

        if (text.innerText === "Follow") {
            // Change to "Following"
            text.innerText = "Following";
            button.classList.replace("bg-green-500", "bg-gray-500"); // Change button color
            icon.classList.replace("fa-user-plus", "fa-user-check"); // Change icon to user-check
        } else {
            // Change back to "Follow"
            text.innerText = "Follow";
            button.classList.replace("bg-gray-500", "bg-green-500"); // Revert button color
            icon.classList.replace("fa-user-check", "fa-user-plus"); // Revert icon to user-plus
        }
    }

    // Open the Edit Profile modal
    function openEditModal() {
        document.getElementById('editModal').style.display = 'flex';
    }

    // Close the Edit Profile modal
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    let selectedRating = 0;

    // Function to handle star rating selection
    function setRating(rating) {
        selectedRating = rating;
        document.getElementById('ratingInput').value = selectedRating;
        const stars = document.querySelectorAll('#reviewModal .star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('text-yellow-500'); // Highlight selected stars
                star.classList.remove('text-gray-300'); // Remove gray from selected stars
            } else {
                star.classList.remove('text-yellow-500');
                star.classList.add('text-gray-300');
            }
        });
    }
    // Submit Review function to handle form submission
    function submitReview() {
        const reviewText = document.getElementById('reviewText').value;
        if (selectedRating === 0) {
            alert("Please select a star rating.");
            return;
        }
        if (reviewText.trim() === "") {
            alert("Please enter your review text.");
            return;
        }

        // Close review modal and show confirmation modal
        closeReviewModal();
        openReviewSubmittedModal();

        // Clear the modal inputs
        document.getElementById('reviewText').value = '';
        setRating(0); // Reset stars
    }

    // Functions to open and close modals
    function openReviewModal() {
        document.getElementById('reviewModal').style.display = 'flex';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }

    function openReviewSubmittedModal() {
        document.getElementById('reviewSubmittedModal').classList.remove('hidden');
        document.getElementById('reviewSubmittedModal').style.display = 'flex';
    }

    function closeReviewSubmittedModal() {
        document.getElementById('reviewSubmittedModal').style.display = 'none';
    }

    function openReportModal() {
        document.getElementById('reportModal').style.display = 'flex';
    }

    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
    }

    function openBlockConfirmation() {
        closeReportModal();
        document.getElementById('blockConfirmationModal').style.display = 'flex';
    }

    function closeBlockConfirmationModal() {
        document.getElementById('blockConfirmationModal').style.display = 'none';
    }

    function confirmBlock() {
        closeBlockConfirmationModal();
        document.getElementById('blockSuccessModal').style.display = 'flex';
    }

    function closeBlockSuccessModal() {
        document.getElementById('blockSuccessModal').style.display = 'none';
    }

    function openReportProfileModal() {
        closeReportModal();
        document.getElementById('reportProfileModal').style.display = 'flex';
        resetReportModal();
    }

    function closeReportProfileModal() {
        document.getElementById('reportProfileModal').style.display = 'none';
    }

    function resetReportModal() {
        document.getElementById('reportConfirmation').classList.add('hidden');
        document.querySelectorAll('.reason-tag').forEach(tag => tag.classList.remove('selected'));
        selectedReasonText = '';
    }

    let selectedReasonText = '';

    function selectReason(reason) {
        selectedReasonText = reason;
        document.querySelectorAll('.reason-tag').forEach(tag => tag.classList.remove('selected'));
        event.target.classList.add('selected');

        document.getElementById('selectedReasonText').textContent = selectedReasonText;
        document.getElementById('reason-content').value = selectedReasonText;
        document.getElementById('reportConfirmation').classList.remove('hidden');
    }

    function submitReport() {
        closeReportProfileModal();
        document.getElementById('thankYouModal').style.display = 'flex';
    }

    function closeThankYouModal() {
        document.getElementById('thankYouModal').style.display = 'none';
    }

    function openHireModal() {
        document.getElementById('hireFreelancerModal').style.display = 'flex';
    }

    function closeHireModal() {
        document.getElementById('hireFreelancerModal').style.display = 'none';
    }

    function contactFreelancer() {
        alert("Contacting Freelancer!");
        closeHireModal();
    }

    function openHireFormModal() {
        document.getElementById('hireFreelancerFormModal').classList.add('active');
    }

    function openHireUpdateFormModal() {
        closeHireModal()
        document.getElementById('hireFreelancerUpdateFormModal').classList.add('active');
    }

    function closeHireFormModal() {
        document.getElementById('hireFreelancerFormModal').classList.remove('active');
        console.log('close hire form')
    }

    function closeHireUpdateFormModal() {
        document.getElementById('hireFreelancerUpdateFormModal').classList.remove('active');
    }

    function openDeleteHireConfirmation() {
        closeHireModal()
        document.getElementById('deleteHireConfirmationModal').classList.remove('hidden');
    }

    function closeDeleteHireConfirmation() {
        document.getElementById('deleteHireConfirmationModal').classList.add('hidden');
    }

    function confirmDelete() {
        alert("Commission deleted successfully!");
        closeDeleteConfirmation();
        closeHireModal();
    }

    function editCommission() {
        alert("Mike benerin ya!");
    }

    document.getElementById('optionMenuArtistToggle').addEventListener('click', () => {
        const optionMenuArtist = document.getElementById('optionMenuArtist');

        // Check if the 'hidden' class is present
        if (optionMenuArtist.classList.contains('hidden')) {
            console.log('The hidden class exists!');
            optionMenuArtist.classList.remove('hidden'); // Remove the hidden class
        } else {
            console.log('The hidden class does not exist.');
            optionMenuArtist.classList.add('hidden'); // Add the hidden class if needed
        }
    });

    async function saveProfileChanges(artistId) {
        const formData = new FormData();

        const name = document.getElementById('name').value;
        const headline = document.getElementById('headline').value;
        const bio = document.getElementById('bio').value;
        const locationValue = document.getElementById('location').value;
        const profilePicture = document.getElementById('profilePictureUpload').files[0];

        formData.append('artistId', artistId);
        formData.append('name', name);
        formData.append('headline', headline);
        formData.append('bio', bio);
        formData.append('location', locationValue);
        if (profilePicture) {
            formData.append('profile_picture', profilePicture);
        }

        try {
            const response = await fetch(`/artist/profile/update/${artistId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            if (response.ok) {
                const result = await response.json();
                alert(result.message || 'Profile updated successfully!');
                closeEditModal();
                window.location.reload();
            } else if (response.status === 422) {
                const errorData = await response.json();
                displayValidationErrors(errorData.errors); // Call error display function
            } else {
                const error = await response.json();
                alert('Error updating profile: ' + (error.error || 'Unexpected error occurred'));
            }
        } catch (err) {
            console.error('Error:', err);
            alert('An unexpected error occurred. Please try again.');
        }
    }

    // Display Validation Errors
    function displayValidationErrors(errors) {
        if (errors.name) {
            document.getElementById('usernameExistError').innerText = errors.name[0];
        }
        if (errors.bio) {
            alert(errors.bio[0]); // Example for bio error
        }
        if (errors.headline) {
            alert(errors.headline[0]); // Example for headline error
        }
        if (errors.location) {
            alert(errors.location[0]); // Example for location error
        }
        if (errors.profile_picture) {
            document.getElementById('profilePictureUploadError').innerText = errors.profile_picture[0]; // Example for profile picture error
        }
    }

    async function openEditProfileModal() {
        // Show the modal
        const modal = document.getElementById('editModal');
        modal.style.display = 'flex';

        // try {
        //     // Fetch artist profile data from the server
        //     const response = await fetch(`/artist/profile/${artistId}`);
        //     if (!response.ok) throw new Error('Failed to fetch artist profile');

        //     const data = await response.json();

        //     // Populate the modal fields with the fetched data
        //     // document.getElementById('name').value = data.name || '';
        //     // document.getElementById('headline').value = data.role || '';
        //     // document.getElementById('bio').value = data.bio || '';
        //     // document.getElementById('location').value = data.location || '';
        //     // document.getElementById('twitter').value = data.social_media.twitter || '';
        //     // document.getElementById('pinterest').value = data.social_media.pinterest || '';
        //     // document.getElementById('instagram').value = data.social_media.instagram || '';
        //     // document.getElementById('linkedin').value = data.social_media.linkedin || '';

        // } catch (error) {
        //     console.error('Error fetching profile data:', error);
        //     alert('Could not load profile data. Please try again.');
        //     modal.style.display = 'none'; // Hide modal if fetching data fails
        // }
    }
</script>

</body>
</html>
{{-- @endsection --}}
