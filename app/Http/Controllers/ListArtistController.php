<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Artist;
use App\Models\SkillMaster;

class ListArtistController extends Controller
{
    public function viewListArtist()
    {
        $carts = null;
        if(Auth::user() != null) {
            $carts = Auth::user()->Carts;
        

            if(Auth::user()->USER_LEVEL == 2) {
                $listArtist = Artist::where('IS_ACTIVE',true)
                                ->where('IS_BAN', false)
                                ->where('ARTIST_ID','!=',Auth::User()->Artist->ARTIST_ID) 
                                ->get();
                $skills = SkillMaster::all();

                $countArtist = $listArtist->COUNT();

                // DB::table('ARTIST')
                //             ->select('ARTIST.ARTIST_ID', DB::raw('DATEDIFF(day, ARTIST.JOIN_DATE, GETDATE()) AS JOINED'), 'MASTER_USER.USERNAME', 'ARTIST.LOCATION', 'ARTIST.ROLE','ARTIST.BIO', 'MASTER_USER.PROFILE_IMAGE_PATH')
                //             ->join('MASTER_USER', 'ARTIST.USER_ID', '=', 'MASTER_USER.USER_ID')
                //             ->get();

                return view('artists.index', compact('countArtist','listArtist','carts', 'skills'));
            }
            else
            {
            
    
                $listArtist = Artist::where('IS_ACTIVE',true)
                                    ->where('IS_BAN', false)
                                    ->get();
                $skills = SkillMaster::all();
    
                $countArtist = $listArtist->COUNT();
    
                // DB::table('ARTIST')
                //             ->select('ARTIST.ARTIST_ID', DB::raw('DATEDIFF(day, ARTIST.JOIN_DATE, GETDATE()) AS JOINED'), 'MASTER_USER.USERNAME', 'ARTIST.LOCATION', 'ARTIST.ROLE','ARTIST.BIO', 'MASTER_USER.PROFILE_IMAGE_PATH')
                //             ->join('MASTER_USER', 'ARTIST.USER_ID', '=', 'MASTER_USER.USER_ID')
                //             ->get();
    
                return view('artists.index', compact('countArtist','listArtist','carts', 'skills'));
                
    
            }
        }
        else{
        }

            $listArtist = Artist::where('IS_ACTIVE',true)
                                ->where('IS_BAN', false)
                                ->get();
            $skills = SkillMaster::all();

            $countArtist = $listArtist->COUNT();

            // DB::table('ARTIST')
            //             ->select('ARTIST.ARTIST_ID', DB::raw('DATEDIFF(day, ARTIST.JOIN_DATE, GETDATE()) AS JOINED'), 'MASTER_USER.USERNAME', 'ARTIST.LOCATION', 'ARTIST.ROLE','ARTIST.BIO', 'MASTER_USER.PROFILE_IMAGE_PATH')
            //             ->join('MASTER_USER', 'ARTIST.USER_ID', '=', 'MASTER_USER.USER_ID')
            //             ->get();

            return view('artists.index', compact('countArtist','listArtist','carts', 'skills'));
            

        }

}
