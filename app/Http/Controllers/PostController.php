<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function postDetails($id)
    {
        $post = Post::find($id);

        if($post == null) {
            abort(404,"Post not found!");
        }

        return view('artists.sections.post-detail',compact('post'));
    }

    public function addComment(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'commentContent' => 'required'
        ], [
            'commentContent.required' => '* The comment content is required.'
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $user = Auth::user();
        $post = Post::find($id);

        if($post == null) {
            abort(404,"Post not found!");
        }

        $post->PostComments()->create([
            'USER_ID' => $user->USER_ID,
            'CONTENT' => $request->commentContent
        ]);

        return redirect()->back()->with('status','Comment is has been posted!');
    }

    public function destroyComment($id)
    {
        $user = Auth::user();
        $comment = PostComment::find($id);

        if($comment->USER_ID != $user->USER_ID) {
            return redirect()->back()->withErrors(['message'=>'Comment is not own by u!']);
        }

        $comment->Delete();

        return redirect()->back()->with('status','Comment has been deleted!');
    }
}
