<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Options Menu styling */
        .optionsMenu {
            display: none;
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

        .ellipsisButton:focus + .optionsMenu,
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
<body>
    <div class="container mx-auto px-4 py-6">
            <div class="flex">
                <!-- Sidebar: Profile Information -->
                <div class="w-1/4 relative">
                    <div class="bg-white p-4 rounded-lg shadow-lg relative">
                        <!-- Ellipsis Button -->
                    <button class="ellipsisButton absolute top-2 right-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                        </svg>
                    </button>
                <!-- Options Menu -->
                <div class="optionsMenu bg-white rounded-lg shadow-lg py-2 w-48">
                    <!-- Edit Profile Button -->
                    <button onclick="openEditModal()" class="block w-full text-left px-4 py-3 hover:bg-indigo-100 hover:text-indigo-600 transition-colors duration-200 font-medium text-gray-700 flex items-center">
                            <i class="fas fa-user-edit mr-3 text-indigo-500"></i>
                            Edit Profile
                        </button>

                    <!-- Review Artist Button -->
                    <button onclick="openReviewModal()" class="block w-full text-left px-4 py-3 hover:bg-green-100 hover:text-green-600 transition-colors duration-200 font-medium text-gray-700 flex items-center">
                        <i class="fas fa-star mr-3 text-green-500"></i>
                        Review Artist
                    </button>

                    <!-- Hire Freelance Button -->
                    <button onclick="openFormModal()" class="block w-full text-left px-4 py-3 hover:bg-green-100 hover:text-green-600 transition-colors duration-200 font-medium text-gray-700 flex items-center">
                        <i class="fas fa-file mr-3 text-blue-500"></i>
                        Hire Freelance
                    </button>

                    <!-- Report Artist Button (styled in red) -->
                    <button onclick="openReportModal()" class="block w-full text-left px-4 py-3 hover:bg-red-100 hover:bg-red-100 text-red-600 hover:text-red-700 transition-colors duration-200 font-medium flex items-center">
                        <i class="fa fa-flag mr-3 text-red-600"></i>
                        Report / Block
                    </button>
                </div>
                        <div class="text-center">
                            <img src="{{ asset('images/Assets/About me/sam.jpg') }}" alt="Profile picture" class="w-24 h-24 rounded-full mx-auto object-cover">
                            <h2 class="text-xl font-bold mt-4">Something4U</h2>
                            <p class="text-gray-600">Freelance Illustrator</p>
                            <p class="text-gray-600">Art is heaven for me, check my protfolio please!</p>
                            <p class="text-gray-600"><i class="fas fa-map-marker-alt"></i> Malang, East Java, Indonesia</p>

                            <button id="followButton" onclick="toggleFollow()" class="bg-green-500 text-white px-4 py-2 rounded-full w-full mt-4 flex items-center justify-center">
                                <i id="followIcon" class="fas fa-user-plus mr-2"></i>
                                <span id="followText">Follow</span>
                            </button>
                            <button onclick="openChatWindow()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full w-full mt-1">
                                <i class="fas fa-envelope mr-2"></i> Message
                            </button>
                            <button onclick="openFormModal()" 
                                class="bg-indigo-500 text-white px-4 py-2 rounded-lg shadow-md w-full mt-4 text-center hover:bg-indigo-600 transition duration-200">
                                <h1 class="text-sm font-semibold">Hire Project</h1>
                            </button>
                            <div class="flex justify-between mt-4 space-x-4">
                                <!-- Review Artist -->
                                <button onclick="openReviewModal()" 
                                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md w-1/2 text-center hover:bg-yellow-600 transition duration-200">
                                    <i class="fas fa-star mr-2"></i> Review 
                                </button>

                                <!-- Report -->
                                <button onclick="openReportModal()" 
                                    class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md w-1/2 text-center hover:bg-red-600 transition duration-200">
                                    <i class="fa fa-flag mr-2"></i> Report
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-center items-center">
                            <button onclick="openHireModal()" class="bg-white border border-indigo-500 rounded-lg p-2 px-4 shadow-md">
                            <h1 class="text-sm font-semibold text-center">Hire Something4U</h1>
                            <div class="flex items-center mt-1">
                                <i class="fas fa-clipboard-list text-indigo-500 mr-2"></i>
                                <div>
                                    <p class="text-sm font-small">Freelance/Project</p>
                                    <p class="text-gray-500 text-xs">Available</p>
                                </div>
                            </div>
                        </div>
                            </button>

                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Project Views</span>
                                <span class="text-gray-800">225,210</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Likes</span>
                                <span class="text-gray-800">149,518</span>
                            </div>
                            <div class="flex justify-between">
                                <a href="{{ route('followers') }}" class="text-gray-600 hover:underline">Followers</a>
                                <a href="{{ route('followers') }}" class="text-gray-800">85,518</a>
                            </div>
                            <div class="flex justify-between mt-2">
                                <a href="{{ route('following') }}" class="text-gray-600 hover:underline">Following</a>
                                <a href="{{ route('following') }}" class="text-gray-800">1,490</a>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-600">Artist Overall Rating</span>
                                <span class="text-gray-800">4.9</span>
                            </div>
                        </div>

                        <div class="flex justify-center mt-4 space-x-4">
                            <button class="text-gray-600"><i class="fab fa-instagram"></i></button>
                            <button class="text-gray-600"><i class="fab fa-pinterest"></i></button>
                            <button class="text-gray-600"><i class="fab fa-twitter"></i></button>
                            <button class="text-gray-600"><i class="fab fa-linkedin"></i></button>
                        </div>
                    </div>

                    <!-- Posts Section -->
                    <div class="bg-white p-4 rounded-lg shadow-lg mt-4">
                        <h3 class="text-lg font-bold">Posts</h3>
                        <div class="mt-4">
                            <div class="flex items-start">
                                <img src="{{ asset('images/Assets/Community/Media/Photos/media 5.jpg') }}" alt="Post profile picture" class="w-12 h-12 rounded-full object-cover">
                                <div class="ml-4">
                                    <h4 class="font-bold">Something4U</h4>
                                    <p class="text-gray-600">I'll hibernate for a while :)</p>
                                    <img src="{{ asset('images/Assets/Community/Media/Photos/media 6.jpg') }}" alt="Post image" class="mt-2 rounded-lg object-cover w-full h-32">
                                    <div class="flex justify-between items-center mt-2">
                                        <div class="flex space-x-10">
                                            <!-- like button -->
                                            <button class="text-gray-600 flex flex-col items-center">
                                                <img src="/images/heart.svg" alt="Shopping Cart" class="w-5 h-5">
                                                <span class="text-xs mt-1">Like</span>
                                            </button>
                                            <!-- comment button -->
                                            <button class="text-gray-600 flex flex-col items-center">
                                                <img src="/images/comment.svg" alt="Shopping Cart" class="w-5 h-5">
                                                <span class="text-xs mt-1">Comment</span>
                                            </button>
                                            <!-- share button -->
                                            <button class="text-gray-600 flex flex-col items-center">
                                                <img src="/images/share.svg" alt="Shopping Cart" class="w-5 h-5">
                                                <span class="text-xs mt-1">Share</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
<!-- Edit Profile Modal -->
<div id="editModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden overflow-y-auto">
    <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 fade-in overflow-y-auto max-h-[80vh] relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-3xl font-bold text-primary">📝 Edit Profile</h2>
            <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                &times;
            </button>
        </div>

        <!-- Make the content area scrollable by setting a fixed height -->
        <div class="relative max-h-[70vh] overflow-y-auto p-6 space-y-5">
            <!-- Profile Cover Image -->
            <div class="relative">
                <img src="https://via.placeholder.com/600x200" alt="Background image" class="w-full h-48 object-cover">
                <button class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition duration-200">
                    <i class="fas fa-camera"></i>
                </button>
            </div>

            <!-- Profile Avatar Image -->
            <div class="relative -mt-12 flex justify-center">
                <div class="relative">
                    <img src="https://via.placeholder.com/100" alt="Profile picture" class="w-28 h-28 rounded-full border-4 border-white object-cover shadow-lg">
                    <button class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white rounded-full hover:bg-opacity-70 transition duration-200">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>

            <!-- Form Section -->
            <div class="space-y-6">
                <!-- Name Field -->
            <div>
                <label for="name" class="block text-gray-700 font-medium">📌 Name</label>
                <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Enter your name" required>
            </div>

            <!-- Headline Field -->
            <div>
                <label for="headline" class="block text-gray-700 font-medium">📋 Headline</label>
                <input type="text" id="headline" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Your headline (e.g., Freelance Illustrator)" required>
            </div>

            <!-- Bio Field -->
            <div>
                <label for="bio" class="block text-gray-700 font-medium">📝 Bio</label>
                <textarea id="bio" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Write a short bio..." required></textarea>
            </div>

            <!-- Location Fields -->
            <div>
                <label class="block text-gray-700 font-medium">📍 Location</label>
                <div class="flex space-x-4 mt-2">
                    <!-- Country Field (Negara) -->
                    <input type="text" id="country" class="w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Country" required>
                    
                    <!-- Province Field (Provinsi) -->
                    <input type="text" id="province" class="w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Provience" required>
                    
                    <!-- City Field (Kota) -->
                    <input type="text" id="city" class="w-1/3 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="City" required>
                </div>
            </div>

            <!-- Social Media Links -->
            <div>
                <label class="block text-gray-700 font-medium">🌐 Social Media</label>
                <div class="space-y-4 mt-2">
                    <!-- Twitter Field -->
                    <div class="flex items-center">
                        <i class="fab fa-twitter text-blue-400 mr-3 text-xl"></i>
                        <input type="url" id="twitter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Twitter Profile URL">
                    </div>
                    <!-- Pinterest Field -->
                    <div class="flex items-center">
                        <i class="fab fa-pinterest text-red-600 mr-3 text-xl"></i>
                        <input type="url" id="pinterest" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Pinterest Profile URL">
                    </div>
                    <!-- Instagram Field -->
                    <div class="flex items-center">
                        <i class="fab fa-instagram text-pink-500 mr-3 text-xl"></i>
                        <input type="url" id="instagram" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Instagram Profile URL">
                    </div>
                    <!-- LinkedIn Field -->
                    <div class="flex items-center">
                        <i class="fab fa-linkedin text-blue-600 mr-3 text-xl"></i>
                        <input type="url" id="linkedin" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="LinkedIn Profile URL">
                    </div>
                </div>
            </div>

                <!-- Save Button -->
                <div class="flex justify-end mt-6">
                    <button onclick="closeEditModal()" class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition duration-200 flex items-center">
                     Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review Artist Modal -->
<div id="reviewModal" class="modal flex">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800">Submit a Review</h2>
            <button onclick="closeReviewModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <!-- Star Rating -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Rating</label>
                <div class="flex space-x-2">
                    <!-- Stars with dynamic highlighting based on selection -->
                    <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="1" onclick="setRating(1)">&#9733;</span>
                    <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="2" onclick="setRating(2)">&#9733;</span>
                    <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="3" onclick="setRating(3)">&#9733;</span>
                    <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="4" onclick="setRating(4)">&#9733;</span>
                    <span class="star cursor-pointer text-gray-300 text-2xl" data-rating="5" onclick="setRating(5)">&#9733;</span>
                </div>
            </div>

            <!-- Review Text -->
            <div>
                <label for="reviewText" class="block text-gray-700 font-medium mb-1">Review</label>
                <textarea id="reviewText" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Write your review..."></textarea>
            </div>

            <div class="flex justify-end">
                <button onclick="submitReview()" class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition duration-200">Submit</button>
            </div>
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
            <p class="text-gray-700">Your review has been successfully submitted. Thank you for your feedback!</p>
            <div class="flex justify-end">
                <button onclick="closeReviewSubmittedModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Main Report Modal -->
<div id="reportModal" class="modal flex">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800">Report or Block</h2>
                <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-gray-800 font-medium">Select an action</p>
                <div class="flex justify-between items-center border-b border-gray-200 py-3 cursor-pointer hover:bg-gray-100" onclick="openBlockConfirmation()">
                    <span>Block Something4U</span>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
                <div class="flex justify-between items-center border-b border-gray-200 py-3 cursor-pointer hover:bg-gray-100" onclick="openReportProfileModal()">
                    <span>Report Something4U or entire account</span>
                    <i class="fas fa-chevron-right text-gray-400"></i>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg mt-4 text-sm text-gray-500">
                    If you found a problem with a post, comment, or message, use the reporting option located in those experiences.
                </div>
            </div>
        </div>
    </div>

    <!-- Block Confirmation Modal -->
    <div id="blockConfirmationModal" class="modal flex">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800">Block</h2>
                <button onclick="closeBlockConfirmationModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-gray-800 font-medium">You’re about to block Something4U</p>
                <p class="text-gray-600 text-sm">You’ll no longer be connected, and will lose any endorsements or recommendations from this person.</p>
                <div class="flex justify-end space-x-2 mt-4">
                    <button onclick="closeBlockConfirmationModal()" class="px-4 py-2 border rounded-full text-gray-700 hover:bg-gray-100">Back</button>
                    <button onclick="confirmBlock()" class="px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700">Block</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Block Confirmation Success Modal -->
    <div id="blockSuccessModal" class="modal flex">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Something4U Blocked</h2>
                <button onclick="closeBlockSuccessModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="text-gray-600 mt-4">The blocked member won’t receive any notification on this action.</p>
            <div class="flex justify-end mt-6">
                <button onclick="closeBlockSuccessModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-all">Close</button>
            </div>
        </div>
    </div>

    <!-- Report Profile Modal with Steps -->
    <div id="reportProfileModal" class="modal flex">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden">
            <!-- Step 1: Select Reason -->
            <div class="p-6 space-y-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Report this Profile</h2>
                    <button onclick="closeReportProfileModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <p class="text-gray-600 text-base font-medium">Please select a reason that best describes your report</p>
                <div class="flex flex-wrap gap-3 mb-6">
                    <!-- Enhanced Report Reasons as Tags -->
                    <button class="reason-tag" onclick="selectReason('Fraud or scam')">Fraud or scam</button>
                    <button class="reason-tag" onclick="selectReason('Misinformation')">Misinformation</button>
                    <button class="reason-tag" onclick="selectReason('Harassment')">Harassment</button>
                    <button class="reason-tag" onclick="selectReason('Graphic content')">Graphic content</button>
                    <button class="reason-tag" onclick="selectReason('Infringement')">Infringement</button>
                    <button class="reason-tag" onclick="selectReason('Illegal activities')">Illegal activities</button>
                </div>

                <!-- Step 2: Confirm Reason (Hidden initially) -->
                <div id="reportConfirmation" class="hidden fade-in">
                    <p class="text-gray-700 font-semibold">You've selected:</p>
                    <div class="p-4 bg-gray-100 rounded-lg">
                        <p id="selectedReasonText" class="font-semibold text-gray-800"></p>
                        <p class="text-gray-500 text-sm">Please confirm your reason for reporting.</p>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button onclick="submitReport()" class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition-all">Submit report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thank You Modal -->
    <div id="thankYouModal" class="modal flex">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg overflow-hidden p-6 space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800">Thank You</h2>
                <button onclick="closeThankYouModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <p class="text-gray-700 text-base">We appreciate you helping to keep our community safe. Your report has been submitted successfully.</p>
            <div class="flex justify-end">
                <button onclick="confirmBlock()" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition-all">Close</button>
            </div>
        </div>
    </div>

    <!-- Hire Freelancer Modal -->
    <div id="hireFreelancerModal" class="modal fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden overflow-y-auto">
    <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 fade-in overflow-y-auto max-h-[80vh] relative">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-3xl font-bold text-primary">🚀 Hire a Freelancer</h3>
            <button onclick="closeHireModal()" class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                &times;
            </button>
        </div>
        
        <!-- Project Title -->
        <div class="mt-6">
            <h4 class="text-xl font-bold text-gray-700">📌 Project Title</h4>
            <p class="text-lg text-gray-600 mt-2">Custom Portrait Illustration for Family Gift</p>
        </div>

        <!-- Project Description -->
        <div class="mt-6">
            <h4 class="text-xl font-bold text-gray-700">📝 Project Description</h4>
            <p class="text-gray-700 mt-2">
                <strong>Overview:</strong> We are looking to hire an artist to create a custom digital portrait of a family of four. The portrait should have a warm, inviting style, capturing the family members' likeness and unique personalities. We aim to use this illustration as a holiday gift, so it should have a festive touch.
            </p>
            <p class="text-gray-700 mt-2">
                <strong>Timeline:</strong> Completion needed within 3 weeks.
            </p>
        </div>

        <!-- Budget/Salary -->
        <div class="mt-6">
            <h4 class="text-xl font-bold text-gray-700">💰 Budget/Salary</h4>
            <p class="text-gray-700 mt-2">
                <strong>Compensation:</strong> Rp.300.000 - Rp.500.000
            </p>
            <p class="text-gray-700 mt-2">
                <strong>Payment Terms:</strong> 50% upfront, 50% upon final approval of the artwork
            </p>
        </div>

        <!-- Requirements -->
        <div class="mt-6">
            <h4 class="text-xl font-bold text-gray-700">📋 Requirements</h4>
            <p class="text-gray-700 mt-2">
                <strong>Skills Needed:</strong> Proficiency in digital illustration, portrait artistry, and experience in custom family portraits.
            </p>
            <p class="text-gray-700 mt-2">
                <strong>Experience Level:</strong> Intermediate
            </p>
            <p class="text-gray-700 mt-2">
                <strong>Other Requirements:</strong> Ability to add a festive theme to the illustration (e.g., holiday background, seasonal colors).
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center mb-6 mt-12">
        <div class="flex space-x-4">
            <!-- Edit Button -->
            <button onclick="editCommission()" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 transition">
                    Edit
                </button>
                <!-- Delete Button -->
                <button onclick="openDeleteConfirmation()" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-700 transition">
                    Delete
                </button>
            </div>
            <!-- Contact Button -->
            <button onclick="openChatWindow()" class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                Contact Something4U
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmationModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Confirm Deletion</h3>
        <p class="text-gray-700 mb-6">Are you sure you want to delete this commission?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteConfirmation()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                Cancel
            </button>
            <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Delete
            </button>
        </div>
    </div>
</div>

<!-- Hire Freelancer Form Modal -->
<div id="hireFreelancerFormModal" class="modal">
        <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 overflow-y-auto max-h-[80vh] relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-3xl font-bold text-primary">🚀 Hire a Freelancer</h3>
                <button onclick="closeFormModal()" class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                    &times;
                </button>
            </div>
        
        <form class="space-y-6">
            <!-- Project Title -->
            <div>
                <label for="projectTitle" class="block text-gray-700 font-medium">📌 Project Title</label>
                <input type="text" id="projectTitle" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Enter the project title" required>
            </div>

            <!-- Project Description -->
            <div>
                <label for="projectDescription" class="block text-gray-700 font-medium">📝 Project Description</label>
                <textarea id="projectDescription" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="4" placeholder="Provide a brief description of the project" required></textarea>
                <p class="text-gray-500 text-sm mt-2">Include goals, any unique requirements, and the estimated timeline or deadline for the project.</p>
            </div>

            <!-- Timeline -->
            <div class="mt-6">
                <label for="timeline" class="block text-gray-700 font-medium">⏳ Timeline</label>
                <input type="text" id="timeline" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary mt-2" placeholder="Specify estimated duration or deadline" required>
            </div>

            <!-- Budget/Salary -->
            <div>
                <label for="budget" class="block text-gray-700 font-medium">💰 Budget/Salary</label>
                <input type="text" id="budget" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="Enter the budget range (e.g., $500 - $1000)" required>
                <p class="text-gray-500 text-sm mt-2">Specify payment terms: milestone-based, per hour, or per project completion.</p>
            </div>

            <!-- Requirements -->
            <div>
                <label for="skills" class="block text-gray-700 font-medium">📋 Skills Needed</label>
                <input type="text" id="skills" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" placeholder="List essential skills (e.g., graphic design, HTML, JavaScript)" required>
            </div>
            <div>
                <label for="experienceLevel" class="block text-gray-700 font-medium">📈 Experience Level</label>
                <select id="experienceLevel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" required>
                    <option value="" disabled selected>Select experience level</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
            <div>
                <label for="otherRequirements" class="block text-gray-700 font-medium">🔍 Other Requirements</label>
                <textarea id="otherRequirements" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="2" placeholder="Additional requirements, like language proficiency or certifications"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-8">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                    📲 Post Project
                </button>
            </div>
        </form>
    </div>
</div>


<script>
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
        function openFormModal() {
        document.getElementById('hireFreelancerFormModal').classList.add('active');
        }

        function closeFormModal() {
            document.getElementById('hireFreelancerFormModal').classList.remove('active');
        }
        function openDeleteConfirmation() {
        document.getElementById('deleteConfirmationModal').style.display = 'flex';
        }

        function closeDeleteConfirmation() {
            document.getElementById('deleteConfirmationModal').style.display = 'none';
        }

        function confirmDelete() {
            alert("Commission deleted successfully!");
            closeDeleteConfirmation();
            closeHireModal();
        }

        function editCommission() {
            alert("Mike benerin ya!");
        }

</script>
</body>
</html>