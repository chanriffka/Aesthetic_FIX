<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterUser;
use App\Models\Follower;

class FollowController extends Controller
{
    public function follow($userId)
    {
        $user = Auth::user();
        $userToFollow = MasterUser::find($userId);

        if($user->USER_ID == $userId) {
            return redirect()->back()->withErrors(['message'=>'You are not allowed to follow yourself']);
        }

        $user->Followings()->create([
            'FOLLOWED_USER_ID' => $userId
        ]);

        return redirect()->back()->with('status',$userToFollow->Buyer->FULLNAME.' followed!');
    }

    public function unfollow($userId)
    {
        $user = Auth::user();
        $follower = Follower::where('FOLLOWER_USER_ID',$user->USER_ID)->where('FOLLOWED_USER_ID',$userId)->first();

        if($follower == null) {
            return redirect()->back()->withErrors(['message'=>'No follower data']);
        }

        $follower->delete();

        return redirect()->back()->with('status',$follower->Followed->Buyer->FULLNAME.' unfollowed!');
    }
}
