<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Art;
use App\Models\MasterUser;
use App\Models\Artist;
use App\Models\Buyer;
use App\Models\ArtCategory;
use App\Models\ArtCategoryMaster;
use App\Models\SkillMaster;
use App\Models\ArtistReport;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActiveArtist;
use App\Mail\DeactiveArtist;
use App\Mail\ActiveBuyer;
use App\Mail\DeactiveBuyer;
use App\Mail\JoinArtistApprove;
use App\Mail\JoinArtistRejected;


class AdminController extends Controller
{
    public function index()
    {
        $totalBuyer = MasterUser::where('USER_LEVEL','!=','3')->count();
        $totalArtist = MasterUser::has('ARTIST')->count();
        $totalCategory = ArtCategory::count();
        $totalArtwork = Art::where('IS_SALE',true)->count();
        $totalSkill = SkillMaster::count();
        return view('admin.dashboard', [
            'totalBuyers' => $totalBuyer, 
            'totalArtists' => $totalArtist, 
            'totalCategories' => $totalCategory, 
            'totalSkills' => $totalSkill, 
            'totalArtworks' => $totalArtwork
        ]);
    }

    public function buyer()
    {
        $buyers = Buyer::all();
        return view('admin.buyers', compact('buyers'));
    }

    public function activateBuyer($id)
    {
        $result = "";
        $buyer = Buyer::find($id);
        if ($buyer->isActive()) {
            Mail::to($buyer->MasterUser->EMAIL)->send(new DeactiveBuyer($buyer));
            $buyer->IS_ACTIVE = 0;
            $result = "deactivated";
        } else {
            Mail::to($buyer->MasterUser->EMAIL)->send(new ActiveBuyer($buyer));
            $buyer->IS_ACTIVE = 1;
            $result = "activated";
        }
        $buyer->save();
        return redirect()->back()->with('status','Buyer '.$buyer->FULLNAME.' is '.$result);
    }

    public function artist()
    {
        $artists = Artist::whereHas('MasterUser', function ($query) {
            $query->where('USER_LEVEL', 2);
        })->get();;
        return view('admin.artists', compact('artists'));
    }

    public function activateArtist($id)
    {
        $result = "";
        $artist = Artist::find($id);
        $user = MasterUser::find($artist->USER_ID);
        if ($artist->isActive()) {
            Mail::to($artist->MasterUser->EMAIL)->send(new DeactiveArtist($artist));
            $artist->IS_ACTIVE = 0;
            $result = "deactivated";
        } else {
            Mail::to($artist->MasterUser->EMAIL)->send(new ActiveArtist($artist));
            $artist->IS_ACTIVE = 1;
            $result = "activated";
        }
        $artist->save();
        $user->save();
        return redirect()->back()->with('status','Artist '.$artist->MasterUser->Buyer->FULLNAME.' is '.$result);
    }

    public function category()
    {
        $categories = ArtCategoryMaster::get();
        return view('admin.category',compact('categories'));
    }

    public function addCategory(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'DESCR' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $category = ArtCategoryMaster::create($request->all());

        return redirect()->back()->with('status','Category "'.$category->DESCR.'" added!');
    }

    public function deleteCategory($id)
    {
        $category = ArtCategoryMaster::find($id);
        // dd($category);

        if($category == null) {
            return redirect()->back()->withErrors(['message'=>'Category not found!']);
        }
        $category->delete();
        return redirect()->back()->with('status','Category "'.$category->DESCR.'" deleted!');
    }

    public function skill()
    {
        $skills = SkillMaster::get();
        return view('admin.skills',compact('skills'));
    }

    public function addSkill(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'DESCR' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $skill = SkillMaster::create($request->all());

        return redirect()->back()->with('status','Skill "'.$skill->DESCR.'" added!');
    }

    public function deleteSkill($id)
    {
        $skill = SkillMaster::find($id);
        // dd($skill);

        if($skill == null) {
            return redirect()->back()->withErrors(['message'=>'Skill not found!']);
        }
        $skill->delete();
        return redirect()->back()->with('status','Skill "'.$skill->DESCR.'" deleted!');
    }

    public function joinRequest()
    {
        $artists = Artist::where('IS_ACTIVE', 0)
        ->whereHas('MasterUser', function ($query) {
            $query->where('USER_LEVEL', 1);
        })
        ->get();
        return view('admin.artist-join-request', compact('artists'));
    }

    public function approveArtist($id)
    {
        $artist = Artist::find($id);

        if($artist->count() < 1) {
            return redirect()->back()->withErrors(['message'=>'Join artist application not found!']);
        }

        $user = MasterUser::find($artist->USER_ID);
        $artist->IS_ACTIVE = 1;
        $user->USER_LEVEL = 2;
        $artist->save();
        $user->save();
        Mail::to($artist->MasterUser->EMAIL)->send(new JoinArtistApprove($artist));
        return redirect()->back()->with('status','Artist '.$artist->MasterUser->Buyer->FULLNAME.' is approved');
    }

    public function rejectArtist($id)
    {
        $artist = Artist::find($id);
        if($artist->count() < 1) {
            return redirect()->back()->withErrors(['message'=>'Join artist application not found!']);
        }

        $artist->delete();
        Mail::to($artist->MasterUser->EMAIL)->send(new JoinArtistRejected($artist));
        return redirect()->back()->with('status','Artist '.$artist->MasterUser->Buyer->FULLNAME.' is rejected');
    }

    public function artistReport()
    {
        $reports = ArtistReport::get();
        return view('admin.artist-report',compact('reports'));
    }

    public function markArtistReport($id)
    {
        $result = "";
        $report = ArtistReport::find($id);
        if ($report->STATUS == 1) {
            $report->STATUS = 0;
        } else {
            $report->STATUS = 1;
        }
        $report->save();
        return redirect()->back()->with('status','Report '.$report->ARTIST_REPORT_ID.' is '. $report->getStatus());
    }

    public function blog()
    {
        $blogs = Blog::get();
        return view('admin.blogs', compact('blogs'));
    }

    public function createBlog()
    {
        return view('admin.blog-form');
    }

    public function storeBlog(Request $request)
    {
        $user = Auth::user();

        $validated = Validator::make($request->all(), [
            'IMAGE' => 'required',
            'TITLE' => 'required',
            'CONTENT' => 'required',
        ]);

        $slug = Str::slug($request->TITLE, '-');

        // Check for uniqueness (optional)
        $originalSlug = $slug;
        $counter = 1;
        while (Blog::where('SLUG', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->errors());
        }

        $uploadedFile = $request->file('IMAGE');
        $imagePath = $uploadedFile->store('images/blog', 'public');

        $blog = $user->Blogs()->create([
            'TITLE' => $request->TITLE,
            'SLUG' => $slug,
            'CONTENT' => $request->CONTENT,
            'IMAGE_PATH' => $imagePath
        ]);

        return redirect()->route('admin.blog.show')->with('status','Blog "'. $blog->TITLE .'" has been uploaded');
    }

    public function destroyBlog($id)
    {
        $blog = Blog::find($id);

        if($blog == null) {
            return redirect()->back()->withErrors(['message'=>'Blog not found!']);
        }

        $filePath = $blog->IMAGE_PATH;
        Storage::disk('public')->delete($filePath);

        $blog->delete();

        return redirect()->back()->with('status','Blog "'. $blog->TITLE .'" has been deleted!');
    }
}
