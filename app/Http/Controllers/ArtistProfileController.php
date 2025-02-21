<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Buyer;
use App\Models\Art;
use App\Models\MasterUser;
use App\Models\ArtCollection;
use App\Models\ArtistCollection;
use App\Models\ArtistHire;
use App\Models\HireQuestion;
use App\Models\HireQuestionReply;
use App\Models\ArtCategoryMaster;
use App\Models\Post;
use App\Models\ArtistRating;
use App\Models\ArtistSkill;
use App\Models\SkillMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArtistProfileController extends Controller
{
    public function showArtist($ARTIST_ID, $section = 'home')
    {
        $carts = null;

        if(Auth::user() != null) {
            $carts = Auth::user()->Carts;
        }

        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$ARTIST_ID)->first();

        if($artist == null) {
            return redirect()->route('landing')->withErrors(['message'=>'Artist not found']);
        }

        $artist->addView();

        $portfolios = Art::where('USER_ID',$artist->USER_ID)->where('IS_SALE',false)->get();
        if(Auth::user()->USER_LEVEL == 2 || Auth::user()->USER_LEVEL == 3){
            $artWorks = Art::where('USER_ID',$artist->USER_ID)->where('IS_SALE',true)->get();
        }
        else
        {
            $artWorks = Art::where('USER_ID',$artist->USER_ID)
                        ->where('IS_SALE',true)
                        ->where('IS_VERIF', true)
                        ->get();
        }
        
        $artCategoriesMaster = ArtCategoryMaster::all();
        $posts = Post::where('ARTIST_ID','=',$ARTIST_ID)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $latestPosts = Post::where('ARTIST_ID', $ARTIST_ID) 
                        ->orderBy('created_at', 'desc')
                        ->first();

        $hire = ArtistHire::where('ARTIST_ID','=',$ARTIST_ID)->first();

        $excludedSkillIds = ArtistSkill::where('ARTIST_ID', $artist->ARTIST_ID)
        ->pluck('SKILL_MASTER_ID');
        $skillsMaster = SkillMaster::whereNotIn('SKILL_MASTER_ID', $excludedSkillIds)
        ->get();

        if ($artist == null) {
            abort(404, 'Artist not found.');
        }
        else{
            if(Auth::user() != null) {
                $artistItSelf = $user->USER_ID == $artist->USER_ID;
            } else {
                $artistItSelf = false;
            }
            return view('artists.show', compact('artist','section','artistItSelf','portfolios','latestPosts','artWorks','artCategoriesMaster','posts', 'hire', 'skillsMaster', 'carts')); //ABOUT RENDER
        }
    }

    public function updateAboutMe(Request $request)
    {
        $user = Auth::user();
        $artist = Artist::where('USER_ID',$user->USER_ID)->first();

        if($request->ABOUT == NULL){
            $artist->ABOUT = "";
        }
        else{
            $artist->ABOUT = $request->ABOUT;
        }
        
        $artist->save();

        return redirect()->back();
    }
    
    public function showCollection($artistId, $ARTIST_COLLECTION_ID)
    {
        $collection = ArtistCollection::where('ARTIST_COLLECTION_ID',$ARTIST_COLLECTION_ID)->first();
        $artsCount = $collection->ArtistCollections->count();

        $artist = Artist::where('ARTIST_ID',$artistId)->first();
        $artsWithoutCollections = $artist->MasterUser->Arts()->doesntHave('ArtCollection')->get();

        return view('artists.sections.collection-detail', compact('collection', 'artsCount', 'artist','artsWithoutCollections'));
    }

    public function getArtistProfile($artistId){

        // Fetch the artist and related user data
        $artist = Artist::where('ARTIST_ID',$artistId)->first();

        // Check if artist exists
        if (!$artist) {
            return response()->json(['error' => 'Artist not found'], 404);
        }

        return response()->json($artist);
    }

    public function updateArtistProfile(Request $request, $id)
    {
        $artist = Artist::where('ARTIST_ID',$id)->first();

        if ($artist == null) {
            abort(404, 'Artist not found.');
        }

        $buyer = Buyer::where('USER_ID',$artist->USER_ID)->first();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'bio' => 'required',
            'location' => 'required',
            'role' => 'required',
            'phone' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $artist->BIO = $request->bio;
        $artist->ABOUT = $request->bio;
        $artist->LOCATION = $request->location;
        $artist->ROLE = $request->role;
        $artist->X = $request->X;
        $artist->PINTEREST = $request->PINTEREST;
        $artist->INSTAGRAM = $request->INSTAGRAM;
        $artist->LINKEDIN = $request->LINKEDIN;
        $artist->save();

        $buyer->FULLNAME = $request->name;

        $imagePath = $buyer->PROFILE_IMAGE_URL;

        if ($request->hasFile('picture')) {
            $uploadedFile = $request->file('picture');
            if($uploadedFile != null) {

                $imagePath = $uploadedFile->store('images/artist', 'public'); // Save file in the `storage/app/public/images/art` directory

                if($buyer->PROFILE_IMAGE_URL != null) {
                    $filePath = $buyer->PROFILE_IMAGE_URL; // Relative to the storage/app directory
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        // $buyer->PHONE_NUMBER = "+62" . $request->phone;
        $buyer->PHONE_NUMBER = "+62" . $request->phone;
        $buyer->PROFILE_IMAGE_URL = $imagePath;
        $buyer->save();

        return redirect()->back()->with('success','Profile has been updated successfully');
    }
        
    public function reviewArtist($id, Request $request)
    {
        $user = Auth::user();
        $artist = Artist::find($id);

        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if($artist == null) {
            return redirect()->back()->withErrors(['message'=>'Artist not found!']);
        }

        $review = $artist->ArtistRatings()->create([
            'USER_ID' => $user->USER_ID,
            'USER_RATING' => $request->rating,
            'CONTENT' => $request->content
        ]);

        return redirect()->back()->with('success','Review has been posted!');
    }

    public function destroyArtistReview($id)
    {
        $user = Auth::user();
        $review = ArtistRating::find($id);

        if($review->USER_ID != $user->USER_ID)
        {
            return redirect()->back()->withErrors(['message'=>'Not your review']);
        }

        $review->delete();

        return redirect()->back()->with('status','Review has been deleted!');
    }
    
    public function sendReport($id, Request $request)
    {
        $user = Auth::user();
        $artist = Artist::find($id);

        if($artist == null) {
            return redirect()->back()->withErrors(['message'=>'Artist not found!']);
        }

        $user->ArtistReports()->create([
            'ARTIST_ID' => $artist->ARTIST_ID,
            'CONTENT' => $request->CONTENT
        ]);
        
        return redirect()->back()->with('status','Report to '. $artist->MasterUser->Buyer->FULLNAME .' has been sent !');
    }

    public function hiring($id)
    {
        $hiring = ArtistHire::find($id);
        if($hiring == null) {
            return redirect()->back()->withErrors(['message'=>'Hiring found found']);
        }
        
        return view('artists.hire-view', compact('hiring'));
    }

    public function storeHireQuestion($id, Request $request)
    {
        $user = Auth::user();
        $hiring = ArtistHire::find($id);

        if($hiring == null) {
            return redirect()->back()->withErrors(['message'=>'Hiring not found!']);
        }

        $validator = Validator::make($request->all(), [
            'QUESTION' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->all());
        }

        $hiring->HireQuestions()->create([
            'QUESTION' => $request->QUESTION,
            'USER_ID' => $user->USER_ID,
        ]);

        return redirect()->back()->with('status','Comment has been posted');
    }

    public function destroyHireQuestion($id)
    {
        $user = Auth::user();
        $question = HireQuestion::find($id);

        if($question == null) {
            return redirect()->back()->withErrors(['message'=>'Comment not found!']);
        }

        if($user->USER_ID != $question->USER_ID) {
            return redirect()->back()->withErrors(['message'=>'Not allowed to delete other user comment!']);
        }

        $question->delete();

        return redirect()->back()->with('status','Question "'.$question->QUESTION.'" has been deleted');
    }

    public function storeHireQuestionReply($id, Request $request)
    {
        $user = Auth::user();
        $question = HireQuestion::find($id);

        if($question == null) {
            return redirect()->back()->withErrors(['message'=>'Hire comment not found!']);
        }

        $validator = Validator::make($request->all(), [
            'REPLY' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->all());
        }

        $question->HireQuestionReplies()->create([
            'REPLY' => $request->REPLY,
            'USER_ID' => $user->USER_ID,
        ]);

        return redirect()->back()->with('status','Reply has been posted');
    }

    public function destroyHireQuestionReply($id)
    {
        $user = Auth::user();
        $reply = HireQuestionReply::find($id);

        if($reply == null) {
            return redirect()->back()->withErrors(['message'=>'Reply not found!']);
        }

        if($user->USER_ID != $reply->USER_ID) {
            return redirect()->back()->withErrors(['message'=>'Not allowed to delete other user reply!']);
        }

        $reply->delete();

        return redirect()->back()->with('status','Reply "'.$reply->REPLY.'" has been deleted');
    }

    public function addSkill($id)
    {
        $user = Auth::user();
        $skill = SkillMaster::find($id);

        if($skill == null) {
            return redirect()->back()->withErrors(['message'=>'Skill master data not found!']);
        }

        $user->Artist->ArtistSkills()->create([
            'SKILL_MASTER_ID' => $skill->SKILL_MASTER_ID
        ]);

        return redirect()->back()->with('status', 'Success to add skill '.$skill->DESCR);
    }

    public function removeSkill($id)
    {
        $user = Auth::user();
        $skill = ArtistSkill::find($id);

        if($skill == null) {
            return redirect()->back()->withErrors(['message'=>'Artist skill data not found!']);
        }

        if($skill->ARTIST_ID != $user->Artist->ARTIST_ID) {
            return redirect()->back()->withErrors(['message'=>'Not allowed to delete other artist skill!']);
        }

        $skill->delete();

        return redirect()->back()->with('status', 'Success to delete skill '.$skill->SkillMaster->DESCR);
    }
}
