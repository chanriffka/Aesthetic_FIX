<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Art;
use App\Models\Artist;
use App\Models\ArtCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArtGalleryController extends Controller
{
    public function index()
    {
        $carts = null;

        if(Auth::user() != null) {
            $carts = Auth::user()->Carts;
        }

        $portfolios = Art::where('IS_SALE',false)->get();

        return view('art-gallery',compact('portfolios','carts'));
    }

    public function show($id)
    {
        $carts = null;

        if(Auth::user() != null) {
            $carts = Auth::user()->Carts;
        }

        $portfolio = Art::find($id);

        $portfolio->addView();

        $role = $portfolio->MasterUser->Artist->ROLE;

        $artistRecommendations = Artist::where('ROLE', $role)
        ->where('USER_ID', '!=', $portfolio->MasterUser->USER_ID)
        ->limit(4) // Exclude the current artist
        ->get();

        $morePortfolios = Art::where('USER_ID',$portfolio->USER_ID)->where('IS_SALE',false)->where('ART_ID', '!=', $portfolio->ART_ID)->limit(4)->get();

        if ($portfolio == null) {
            abort(404);
        }

        return view('art-gallery-detail',compact('portfolio','morePortfolios', 'carts', 'artistRecommendations'));
    }

}
