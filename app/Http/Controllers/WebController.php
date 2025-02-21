<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;
use App\Models\Buyer;
use App\Models\MasterUser;
use App\Models\Art;
use App\Models\Post;
use App\Models\Blog;
use App\Models\SkillMaster;
use App\Models\ArtCategoryMaster;
use App\Models\contactUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use function PHPUnit\Framework\isNull;

class WebController extends Controller
{

    public function showArtist($id, $section = 'home')
{
    $artists = [
        1 => ['name' => 'Devin Jatho', 'bio' => 'Graphic Designer', 'location' => 'Anywhere', 'image' => 'artist1.jpg'],
        // other artists...
    ];

    if (!isset($artists[$id])) {
        abort(404, 'Artist not found.');
    }

    $artist = $artists[$id];
    $artistId = $id; // Set artistId for use in the view

    return view('artists.show', compact('artist', 'section', 'artistId'));
}
 
    public function listArtists()
{
    $artists = [
        ['id' => 1, 'name' => 'Devin Jatho', 'job' => 'Graphic Designer', 'location' => 'Anywhere', 'image' => 'melody2.jpg', 'posted_at' => '2 days ago'],
        ['id' => 2, 'name' => 'Make Relish', 'job' => 'Production Coordinator', 'location' => 'Anywhere', 'image' => 'melody.webp', 'posted_at' => '3 days ago'],
        ['id'=>  3, 'name'=> 'Geri Walker',  'job'  => 'Web Designer', 'location' => 'America', 'image' => 'artist2.jpg', 'posted_at' => '4 days ago'],
        ['id'=>  4, 'name'=> 'Paul Vane',  'job'  => 'Illustrator', 'location' => 'America', 'image' => 'artist2.jpg', 'posted_at' => '4 days ago'],
        ['id'=>  5, 'name'=> 'Steve James',  'job'  => 'Production Coordinator', 'location' => 'America', 'image' => 'artist2.jpg', 'posted_at' => '4 days ago'],
        ['id'=>  6, 'name'=> 'Diu South',  'job'  => 'Graphic Designer', 'location' => 'America', 'image' => 'artist2.jpg', 'posted_at' => '4 days ago'],
        ['id'=>  7, 'name'=> 'Luminous Ror',  'job'  => 'Production Coordinator', 'location' => 'America', 'image' => 'artist2.jpg', 'posted_at' => '4 days ago'],
        ['id'=>  8, 'name'=> 'Gemini',  'job'  => 'Production Coordinator', 'location' => 'America', 'image' => 'artist2.jpg', 'posted_at' => '4 days ago'],
        ['id'=>  9, 'name'=> 'Scorpio',  'job'  => 'Production Coordinator', 'location' => 'America', 'image' => 'artist2.jpg', 'posted_at' => '4 days ago'],
    ];

    return view('artists.index', compact('artists'));
    }
    
    public function explore(Request $request)
    {
        $carts = null;
        if(Auth::user() != null) {
            $carts = Auth::user()->Carts;
        }
        
        if (Auth::guard('MasterUser')->check()){
            // $arts = Art::where('IS_SALE', '=', 1)
            //         ->where('USER_ID', '!=', Auth::user()->USER_ID)
            //         ->get();
            if(Auth::user()->USER_LEVEL == 2 || Auth::user()->USER_LEVEL == 3)
            {
                $arts = Art::where('IS_SALE', 1)
                    ->where('USER_ID', '!=', Auth::user()->USER_ID) // Replace auth()->id() with the current user ID if needed
                    ->whereDoesntHave('OrderItems', function ($query) {
                        $query->select('ORDER_ITEM_ID'); // Optional: This is just for clarity; Laravel handles it automatically
                    })
                    ->get();
            }
            else
            {
                $arts = Art::where('IS_SALE', 1)
                    ->where('USER_ID', '!=', Auth::user()->USER_ID) // Replace auth()->id() with the current user ID if needed
                    ->where('IS_VERIF', '=', 1)
                    ->whereDoesntHave('OrderItems', function ($query) {
                        $query->select('ORDER_ITEM_ID'); // Optional: This is just for clarity; Laravel handles it automatically
                    })
                    ->get();
            }
            
        }
        else{
            // $arts = Art::where('IS_SALE', '=', 1)
            //         ->get();

            $arts = Art::where('IS_SALE', 1) // Replace auth()->id() with the current user ID if needed
                    ->whereDoesntHave('OrderItems', function ($query) {
                        $query->select('ORDER_ITEM_ID'); // Optional: This is just for clarity; Laravel handles it automatically
                    })
                    ->get();
        }
        
        $artCategories = ArtCategoryMaster::all();
        return view('explore', compact('carts', 'arts', 'artCategories'));
    }

