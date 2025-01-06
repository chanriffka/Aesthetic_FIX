<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .post-card {
      max-width: 600px;
      position: relative;
    }
    .ellipsisButton {
      position: absolute;
      top: 8px;
      right: 8px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 50%;
      padding: 6px;
      z-index: 10;
    }
    .optionsMenu {
      position: absolute;
      top: 40px;
      right: 16px;
      background-color: white;
      border: 1px solid #e5e7eb;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      padding: 8px;
      width: 120px;
      display: none;
      z-index: 20;
    }
    .modal-overlay {
      z-index: 50;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="max-w-screen-lg mx-auto">
    <!-- Add Post Button -->
    <div class="flex justify-between items-center mt-8">
      <h2 class="text-2xl font-bold">Posts</h2>
      @if(Auth::check())
        @if (Auth::user()->USER_ID == $artist->USER_ID )
          <button id="addPostButton" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-5 py-2 rounded-full shadow-md hover:from-blue-600 hover:to-indigo-700 transition duration-300 transform hover:scale-105">
            + Add Post 
          </button>
        @endif
      @endif
    </div>

 <!-- Post Section -->
 <div class="mt-8">
  @foreach ($posts as $post )
  <!-- Post Example -->
  <a href="{{ route('post.detail',['id'=>$post->POST_ID]) }}">
    <div class="bg-white p-4 rounded-lg shadow-md mb-4 border border-gray-300 post-card relative cursor-pointer" id="artistPost" data-post-id="{{ $post->POST_ID }}" data-delete-route="{{ route('post.destroy', $post->POST_ID) }}" onclick="showPostDetail({{ $post->POST_ID }})">
      <!-- Options Menu and Profile Section Omitted for Brevity -->
      {{-- <button class="ellipsisButton text-gray-600 hover:text-gray-800 focus:outline-none" onclick="toggleOptionsMenu(event, this)">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 0 1.5ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg>
      </button>
      <!-- Options Menu -->
      <div class="optionsMenu">
        <button class="block w-full text-left px-4 py-2 hover:bg-gray-100">Edit Post</button>
        <button class="block w-full text-left px-4 py-2 hover:bg-gray-100" onclick="confirmDeletePost(event,{{ $post->POST_ID }})" data-post-id="{{ $post->POST_ID }}">Delete Post</button>
      </div> --}}
  
      <div class="flex items-center space-x-4">
        <img alt="Profile picture of the user" class="w-10 h-10 rounded-full" src="{{ $post->Artist->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($post->Artist->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}">
        <div>
          <h2 class="text-lg font-bold">{{ $post->Artist->MasterUser->Buyer->FULLNAME }}</h2>
          <p class="text-sm text-gray-600">{{ $post->created_at }}</p>
        </div>
      </div>
      <p class="mt-4 text-sm">{{ $post->CONTENT }}</p>
  
      <!-- Image Container -->
      @if($post->PostMedias->count() > 0)
      <div class="aspect-w-2 aspect-h-1 mt-4 rounded-lg overflow-hidden">
        <img alt="Anime character with pink hair" class="aspect-inner object-cover" src="{{ Str::startsWith($post->PostMedias()->first()->POST_MEDIA_PATH, 'images/post/') ? asset($post->PostMedias()->first()->POST_MEDIA_PATH) : $post->PostMedias()->first()->POST_MEDIA_PATH }}">
      </div>
      @endif
  
      <div class="mt-2 flex space-x-4 text-gray-600 text-sm">
        <button class="flex items-center space-x-1"><i class="fas fa-heart text-red-500"></i><span>{{ $post->PostLikes->count() }}</span></button>
        <button class="flex items-center space-x-1"><i class="far fa-comment"></i><span id="postTotalComments-9999">{{ $post->PostComments->count() }}</span></button>
      </div>
    </div>
  </a>
  @endforeach
</div>
</div>
  
  <!-- Post Detail Modal -->
  <div id="postDetailModal" data-post_id="" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
    <div class="bg-white p-8 rounded-lg shadow-lg w-10/12 max-w-4xl flex space-x-8 relative">
        <button class="absolute top-4 right-4 text-gray-600 hover:text-gray-800" onclick="closePostDetail()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
  
        <!-- Left Side: Image and Interactions -->
        <div class="flex-shrink-0 w-1/2">
            <img id="postDetailImage" class="w-full h-auto rounded-lg shadow-lg" src="" alt="Post Image">
            <div class="flex space-x-4 mt-4 text-gray-600">
                <button class="flex items-center space-x-2 hover:text-gray-800 like-button" data-route=""><i class="fas fa-heart text-red-500"></i><span id="postDetailLikes"></span></button>
                <button class="flex items-center space-x-2 hover:text-gray-800"><i class="far fa-comment"></i><span id="postDetailComments"></span></button>
                <button class="flex items-center space-x-2 hover:text-gray-800"><i class="far fa-share-square"></i><span>Share</span></button>
            </div>
        </div>
  
        <!-- Right Side: Details and Comments -->
        <div class="w-1/2">
            <!-- User Info -->
            <div class="flex items-center space-x-4 mb-4">
                <img id="postDetailProfileImage" class="w-12 h-12 rounded-full" src="" alt="Profile picture">
                <div>
                    <h3 id="postDetailUser" class="text-2xl font-bold"></h3>
                    <p id="postDetailDate" class="text-gray-600"></p>
                </div>
            </div>
  
            <!-- Caption -->
            <p id="postDetailContent" class="text-gray-700 mt-2"></p>
  
            <!-- Comments Section -->
            <div class="mt-8">
                <h4 class="text-lg font-semibold mb-2">Comments</h4>
                <div id="commentsSection" class="space-y-4 h-40 overflow-y-auto pr-2 border-t border-gray-200 pt-4">
                    <!-- Comments will be dynamically inserted here -->
                </div>
                <!-- Add Comment Form -->
                <div class="mt-4">
                    <label for="newComment" class="block text-gray-700 font-semibold mb-2">Add a Comment</label>
                    <textarea id="newComment" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" placeholder="Write your comment..."></textarea>
                    <button onclick="addComment()" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Post Comment</button>
                </div>
            </div>
        </div>
    </div>
  </div>


<!-- Add Post Modal -->
<div id="addPostModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
      <h3 class="text-2xl font-semibold text-gray-800 mb-2">Add New Post ✉️ </h3>
      <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" id="addPostForm" class="space-y-6">
        @csrf
        <div>
          <label for="postContent" class="block text-gray-700 font-semibold mb-2">Post Content</label>
          <textarea id="postContent" name="postContent"class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" placeholder="Write something..." required></textarea>
          <span id="postContentError" class="text-red-600"></span>
        </div>
        <!-- Image Upload Options -->
        <div>
          <label class="block text-lg font-semibold text-gray-700 mb-2">Select Image Upload Option</label>
          <div class="flex items-center mb-4">
              <input type="radio" id="linkOption" name="imageOption" value="link" class="mr-3" onclick="toggleImageUploadOption('link')" checked>
              <label for="linkOption" class="text-gray-700">Upload by Link</label>
          </div>
          <div class="flex items-center mb-4">
              <input type="radio" id="fileOption" name="imageOption" value="file" class="mr-3" onclick="toggleImageUploadOption('file')">
              <label for="fileOption" class="text-gray-700">Upload from File</label>
          </div>
        </div>

        <!-- Image Upload Fields -->
        <div id="linkField" class="mb-4">
            <label for="postImageLink" class="block text-lg font-semibold text-gray-700">Image URL</label>
            <input type="text" id="postImageLink" name="postImageLink" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            <span id="postImageLinkError" class="text-red-600"></span>
        </div>
        <div id="fileField" class="mb-4 hidden">
            <label for="postImageUpload" class="block text-lg font-semibold text-gray-700">Upload Image</label>
            <input type="file" id="postImageUpload" name="postImageUpload" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            <span id="postImageUploadError" class="text-red-600"></span>
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" id="cancelAddPostButton" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200" onclick="closeAddPostModal()">Cancel</button>
          <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition duration-300 transform hover:scale-105">Add Post</button>
        </div>
      </form>
    </div>
  </div>
  <!-- Delete Confirmation Modal -->
  <div id="deleteConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Delete Post</h2>
      <p class="text-gray-600 mb-6">Are you sure you want to delete this post?</p>
      <div class="flex justify-end space-x-3">
        <button type="button" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition" onclick="closeDeleteModal()">Cancel</button>
        <a href="" id="deleteButtonModal" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">Delete</a>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // const commentsData = {
    //   { name: "Anya", date: "1 month ago", text: "The fantasy illustrations are pure magic!" },
    //   { name: "Sam Jetstream", date: "3 months ago", text: "The neon-drenched streets are amazing!" }
    // };

    // const postsData = {
    //       @foreach ($posts as $post)
    //           "{{ $post->POST_ID }}": {
    //               user: "{{ $post->USERNAME }}",
    //               date: "{{ $post->CREATED_DATE }}",
    //               content: "{{ $post->CONTENT }}",
    //               likes: {{ $post->TOTAL_LIKE }},
    //               comments: {{ $post->TOTAL_COMMENT }},
    //               imageUrl: "{{ asset($post->POST_MEDIA_PATH) }}",
    //               profileImageUrl: "{{ asset($post->PROFILE_IMAGE_PATH) }}"
    //           },
    //       @endforeach
    //   };

  const cachedComments = {}; // Cache for comments by postId

  function decodeHtmlEntities(text) {
      const textarea = document.createElement("textarea");
      textarea.innerHTML = text;
      return textarea.value;
  }

  // function showPostDetail(postId) {
  //     const post = postsData[postId];
  //     if (post) {
  //         document.getElementById('postDetailUser').textContent = post.user;
  //         document.getElementById('postDetailDate').textContent = post.date;
  //         document.getElementById('postDetailContent').textContent = decodeHtmlEntities(post.content);
  //         document.getElementById('postDetailLikes').textContent = post.likes;
  //         document.getElementById('postDetailComments').textContent = post.comments;
  //         document.getElementById('postDetailImage').src = post.imageUrl;
  //         document.getElementById('postDetailProfileImage').src = post.profileImageUrl;

  //         // Check if comments are cached
  //         if (cachedComments[postId]) {
  //             populateComments(cachedComments[postId]);
  //         } else {
  //             // Fetch comments for this post and cache them
  //             fetch(`/comments/${postId}`)
  //                 .then(response => response.json())
  //                 .then(comments => {
  //                     cachedComments[postId] = comments; // Cache the comments for this postId
  //                     populateComments(comments);
  //                 })
  //                 .catch(error => console.error('Error fetching comments:', error));
  //         }

  //         document.getElementById('commentsSection').setAttribute('data-post-id', postId);
  //         document.getElementById('postDetailModal').classList.remove('hidden');
  //     } else {
  //         console.error('Post data not found for POST_ID:', postId);
  //     }
  // }

  // function populateComments(comments) {
  //   const commentsSection = document.getElementById('commentsSection');
  //   commentsSection.innerHTML = ''; // Clear existing comments

  //   comments.forEach(comment => {
  //       const name = comment.USERNAME || 'Anonymous';
  //       const date = comment.COMMENT_TIME || 'Unknown date';
  //       const text = comment.CONTENT || 'No content available';
  //       const imagePath = comment.PROFILE_IMAGE_PATH || '/path/to/default_profile.png';

  //       const commentElement = document.createElement('div');
  //       commentElement.classList.add('flex', 'space-x-4', 'items-start');
  //       commentElement.innerHTML = `
  //           <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('${imagePath}') }}" alt="${name}">
  //           <div>
  //               <p class="font-bold">${name} <span class="text-sm text-gray-600">${date}</span></p>
  //               <p class="text-gray-700 mt-1">${text}</p>
  //           </div>
  //       `;
  //       commentsSection.appendChild(commentElement);
  //   });
  // }

// function addComment() {
//     const newCommentText = document.getElementById('newComment').value;
//     const postId = document.getElementById('commentsSection').getAttribute('data-post-id');
    
//     if (newCommentText && postId) {
//         fetch(`/comments/${postId}`, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({ content: newCommentText })
//         })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return response.json();
//         })
//         .then(newComment => {
//             console.log("New Comment Data:", newComment); // Check structure in console

//             document.getElementById('newComment').value = '';

//             const commentsSection = document.getElementById('commentsSection');
//             const commentElement = document.createElement('div');
//             commentElement.classList.add('flex', 'space-x-4', 'items-start');
//             commentElement.innerHTML = `
//                 <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('${newComment.PROFILE_IMAGE_PATH}') }}" alt="${newComment.USERNAME}">
//                 <div>
//                     <p class="font-bold">${newComment.USERNAME} <span class="text-sm text-gray-600">${newComment.COMMENT_TIME}</span></p>
//                     <p class="text-gray-700 mt-1">${newComment.CONTENT}</p>
//                 </div>
//             `;
//             commentsSection.appendChild(commentElement);

//             // Cache the new comment
//             if (!cachedComments[postId]) {
//                 cachedComments[postId] = [];
//             }
//             cachedComments[postId].push({
//                 USERNAME: newComment.USERNAME,
//                 COMMENT_TIME: newComment.COMMENT_TIME,
//                 CONTENT: newComment.CONTENT,
//                 PROFILE_IMAGE_PATH: newComment.PROFILE_IMAGE_PATH
//             });

//             // Update the comment count in the post data and on the modal
//             postsData[postId].comments += 1;
//             document.getElementById('postDetailComments').textContent = postsData[postId].comments;

//             const postCommentCount = document.getElementById(`postTotalComments-${postId}`);
//             if (postCommentCount) {
//                 postCommentCount.textContent = postsData[postId].comments;
//             }
//         })
//         .catch(error => console.error('Error adding comment:', error));
//     }
// }

    function toggleImageUploadOption(option) {
        document.getElementById('linkField').classList.toggle('hidden', option !== 'link');
        document.getElementById('fileField').classList.toggle('hidden', option !== 'file');
    }

    // function addComment() {
    //   const newCommentText = document.getElementById('newComment').value;
    //   if (newCommentText) {
    //     commentsData.push({ name: "Current User", date: "Just now", text: newCommentText });
    //     document.getElementById('newComment').value = '';
    //     populateComments();
    //   }
    // }

    // function closePostDetail() {
    //   document.getElementById('postDetailModal').classList.add('hidden');
    // }

    // Toggle options menu visibility for each ellipsis button
    // function toggleOptionsMenu(event, button) {
    //   event.stopPropagation();
    //   document.querySelectorAll('.optionsMenu').forEach(menu => {
    //     if (menu !== button.nextElementSibling) {
    //       menu.style.display = 'none';
    //     }
    //   });
    //   const optionsMenu = button.nextElementSibling;
    //   optionsMenu.style.display = optionsMenu.style.display === 'block' ? 'none' : 'block';
    // }

    // let postToDelete = null; // Holds the ID of the post to delete

    // // Function to open the delete confirmation modal
    // function confirmDeletePost(event, postId) {
    //     event.stopPropagation(); // Prevent triggering other events (e.g., opening the post)
    //     postToDelete = postId; // Set the ID of the post to delete

    //     console.log(event.target.getAttribute('data-post-id'));

    //     let deletePostRoute = "{{ route('post.destroy', ['postId' => 'POST_ID']) }}";
    //     document.getElementById('deleteButtonModal').href = deletePostRoute.replace('POST_ID', event.target.getAttribute('data-post-id'))

    //     document.getElementById('deleteConfirmationModal').classList.remove('hidden'); // Show modal
    // }

    // Function to close the delete confirmation modal
    // function closeDeleteModal() {
    //     document.getElementById('deleteConfirmationModal').classList.add('hidden'); // Hide modal
    //     postToDelete = null; // Clear the stored post ID
    // }

    // Function to delete the post via AJAX
    // function deletePost() {
    //     if (!postToDelete) return; // Ensure there's a post to delete

    //     // Get the delete route from the data attribute
    //     const postElement = document.querySelector(`#artistPost[data-post-id="${postToDelete}"]`);
    //     const url = postElement.dataset.deleteRoute; // Get the route from the data attribute

    //     console.log('Delete URL:', url); // Log the URL to verify it's correct

    //     // Send AJAX request
    //     fetch(url, {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //             'Content-Type': 'application/json',
    //         },
    //     })
    //     .then(response => {
    //         if (!response.ok) {
    //             throw new Error('Failed to delete the post.');
    //         }
    //         return response.json();
    //     })
    //     .then(data => {
    //         if (data.success) {
    //             postElement.remove(); // Remove the post from the DOM
    //             closeDeleteModal(); // Close the modal
    //             alert('Post deleted successfully.');
    //         } else {
    //             alert('Failed to delete the post.');
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Error deleting post:', error);
    //         alert('An error occurred while deleting the post.');
    //     });
    // }

    // Hide options menu when clicking outside
    // document.addEventListener('click', () => {
    //   document.querySelectorAll('.optionsMenu').forEach(menu => menu.style.display = 'none');
    // });

    // Show and hide the Add Post modal
    document.getElementById('addPostButton').addEventListener('click', () => {
      document.getElementById('addPostModal').classList.remove('hidden');
    });

    function closeAddPostModal() {
      document.getElementById('addPostModal').classList.add('hidden');
      clearErrorsAndForm();
    }

    function clearErrorsAndForm() {
        // Clear error messages
        document.getElementById('postContentError').textContent = '';
        document.getElementById('postImageLinkError').textContent = '';
        document.getElementById('postImageUploadError').textContent = '';

        // Reset the form
        document.getElementById('addPostForm').reset();
    }

    // function submitPost(event) {
    //     event.preventDefault(); // Prevent traditional form submission

    //     // Clear previous error messages
    //     document.getElementById('postContentError').textContent = '';
    //     document.getElementById('postImageLinkError').textContent = '';
    //     document.getElementById('postImageUploadError').textContent = '';

    //     // Get the form and form data
    //     const form = document.getElementById('addPostForm');
    //     const formData = new FormData(form);

    //     // Get the selected image option
    //     const imageOption = formData.get('imageOption'); // "file" or "link"

    //     // Send AJAX request
    //     fetch('{{ route('post.store') }}', {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //         },
    //         body: formData,
    //     })
    //         .then(response => {
    //             if (!response.ok) {
    //                 return response.json().then(err => {
    //                     throw err; // Throw JSON error
    //                 });
    //             }
    //             return response.json();
    //         })
    //         .then(data => {
    //             // Success handling
    //             if (data.success) {
    //                 location.reload(); // Reload the page to reflect changes
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             if (error.errors) {
    //                 // Display validation errors dynamically
    //                 if (error.errors.postContent) {
    //                     document.getElementById('postContentError').textContent = error.errors.postContent[0];
    //                 }
    //                 if (error.errors.postImageUpload && imageOption === 'file') {
    //                     document.getElementById('postImageUploadError').textContent = error.errors.postImageUpload[0];
    //                 }
    //                 if (error.errors.postImageLink && imageOption === 'link') {
    //                     document.getElementById('postImageLinkError').textContent = error.errors.postImageLink[0];
    //                 }
    //             } else {
    //                 alert('An unexpected error occurred. Please try again later.');
    //             }
    //         });
    // }

    // Like Toggle Script
    // POST LIKE TOGGLE (Modal Only)
    document.getElementById('postDetailModal').addEventListener('click', function (event) {
        const likeButton = event.target.closest('.like-button'); // Check if the clicked element is or is inside a like-button
        if (!likeButton) return; // Exit if the click is not on a like-button

        const url = likeButton.getAttribute('data-route'); // Backend route for like toggle
        const postId = this.getAttribute('data-post-id'); // Get the post ID from the modal's data attribute

        // Debugging to ensure the right post ID is being used
        console.log(`Toggling like for post ID: ${postId}`);

        // Ensure postId and url exist before proceeding
        if (!postId || !url) {
            console.error('Missing post ID or like toggle route.');
            return;
        }

        const likeIcon = likeButton.querySelector('i'); // The heart icon in the modal
        const likeCount = likeButton.querySelector('span'); // The like count span in the modal

        // Ensure the necessary elements exist
        if (!likeIcon || !likeCount) {
            console.error('Like icon or count span not found.');
            return;
        }

        // Send the AJAX request to the backend
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the like state in the modal
                    likeIcon.classList.toggle('text-red-500', data.isLiked); // Add/remove red heart
                    likeIcon.classList.toggle('text-gray-400', !data.isLiked); // Add/remove gray heart
                    likeCount.textContent = data.total_likes; // Update the like count
                } else {
                    console.error('Backend Error:', data.message || 'Unexpected response from server.');
                    alert('Failed to toggle like.');
                }
            })
            .catch(error => {
                console.error('Network Error:', error);
                alert('An error occurred while toggling like. Please try again.');
            });
    });

  </script>
</body>
</html>

     
