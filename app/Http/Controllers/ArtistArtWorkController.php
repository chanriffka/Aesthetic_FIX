<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\Models\Artist;
use App\Models\ArtCategory;
use App\Models\ArtCollection;
use App\Models\ArtImage;
use App\Models\ArtLike;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArtistArtWorkController extends Controller
{
    public function showAllArtwork($ARTIST_ID)
    {
        // Example data for the artworks
        $artworks =  DB::table('ART')
                    ->select(
                        'ART.ART_ID', 
                        'ART.ART_TITLE', 
                        'ART_IMAGE.IMAGE_PATH', 
                        'MASTER_USER.USERNAME',
                        'ART.IS_SALE', 
                        DB::raw("FORMAT(ART.PRICE, 'N0') as ART_PRICE"), 
                        DB::raw("YEAR(ART.CREATED_AT) as ART_YEAR")
                    )
                    ->join('ART_IMAGE', 'ART.ART_ID', '=', 'ART_IMAGE.ART_ID')
                    ->join('ARTIST', 'ARTIST.ARTIST_ID', '=', 'ART.ARTIST_ID')
                    ->join('MASTER_USER', 'MASTER_USER.USER_ID', '=', 'ARTIST.USER_ID')
                    ->where('ART.ARTIST_ID', '=', $ARTIST_ID)
                    ->orderBy('ART.CREATED_AT', 'desc')
                    ->get(); 
                            
        $artistId = $ARTIST_ID;

        $artistUser = DB::table('ARTIST')
                    ->select('USER_ID')
                    ->where('ARTIST_ID', '=', $artistId)
                    ->first();
                
        $artistUserId = $artistUser ? $artistUser->USER_ID : null;
        
        $totalArtWorks = DB::table('ART')
                        ->select('*')
                        ->where('ARTIST_ID','=',$ARTIST_ID)
                        ->count();

        $artCategoryMaster = DB::table('ART_CATEGORY_MASTER')
                            ->select('*')
                            ->get();

        return view('artists.sections.all-artworks', compact('artworks', 'artistId','totalArtWorks','artCategoryMaster', 'artistUserId'));
    }

    public function addArtWork(Request $request)
    {
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();

        $validated = Validator::make($request->all(), [
            'artworkTitle' => 'required',
            'artworkDescription' => 'required',
            'artworkPrice' => 'required',
            'artworkWidth' => 'required',
            'artworkHeight' => 'required',
            'dimensionUnit' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $art = $user->Arts()->create([
            'ART_TITLE' => $request->artworkTitle,
            'DESCRIPTION' => $request->artworkDescription,
            'IS_SALE' => true,
            'PRICE' => $request->artworkPrice,
            'WIDTH' => $request->artworkWidth,
            'HEIGHT' => $request->artworkHeight,
            'UNIT' => $request->dimensionUnit
        ]);

        if($request->category_art != null) {
            foreach ($request->category_art as $categoryId) {
                $art->ArtCategories()->create([
                    'ART_CATEGORY_MASTER_ID' => $categoryId,
                ]);
            }
        }

        $imagePath = null;

        // If URL is provided
        if ($request->filled('artworkImageLink')) {
            $imagePath = $request->input('artworkImageLink');
        }

        // If file is uploaded
        if ($request->hasFile('artworkImageUpload')) {
            $uploadedFile = $request->file('artworkImageUpload');
            $imagePath = $uploadedFile->store('images/art', 'public'); // Save file in the `storage/app/public/images/art` directory
        }

        $art->ArtImages()->create([
            'IMAGE_PATH' => $imagePath
        ]);
        
        return redirect()->back()->with('status','New artwork has been added!');
    }

    public function deleteArtWork($artworkId){
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();
        if($artist == null) {
            abort(404, 'You are not artist');
        }

        $artwork = Art::find($artworkId);

        if($artwork->OrderItems->count() > 0) {
            return redirect()->back()->with('status','Cannot delete due to artwork has been sold');
        }

        if($artwork->USER_ID != $user->USER_ID) {
            abort(404, 'You are not owner of this hiring');
        }

        if($artwork->ArtImages->count() > 0) {
            foreach($artwork->ArtImages as $image) {
                if ($image->IMAGE_PATH != null) {
                    if(Str::startsWith($image->IMAGE_PATH, 'images/art/')) {
                        $filePath = $image->IMAGE_PATH;
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
        }

        $artwork->delete();

        return redirect()->route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'artwork'])->with('status', 'Artwork has been deleted successfully!');
    }

    public function update($id, Request $request)
    {
        $user = Auth::guard('MasterUser')->user();
        $artwork = Art::find($id);

        if($artwork->USER_ID != $user->USER_ID) {
            return redirect()->back()->withError(['message'=>'Artwork is not yours']);
        }

        if($artwork->OrderItems->count() > 0) {
            return redirect()->back()->with('status','Cannot delete due to artwork has been sold');
        }

        $validated = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'artworkWidth' => 'required',
            'artworkHeight' => 'required',
            'dimensionUnit' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $artwork->ART_TITLE = $request->title;
        $artwork->DESCRIPTION = $request->description;
        $artwork->PRICE = $request->price;
        $artwork->WIDTH = $request->artworkWidth;
        $artwork->HEIGHT = $request->artworkHeight;
        $artwork->UNIT = $request->dimensionUnit;

        $imagePath = null;

        // If URL is provided
        if ($request->filled('imageLink')) {
            $imagePath = $request->input('imageLink');
            $this->deleteImage($artwork->ART_ID);
        }

        // If file is uploaded
        if ($request->hasFile('imageFile')) {
            $uploadedFile = $request->file('imageFile');
            $imagePath = $uploadedFile->store('images/art', 'public'); // Save file in the `storage/app/public/images/art` directory
            $this->deleteImage($artwork->ART_ID);
        }

        if($imagePath != null) {
            $artwork->ArtImages()->create([
                'IMAGE_PATH' => $imagePath
            ]);
        }

        $artwork->save();
        return redirect()->back()->with('status','Art has been updated!');
    }

    public function deleteImage($artId)
    {
        $artImages = ArtImage::where('ART_ID',$artId)->get();
        foreach($artImages as $image) {
            if ($image->IMAGE_PATH != null) {
                if(Str::startsWith($image->IMAGE_PATH, 'images/art/')) {
                    $filePath = $image->IMAGE_PATH;
                    Storage::disk('public')->delete($filePath);
                }
            }
            $image->delete();
        }
    }

    public function like($id)
    {
        $user = Auth::user();
        $art = Art::find($id);

        $like = ArtLike::where('ART_ID',$art->ART_ID)->where('USER_ID',$user->USER_ID)->first();
        if ($like != null) {
            $like->delete();
        } else {
            $art->ArtLikes()->create([
                'USER_ID' => $user->USER_ID
            ]);
        }

        return redirect()->back()->with('status','art being liked!');
    }
}