    public function landing(Request $request)
    {
        $carts = null;
        if (Auth::user() != null) {
            $carts = Auth::user()->Carts;
        }

        // Fetch latest blog or create an empty Blog object
        $latestBlog = Blog::orderBy('created_at', 'DESC')->first();
        
        if (is_null($latestBlog)) {  // ✅ Correct function: `is_null()`
            $latestBlog = new Blog(); // Ensures latestBlog is always an object
            $blogs = collect([]); // ✅ Ensures $blogs is an empty collection, not a single model
        } else {
            $blogs = Blog::where('BLOG_ID', '!=', $latestBlog->BLOG_ID)->limit(3)->get();
        }

        return view('landing', compact('carts', 'latestBlog', 'blogs'));
    }

    public function landing2(Request $request)
    {
        return view('landing2');
    }

    public function home(Request $request)
    {
        return view('Home.home');
    }

    private function getArtworksByCategory($category)
    {
        $allArtworks = [
            'all' => [
                ['title' => 'Artwork 1', 'artist' => 'Artist 1', 'price' => '$5,000', 'image' => 'artwork1.jpg'],
                ['title' => 'Artwork 2', 'artist' => 'Artist 2', 'price' => '$3,500', 'image' => 'artwork2.jpg'],
            ],
            'featured' => [
                ['title' => 'Featured Artwork', 'artist' => 'Artist 2', 'price' => '$3,500', 'image' => 'featured1.jpg'],
            ],
            'anime' => [
                ['title' => 'Anime Artwork', 'artist' => 'Artist 3', 'price' => '$2,500', 'image' => 'anime1.jpg'],
            ],
        ];

        return $allArtworks[$category] ?? [];
    }

    public function showArtwork($id)
    {
        $artwork = Art::find($id);

        if (!isset($artwork)) {

            abort(404, 'Artwork not found.');

        }

        $artwork->addView();

        $moreArtWorks = Art::where('IS_SALE', 1)
                    ->where('USER_ID', '=', $artwork->USER_ID)
                    ->where('ART_ID', '!=', $id) // Replace auth()->id() with the current user ID if needed
                    ->whereDoesntHave('OrderItems', function ($query) {
                        $query->select('ORDER_ITEM_ID'); // Optional: This is just for clarity; Laravel handles it automatically
                    })
                    ->get();

        // $moreArtWorks = Art::where('USER_ID',$artwork->USER_ID)->where('ART_ID', '!=', $artwork->ART_ID)->limit(4)->get();
    

        $carts = null;
        if(Auth::user() != null) {
            $carts = Auth::user()->Carts;
        }
    
        // // Calculate the aspect ratio
        // $aspectRatio = $image->height() / $image->width();
        // $imageClass = '';
    
        // if ($aspectRatio > 1) {
        //     // Vertical image
        //     $imageClass = 'h-auto w-full object-contain';
        // } elseif ($aspectRatio < 1) {
        //     // Horizontal image
            
        // } else {
        //     // Square image
        //     $imageClass = 'h-full w-full object-cover';
        // }
    
        $imageClass = 'h-full w-full object-cover';
        
        return view('artists.sections.artwork-detail', compact('artwork', 'imageClass','moreArtWorks','carts'));
    }    
    public function showCategory($category)
    {
        // Logic to fetch artworks based on the category
        $artworks = $this->getArtworksByCategory($category);

        return view('artists.sections.collection-detail', compact('artworks', 'category'));
    }

    public function likeHistory()
    {
        $artLikes = Auth::user()->ArtLikes;
        return view('profile.like-history', compact('artLikes'));
    }

