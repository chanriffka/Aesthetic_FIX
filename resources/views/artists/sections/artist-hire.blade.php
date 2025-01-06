<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Discussion - Artist Reply</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans text-gray-900">

<!-- Main Container -->
<div class="max-w-7xl mx-auto py-10 px-6 grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Left Section: Project Information -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Title -->
        <h1 class="text-3xl font-bold text-indigo-600 mb-6">🚀 Hire a Freelancer</h1>
        
        <!-- Project Title -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700">📌 Project Title</h2>
            <p class="text-gray-600 mt-2">Custom Portrait Illustration for Family Gift</p>
        </section>
        
        <!-- Project Description -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700">📝 Project Description</h2>
            <p class="text-gray-600 mt-2">
                <strong>Overview:</strong> We are looking to hire an artist to create a custom digital portrait of a family of four. The portrait should have a warm, inviting style, capturing the family members' likeness and unique personalities. We aim to use this illustration as a holiday gift, so it should have a festive touch.
            </p>
            <p class="text-gray-600 mt-2"><strong>Timeline:</strong> Completion needed within 3 weeks.</p>
        </section>
        
        <!-- Budget/Salary -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700">💰 Budget/Salary</h2>
            <p class="text-gray-600 mt-2"><strong>Compensation:</strong> Rp.300.000 - Rp.500.000</p>
            <p class="text-gray-600 mt-2"><strong>Payment Terms:</strong> 50% upfront, 50% upon final approval of the artwork</p>
        </section>
        
        <!-- Requirements -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700">📋 Requirements</h2>
            <p class="text-gray-600 mt-2"><strong>Skills Needed:</strong> Proficiency in digital illustration, portrait artistry, and experience in custom family portraits.</p>
            <p class="text-gray-600 mt-2"><strong>Experience Level:</strong> Intermediate</p>
            <p class="text-gray-600 mt-2"><strong>Other Requirements:</strong> Ability to add a festive theme to the illustration (e.g., holiday background, seasonal colors).</p>
        </section>
        
        <!-- Action Buttons -->
        <div class="flex space-x-4">
            <button onclick="editCommission()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </button>
            <button onclick="openDeleteConfirmation()" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-trash mr-2"></i>Delete
            </button>
        </div>
    </div>


    <!-- Right Section: Forum -->
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-4">💬 Discussion Forum</h2>

        <!-- Comment Threads -->
        <div class="space-y-6">
            <!-- Comment 1 -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <div class="flex space-x-4 items-start">
                    <img src="https://placehold.co/50" alt="User Avatar" class="w-10 h-10 rounded-full">
                    <div class="w-full">
                        <p class="text-gray-800 font-bold">John Doe <span class="text-gray-500 font-medium text-sm">• 2 hours ago</span></p>
                        <p class="text-gray-600 mt-2">Can you include a snowy winter background for the illustration?</p>

                        <!-- Reply Button -->
                        <button onclick="toggleReplyForm(1)" class="text-indigo-600 mt-2 hover:underline text-sm">
                            Reply
                        </button>

                        <!-- Reply Form (Hidden by Default) -->
                        <div id="replyForm1" class="hidden mt-4">
                            <textarea placeholder="Write your reply..." rows="2" 
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                            <div class="flex justify-end mt-2">
                                <button onclick="submitReply()" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Post Reply
                                </button>
                            </div>
                        </div>

                        <!-- Replies -->
                        <div class="mt-4 ml-6 bg-white p-3 border rounded-lg">
                            <div class="flex space-x-4 items-start">
                                <img src="https://placehold.co/50" alt="Artist Avatar" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="text-gray-800 font-bold">Artist <span class="text-gray-500 font-medium text-sm">• 1 hour ago</span></p>
                                    <p class="text-gray-600 mt-1">Yes, I can definitely add a snowy winter background!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comment 2 -->
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <div class="flex space-x-4 items-start">
                    <img src="https://placehold.co/50" alt="User Avatar" class="w-10 h-10 rounded-full">
                    <div class="w-full">
                        <p class="text-gray-800 font-bold">Jane Smith <span class="text-gray-500 font-medium text-sm">• 3 hours ago</span></p>
                        <p class="text-gray-600 mt-2">What file format will the final illustration be delivered in?</p>

                        <!-- Reply Button -->
                        <button onclick="toggleReplyForm(2)" class="text-indigo-600 mt-2 hover:underline text-sm">
                            Reply
                        </button>

                        <!-- Reply Form (Hidden by Default) -->
                        <div id="replyForm2" class="hidden mt-4">
                            <textarea placeholder="Write your reply..." rows="2" 
                                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                            <div class="flex justify-end mt-2">
                                <button onclick="submitReply()" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Post Reply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline Script -->
<script>
    // Toggle reply form visibility
    function toggleReplyForm(id) {
        const replyForm = document.getElementById(`replyForm${id}`);
        if (replyForm.classList.contains('hidden')) {
            replyForm.classList.remove('hidden');
        } else {
            replyForm.classList.add('hidden');
        }
    }

    // Simulate posting a reply
    function submitReply() {
        alert('Your reply has been posted!');
    }
</script>
</body>
</html>
