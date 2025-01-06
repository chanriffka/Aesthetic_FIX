<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hire Freelancer Forum</title>
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
            <p class="text-gray-600 mt-2">{{ $hiring->PROJECT_TITLE}}</p>
        </section>
        
        <!-- Project Description -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700">📝 Project Description</h2>
            <p class="text-gray-600 mt-2">
                <strong>Overview:</strong> {{ $hiring->PROJECT_DESCR }}
            </p>
            <p class="text-gray-600 mt-2"><strong>Timeline:</strong> {{ (new \DateTime($hiring->PROJECT_TIMELINE))->format('M d, Y') }}</p>
        </section>
        
        <!-- Budget/Salary -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700">💰 Budget/Salary</h2>
            <p class="text-gray-600 mt-2">{{ $hiring->PROJECT_BUDGET }}</p>
        </section>
        
        <!-- Requirements -->
        <section class="mb-6">
            <h2 class="text-xl font-semibold text-gray-700">📋 Requirements</h2>
            <p class="text-gray-600 mt-2"><strong>Skills Needed:</strong> {{ $hiring->PROJECT_SKILLS }}</p>
            <p class="text-gray-600 mt-2"><strong>Experience Level:</strong> {{ $hiring->PROJECT_EXPERIENCE_LEVEL }}</p>
            <p class="text-gray-600 mt-2"><strong>Other Requirements:</strong> {{ $hiring->OTHER_REQUIREMENTS }}</p>
        </section>

        @if(Auth::user() != null)
            @if($hiring->Artist->MasterUser->USER_ID == Auth::user()->USER_ID)
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
        @endif
    </div>

    <!-- Right Forum -->
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-4">💬 Discussion Forum</h2>

        @if(session('status'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <!-- Input Form for Comments -->
        @if(Auth::user() != null)
        @if($hiring->Artist->MasterUser->USER_ID != Auth::user()->USER_ID)
        <form action="{{ route('hiring.storeQuestion',['id'=>$hiring->ARTIST_HIRE_ID]) }}" method="post">
            @method('PUT')
            @csrf
            <div class="mb-10">
                <label for="QUESTION" class="block text-gray-700 font-medium mb-2">Ask a question or add a comment</label>
                <textarea id="QUESTION" name="QUESTION" rows="4" placeholder="Write your message..." 
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
                <!-- Post Button  -->
                <div class="mt-4">
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Post Comment
                    </button>
                </div>
            </div>
        </form>
        @endif
        @endif
    
    <!-- Comment Threads -->
    <div class="mt-12 space-y-6 max-h-96 overflow-y-auto border-t pt-6">
        <!-- Comment 1 -->
        @foreach($hiring->HireQuestions as $question)
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
            <div class="flex space-x-4 items-start">
                <img src="{{ $question->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($question->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="User Avatar" class="w-10 h-10 rounded-full">
                <div>
                    <p class="text-gray-800 font-bold">
                        {{ $question->MasterUser->Buyer->FULLNAME }}
                        <span class="text-gray-500 font-medium text-sm">• {{ (new \DateTime($question->created_at))->format('M d, Y') }}</span>
                        @if(Auth::user() != null)
                            @if(Auth::user()->USER_ID == $question->USER_ID)
                            <a href="{{ route('hiring.destroyQuestion',['id'=>$question->HIRE_QUESTION_ID]) }}" onclick="return confirm('Are you sure you want to delete comment {{$question->QUESTION}}?');"><i class="text-red-600 fas fa-trash"></i></a>
                            @endif
                        @endif
                    </p>
                    <p class="text-gray-600 mt-2">{{ $question->QUESTION }}</p>
    
                    <!-- Reply Button -->
                    <button onclick="toggleReplyForm({{ $question->HIRE_QUESTION_ID }})" class="text-indigo-600 mt-2 hover:underline text-sm">
                        Reply
                    </button>

                    <!-- Reply Form (Hidden by Default) -->
                    <div id="replyForm{{ $question->HIRE_QUESTION_ID }}" class="hidden mt-4">
                        <form id="replyForm" class="space-y-6" action="{{ route('hiring.storeReply', ['id' => $question->HIRE_QUESTION_ID]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <textarea placeholder="Write your reply..." rows="2" name="REPLY"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                            <div class="flex justify-end mt-2">
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Post Reply
                                </button>
                            </div>
                        </form>
                    </div>
    
                    <!-- Nested Reply -->
                    @if($question->HireQuestionReplies->count() > 0)
                    @foreach($question->HireQuestionReplies as $reply)
                    <div class="mt-4 ml-6 bg-white p-3 border rounded-lg">
                        
                        <div class="flex space-x-4 items-start">
                            
                            <img src="{{ $reply->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($reply->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="Artist Avatar" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="text-gray-800 font-bold">
                                    {{ $reply->MasterUser->Buyer->FULLNAME }}
                                    <span class="text-gray-500 font-medium text-sm">• {{ (new \DateTime($reply->created_at))->format('M d, Y') }}</span>
                                    @if(Auth::user() != null)
                                        @if(Auth::user()->USER_ID == $reply->USER_ID)
                                        <a href="{{ route('hiring.destroyReply',['id'=>$reply->HIRE_QUESTION_REPLY_ID]) }}" onclick="return confirm('Are you sure you want to delete reply {{$reply->REPLY}}?');"><i class="text-red-600 fas fa-trash"></i></a>
                                        @endif
                                    @endif
                                </p>
                                <p class="text-gray-600 mt-1">{{ $reply->REPLY }}</p>
                            </div>
                            
                        </div>
                        
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    </div>
    <div id="replyModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 overflow-y-auto max-h-[80vh] relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-3xl font-bold text-primary">Comment</h3>
                <button onclick="clodeReplyModal()"
                    class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                    &times;
                </button>
            </div>

            <form id="replyForm" class="space-y-6" action="" method="post">
                @csrf
                @method('PUT')
                <!-- Project Title -->
                <div class="flex items-center p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600" role="alert">
                    <div>
                      <span class="font-medium">Comment</span><br>
                      <span id="questionToReply"></span>
                    </div>
                </div>
                <div>
                    <label for="REPLY" class="block text-gray-700 font-medium">Reply</label>
                    <textarea id="REPLY" name="REPLY"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="2"
                            placeholder="Reply message" required></textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-8">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition">
                        Reply
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($hiring != null && Auth::user() != null)
        @if($hiring->Artist->MasterUser->USER_ID == Auth::user()->USER_ID)
        <div id="hireFreelancerUpdateFormModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full p-8 overflow-y-auto max-h-[80vh] relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-3xl font-bold text-primary">🚀 Update Hire a Freelancer</h3>
                    <button onclick="closeHireUpdateFormModal()"
                        class="text-gray-500 hover:text-gray-700 text-2xl absolute top-4 right-4">
                        &times;
                    </button>
                </div>

                <form class="space-y-6" action="{{ route('hire.update',['hireId' => $hiring->ARTIST_HIRE_ID]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <!-- Project Title -->
                    <div>
                        <label for="projectTitle" class="block text-gray-700 font-medium">📌 Project Title</label>
                        <input type="text" id="projectTitleUpdate" name="projectTitle"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="Enter the project title" value="{{ $hiring->PROJECT_TITLE }}" required>
                    </div>

                    <!-- Project Description -->
                    <div>
                        <label for="projectDescription" class="block text-gray-700 font-medium">📝 Project
                            Description</label>
                        <textarea id="projectDescriptionUpdate" name="projectDescription"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="4"
                            placeholder="Provide a brief description of the project" required>{{ $hiring->PROJECT_DESCR }}</textarea>
                        <p class="text-gray-500 text-sm mt-2">Include goals, any unique requirements, and the
                            estimated timeline or deadline for the project.</p>
                    </div>

                    <!-- Timeline -->
                    <div class="mt-6">
                        <label for="timeline" class="block text-gray-700 font-medium">⏳ Timeline</label>
                        <input type="date" id="timelineUpdate" name="timeline"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary mt-2"
                            placeholder="Specify estimated duration or deadline" value="{{ (new \DateTime($hiring->PROJECT_TIMELINE))->format('Y-m-d') }}" required>
                    </div>

                    <!-- Budget/Salary -->
                    <div>
                        <label for="budget" class="block text-gray-700 font-medium">💰 Budget/Salary</label>
                        <input type="text" id="budgetUpdate" name="budget"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="Enter the budget range (e.g., $500 - $1000)" value="{{ $hiring->PROJECT_BUDGET }}" required>
                        <p class="text-gray-500 text-sm mt-2">Specify payment terms: milestone-based, per hour, or
                            per project completion.</p>
                    </div>

                    <!-- Requirements -->
                    <div>
                        <label for="skills" class="block text-gray-700 font-medium">📋 Skills Needed</label>
                        <input type="text" id="skillsUpdate" name="skills"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            placeholder="List essential skills (e.g., graphic design, HTML, JavaScript)" value="{{ $hiring->PROJECT_SKILLS }}" required>
                    </div>
                    <div>
                        <label for="experienceLevel" class="block text-gray-700 font-medium">📈 Experience
                            Level</label>
                        <select id="experienceLevelUpdate" name="experienceLevel"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600"
                            required>
                            <option value="Beginner" @if($hiring->PROJECT_EXPERIENCE_LEVEL == "Beginer") selected @endif>Beginner</option>
                            <option value="Intermediate" @if($hiring->PROJECT_EXPERIENCE_LEVEL == "Intermediate") selected @endif>Intermediate</option>
                            <option value="Advanced" @if($hiring->PROJECT_EXPERIENCE_LEVEL == "Advanced") selected @endif>Advanced</option>
                        </select>
                    </div>
                    <div>
                        <label for="otherRequirements" class="block text-gray-700 font-medium">🔍 Other
                            Requirements</label>
                        <textarea id="REPLY" name="otherRequirements"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600" rows="2"
                            placeholder="Additional requirements, like language proficiency or certifications" required>{{ $hiring->OTHER_REQUIREMENTS }}</textarea>
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
                <a href="{{ route('hire.destroy',['hireId'=>$hiring->ARTIST_HIRE_ID ?? 0]) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">delete</a>
            </div>
        </div>
    </div>
        @endif
    @endif

    <script>

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

    var replyButtons = document.querySelectorAll('.reply-button');
    console.log(replyButtons)
    
    // Iterate over each button and attach an event listener
    replyButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.dataset.id;

            document.getElementById('replyForm').action = `{{ route('hiring.storeReply', ['id' => ':id']) }}`.replace(':id', id);
            // Log the message to the console
            document.getElementById('questionToReply').innerText = this.dataset.question;

            console.log('Button clicked with ID:', this.dataset.id);
            console.log('Question:', this.dataset.question);
            openReplyModal()
        });
    });

    function openReplyModal() {
        closeDeleteHireConfirmation()
        document.getElementById('replyModal').classList.remove('hidden');
    }

    function clodeReplyModal() {
        closeDeleteHireConfirmation()
        document.getElementById('replyModal').classList.add('hidden');
    }

    function openHireUpdateFormModal() {
        closeDeleteHireConfirmation()
        document.getElementById('hireFreelancerUpdateFormModal').classList.remove('hidden');
    }

    function closeHireUpdateFormModal() {
        document.getElementById('hireFreelancerUpdateFormModal').classList.add('hidden');
    }

    function openDeleteHireConfirmation() {
        closeHireUpdateFormModal()
        document.getElementById('deleteHireConfirmationModal').classList.remove('hidden');
    }

    function closeDeleteHireConfirmation() {
        document.getElementById('deleteHireConfirmationModal').classList.add('hidden');
    }
    </script>
</body>
</html>