    public function folloProfile()
    {
        $user = Auth::user();
        $followers = $user->Followers;
        $followings = $user->Followings;

        return view('profile.follo-profile', compact('user','followers','followings'));
    }

    public function followers()
    {
        return view('artists.followers-sidebar');
    }

    public function following()
    {
        $user = Auth::user();
        $followings = $user->Followings;
        return view('artists.following-sidebar',compact('followings'));
    }

    public function artistfollowers($id)
    {
        $user = MasterUser::find($id);
        if($user == null) {
            return redirect()->back()->withErrors(['User not found']);
        }
        $followers = $user->Followers;

        // dd($followers);
        return view('artists.followers', compact('followers'));
    }

    public function artistfollowing($id)
    {
        $user = MasterUser::find($id);
        if($user == null) {
            return redirect()->back()->withErrors(['User not found']);
        }
        $followings = $user->Followings;
        return view('artists.following',compact('followings'));
    }

public function cartProfile()
{
    $carts = Auth::user()->Carts;
    return view('profile.cart-profile', compact('carts'));
}

public function aboutUs()
{
    return view('footer.about-us');
}

public function joinArtist()
{
    if(Auth::Check())
    {
        $user = Auth::guard('MasterUser')->user();
        $skillsMaster = SkillMaster::all();
        return view('profile.join-artist', [
            'USER' => $user,
            'ROLE' => $user->USER_LEVEL,
            'BUYER_DATA' => $user->Buyer,
            'skillsMaster' => $skillsMaster
        ]);
    }
    else{
        return view('profile.join-artist');
    }    
}

public function registerArtist(Request $request)
{
    $validator = Validator::make($request->all(), [
        // 'location' => 'required',
        'role' => 'required',
        'bio' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }

    $user = Auth::guard('MasterUser')->user();

    $artist = new Artist();
    $artist->USER_ID = $user->USER_ID;
    $artist->LOCATION = 'Indonesia';
    $artist->ROLE = $request->role;
    $artist->BIO = $request->bio;
    $artist->ABOUT = ' ';
    $artist->save();

    return redirect()->back()->with('status','success');
}

public function insightArtist()
{
    $user = Auth::user();

    // foreach($user->)
    // dd($user->USER_ID);
    // dd($user->getSoldItems());
    // $soldItems = $user->getSoldItems();

    return view('profile.insight', compact('user'));
}

    public function blog()
    {
        $blogs = Blog::all();
        return view('footer.blog', compact('blogs'));
    }

    public function showBlogDetail($slug)
    {
        $blogs = Blog::orderBy('created_at','DESC')->limit(4)->get();
        $blog = Blog::where('SLUG',$slug)->first();

        $blog->VIEW = $blog->VIEW + 1;
        $blog->save();

        if($blog == null) {
            return redirect()->back()->withErrors(['message'=>'Blog not found!']);
        }

        return view('footer.blog-detail',compact('blog','blogs'));
    }

    public function blogPreview($slug)
    {
        $blogs = Blog::orderBy('created_at','DESC')->limit(4)->get();
        $blog = Blog::where('SLUG',$slug)->first();

        $blog->VIEW = $blog->VIEW + 1;
        $blog->save();

        if($blog == null) {
            return redirect()->back()->withErrors(['message'=>'Blog not found!']);
        }

        return view('admin.blog-detail-preview',compact('blog','blogs'));
    }

    public function blogDetail()
    {
        return view('footer.blog-detail');
    }

    public function contactUs()
    {
        return view('footer.contact-us');
    }

    public function storeContactUs(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'phoneNumber' => 'required',
            'message' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        contactUs::create([
            'FULLNAME' => $request->firstName." ".$request->lastName,
            'EMAIL' => $request->email,
            'PHONE_NUMBER' => $request->phoneNumber,
            'MESSAGE' => $request->message
        ]);

        return redirect()->back()->with('status','Hi '.$request->firstName.' '.$request->lastName. ', your message has been sent. We will reach you out soon');
    }

public function collectionDetails()
{
    return view('artists.sections.all-artworks');
}


public function buyerProfile(){
    $user = Auth::user();
    return view('buyer.profile',compact('user'));
}


}
