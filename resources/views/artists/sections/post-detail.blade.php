<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <title>Post Comments</title>
</head>
<body class="bg-gray-100">
  <div class="max-w-screen-lg mx-auto">
<!-- Back Button with Arrow Icon -->
<a href="{{ route('artist.show', ['id' => $post->Artist->ARTIST_ID, 'section' => 'posts']) }}"
   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-300 transition duration-300 shadow-sm mt-4">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 19l-7-7 7-7" />
    </svg>
    <span class="text-sm font-medium text-white">Back</span>
</a>
    <!-- Post Section -->
    <div class="mt-8">
      <!-- Post Example -->
      <div class="bg-white p-4 rounded-lg shadow-md mb-4 border border-gray-300 relative cursor-pointer">
        <div class="flex items-center space-x-4">
          <img alt="Profile picture of the user" class="w-10 h-10 rounded-full" src="{{ $post->Artist->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($post->Artist->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}">
          <div>
            <h2 class="text-lg font-bold">{{ $post->Artist->MasterUser->Buyer->FULLNAME }}</h2>
            <p class="text-sm text-gray-600">{{ (new \DateTime($post->created_at))->format('M d, Y') }}</p>
          </div>
        </div>
        <p class="mt-4 text-sm">{{ $post->CONTENT }}</p>

        <!-- Image Container -->
        @if($post->PostMedias->count() > 0)
        <div class="aspect-w-2 aspect-h-1 mt-4 rounded-lg overflow-hidden">
          <img alt="Post Content" class="aspect-inner w-full h-auto" src="{{ Str::startsWith($post->PostMedias()->first()->POST_MEDIA_PATH, 'images/post/') ? asset($post->PostMedias()->first()->POST_MEDIA_PATH) : $post->PostMedias()->first()->POST_MEDIA_PATH }}">
        </div>
        @endif

        <div class="mt-2 flex space-x-4 text-gray-600 text-xl">
          @if(Auth::user() != null)
          <a href="{{ route('post.likeToggle', ['postId'=>$post->POST_ID]) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="@if($post->isLiked()) currentColor @else none @endif" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-pink-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
          </a>
          <span style="margin-left: 5px">{{ $post->PostLikes->count() }}</span>
          @else
          <button class="flex items-center space-x-1"><i class="far fa-heart"></i><span>{{ $post->PostLikes->count() }}</span></button>
          @endif
          <button class="flex items-center space-x-1"><i class="far fa-comment"></i><span>{{ $post->PostComments->count() }}</span></button>
          <button id="sharePostButton" onclick="openSharePostModal()" class="flex items-center space-x-1"><i class="far fa-share-square"></i><span>Share</span></button>
        </div>
      </div>
    </div>

    {{-- Share Post Modal --}}
    <div id="sharePostModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden modal-overlay">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-xl">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Share Post</h2>
          <div class="py-2">
              <label for="sharePostLink" class="block text-gray-700 font-semibold mb-2">Post Link</label>
              <input type="text" id="sharePostLink" name="sharePostLink" value={{ url()->current() }} class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition" placeholder="Enter collection title" readonly>
          </div>
          <div class="flex justify-end space-x-3">
              <button type="button" id="closeSharePostButtonModal" onclick="closeSharePostModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">Close</button>
              <button type="button" id="copyPostLinkButton" onclick="copyPostLink()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 shadow-md transition duration-300 transform hover:scale-105">Copy Link</button>
          </div>
      </form>
      </div>
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded-lg shadow-md p-4 mt-6">
      <h3 class="text-xl font-bold mb-4">Comments</h3>
      <div id="commentsSection" class="space-y-4 h-48 overflow-y-auto pr-2">
        <!-- Dynamic Comments -->
        @foreach($post->PostComments()->orderBy('created_at','DESC')->get() as $comment)
        <div class="flex space-x-4">
          <img class="w-10 h-10 rounded-full" src="{{ $comment->MasterUser->Buyer->PROFILE_IMAGE_URL != null ? asset($comment->MasterUser->Buyer->PROFILE_IMAGE_URL) : "https://placehold.co/100x100"}}" alt="User Profile">
          <div>
            <p class="font-bold">
              {{ $comment->MasterUser->Buyer->FULLNAME }} <span class="text-sm text-gray-600">{{ (new \DateTime($comment->created_at))->format('M d, Y') }}</span>
              @if(Auth::user() != null)
              @if(Auth::user()->USER_ID == $comment->MasterUser->USER_ID) <a href="{{ route('post.comment.delete',['id'=>$comment->POST_COMMENT_ID]) }}" class="text-red-700"><i class="fas fa-trash"></i></a> @endif
              @endif
            </p>
            <p class="text-gray-700 mt-1">{{ $comment->CONTENT }}</p>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Add Comment Section -->
      @if(Auth::user() != null)
      <form action="{{ route('post.comment',['id'=>$post->POST_ID]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mt-4">
          <label for="commentContent" class="block text-gray-700 font-semibold mb-2">Add a Comment</label>
          <textarea id="commentContent" name="commentContent" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" placeholder="Write your comment..."></textarea>
          <button type="submit" class="mt-2 bg-indigo-500 text-white px-4 py-2 rounded-lg hover:bg-indigo-600 transition">Post Comment</button>
        </div>
      </form>
      @else
      <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
        Log in to send some comment and like
      </div>
      @endif
    </div>
  </div>

  <script>
    function openSharePostModal(){
      document.getElementById('sharePostModal').classList.remove('hidden');
    }

    function closeSharePostModal(){
      document.getElementById('sharePostModal').classList.add('hidden');
    }

    // const commentsData = [
    //   { name: "Anya", date: "1 month ago", text: "The fantasy illustrations are pure magic!" },
    //   { name: "Sam Jetstream", date: "3 months ago", text: "The neon-drenched streets are amazing!" }
    //   { name: "Aglio", date: "1 minutes ago", text: "The neon-drenched streets are amazing!" }
    // ];

    function addComment() {
      const commentText = document.getElementById('newComment').value.trim();
      if (commentText) {
        const newComment = {
          name: "You",
          date: "Just now",
          text: commentText,
        };
        commentsData.push(newComment);
        document.getElementById('newComment').value = '';
        renderComments();
      }
    }

    function renderComments() {
      const commentsSection = document.getElementById('commentsSection');
      commentsSection.innerHTML = '';
      commentsData.forEach(comment => {
        const commentElement = document.createElement('div');
        commentElement.classList.add('flex', 'space-x-4');
        commentElement.innerHTML = `
          <img class="w-10 h-10 rounded-full" src="https://via.placeholder.com/150" alt="${comment.name}">
          <div>
            <p class="font-bold">${comment.name} <span class="text-sm text-gray-600">${comment.date}</span></p>
            <p class="text-gray-700 mt-1">${comment.text}</p>
          </div>
        `;
        commentsSection.appendChild(commentElement);
      });
    }

    function copyPostLink() {
    // Get the text field
        var copyText = document.getElementById("sharePostLink");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        try {
            // Fallback method for older browsers
            document.execCommand("copy");
            alert("Link Copied: " + copyText.value);
        } catch (err) { 
            console.error("Failed to copy: ", err);
        }
    }

    // Initial render
    // renderComments();
  </script>
</body>
</html>
