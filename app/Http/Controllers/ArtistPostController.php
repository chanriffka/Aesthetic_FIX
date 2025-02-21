<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\PostMedia;
use App\Models\Artist;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistPostController extends Controller
{
    //POST COMMENT
    public function getPostComments($postId)
    {
        // Fetch comments associated with the specified post ID
        $comments = DB::table('post_comment as PC')
                    ->select([
                        'PC.CONTENT',
                        'MU.USERNAME',
                        'MU.PROFILE_IMAGE_PATH',
                        DB::raw("
                            CASE
                                WHEN DATEDIFF(DAY, PC.CREATED_AT, GETDATE()) <= 0 THEN 'Today'
                                WHEN DATEDIFF(YEAR, PC.CREATED_AT, GETDATE()) >= 1 THEN CAST(DATEDIFF(YEAR, PC.CREATED_AT, GETDATE()) AS VARCHAR) + ' Years Ago'
                                WHEN DATEDIFF(MONTH, PC.CREATED_AT, GETDATE()) >= 1 THEN CAST(DATEDIFF(MONTH, PC.CREATED_AT, GETDATE()) AS VARCHAR) + ' Months Ago'
                                ELSE CAST(DATEDIFF(DAY, PC.CREATED_AT, GETDATE()) AS VARCHAR) + ' Days Ago'
                            END AS COMMENT_TIME
                        ")
                    ])
                    ->join('master_user as MU', 'MU.USER_ID', '=', 'PC.USER_ID')
                    ->where('PC.POST_ID', $postId)
                    ->get();

        // Return comments as a JSON response
        return response()->json($comments);
    }

    public function addPostComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $postComment = new PostComment();
        $postComment->POST_ID = $postId;
        $postComment->USER_ID = Auth::id(); // Assuming the user is authenticated
        $postComment->CONTENT = $request->content;
        $postComment->created_at = now()->setTimezone('Asia/Jakarta');;
        $postComment->save();

        // Return a consistent structure for the comment
        return response()->json([
            'USERNAME' => Auth::user()->USERNAME, // Assuming USERNAME is the field for the user's name
            'COMMENT_TIME' => $postComment->created_at->diffForHumans(),
            'CONTENT' => $postComment->CONTENT,
            'PROFILE_IMAGE_PATH' => Auth::user()->PROFILE_IMAGE_PATH
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();

        $validated = Validator::make($request->all(), [
            'postContent' => 'required'
        ], [
            'postContent.required' => '* The post content is required.'
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $post = $artist->Posts()->create([
            'CONTENT' => $request->postContent
        ]);

        $imagePath = null;
        if ($request->filled('postImageLink')) {
            $imagePath = $request->input('postImageLink');
        }

        // If file is uploaded
        if ($request->hasFile('postImageUpload')) {
            $uploadedFile = $request->file('postImageUpload');
            $imagePath = $uploadedFile->store('images/post', 'public'); // Save file in the `storage/app/public/images/art` directory
        }
        
        if($imagePath !== null)
        {
            $post->PostMedias()->create([
                'POST_MEDIA_PATH' => $imagePath
            ]);
        }
        
        return redirect()->back()->with('status','New post has been created!');
    }
 
    public function deletePost($postId)
    {
        $user = Auth::guard('MasterUser')->user();
        $post = Post::find($postId);

        if($post == null) {
            return redirect()->back()->with('error','Post not found!');
        }

        if($post->PostMedias->count() > 0) {
            foreach($post->PostMedias as $media) {
                if ($media->POST_MEDIA_PATH != null) {
                    if(Str::startsWith($media->POST_MEDIA_PATH, 'images/post/')) {
                        $filePath = $media->POST_MEDIA_PATH;
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
        }

        if($post->PostLikes->count() > 0 ){
            foreach($post->PostLikes as $like) {
                $like->delete();
            }
        }

        if($post->PostComments->count() > 0 ){  
            foreach($post->PostComments as $comment) {
                $comment->delete();
            }
        }
        
        $post->delete();
        return redirect()->back()->with('status','Post has been deleted!');
    }

    public function togglePostLike($postId, Request $request)
    {
        $user = Auth::user();
        $post = Post::find($postId);

        $like = PostLike::where('POST_ID',$post->POST_ID)->where('USER_ID',$user->USER_ID)->first();

        if ($like != null) {
            $like->delete();
        } else {
            $post->PostLikes()->create([
                'USER_ID' => $user->USER_ID
            ]);
        }

        return redirect()->back()->with('status','Post being liked!');
    }

    public function getArtistPostData($postId){
        // Fetch the artist and related user data
        $post = DB::table('POST')
            ->join('POST_MEDIA', 'POST.POST_ID', '=', 'POST_MEDIA.POST_ID')
            ->where('POST.POST_ID', $postId)
            ->select('POST.*', 'POST_MEDIA.POST_MEDIA_PATH') // Select fields as needed
            ->first();

        // Check if artist exists
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    public function update(Request $request, $postId){
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();
        $post = Post::find($postId);


        if ($post == null) {
            abort(404, 'Post not found.');
        }

        $validated = Validator::make($request->all(), [
            'postContentEdit' => 'required'
        ], [
            'postContentEdit.required' => '* The post content is required.'
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $post->CONTENT = $request->postContentEdit;

        $imagePath = null;

        // If URL is provided
        if ($request->filled('postImageLinkEdit')) {
            $imagePath = $request->input('postImageLinkEdit');
            $this->deleteImage($post->POST_ID);
        }

        // If file is uploaded
        if ($request->hasFile('postImageUploadEdit')) {
            $uploadedFile = $request->file('postImageUploadEdit');
            $imagePath = $uploadedFile->store('images/post', 'public'); // Save file in the `storage/app/public/images/art` directory
            $this->deleteImage($post->POST_ID);
        }

        if($imagePath != null) {
            $post->PostMedias()->create([
                'POST_MEDIA_PATH' => $imagePath
            ]);
        }

        $post->save();
        return redirect()->back()->with('status','Post has been updated!');
    }

    public function deleteImage($postId)
    {
        $postMedia = PostMedia::where('POST_ID',$postId)->get();
        foreach($postMedia as $media) {
            if ($media->POST_MEDIA_PATH != null) {
                if(Str::startsWith($media->IMAGE_PATH, 'images/post/')) {
                    $filePath = $media->IMAGE_PATH;
                    Storage::disk('public')->delete($filePath);
                }
            }
            $media->delete();
        }
    }
}
