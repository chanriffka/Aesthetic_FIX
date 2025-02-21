<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\Models\Artist;
use App\Models\ArtCategory;
use App\Models\ArtImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ArtistPortfolioController extends Controller
{
    public function store(Request $request)
    {
        
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();

        $validated = Validator::make($request->all(), [
            'portfolioTitle' => 'required',
            'portfolioDescription' => 'required',
            'artworkWidth' => 'required',
            'artworkHeight' => 'required',
            'dimensionUnit' => 'required',
        ], [
            'portfolioTitle.required' => '* The portfolio title is required.',
            'portfolioDescription.required' => '* The portfolio description is required.',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $art = $user->Arts()->create([
            'ART_TITLE' => $request->portfolioTitle,
            'DESCRIPTION' => $request->portfolioDescription,
            'IS_SALE' => false,
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

        if ($request->filled('portfolioImageLink')) {
            $imagePath = $request->input('portfolioImageLink');
        }

        // If file is uploaded
        if ($request->hasFile('portfolioImageUpload')) {
            $uploadedFile = $request->file('portfolioImageUpload');
            $imagePath = $uploadedFile->store('images/art', 'public'); // Save file in the `storage/app/public/images/art` directory
        }

        $art->ArtImages()->create([
            'IMAGE_PATH' => $imagePath
        ]);
        
        return redirect()->back()->with('status','New portfolio has been added!');
    }

    public function deletePortfolio($portfolioId){
        $user = Auth::guard('MasterUser')->user();

        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();
        if($artist == null) {
            abort(404, 'You are not artist');
        }

        $portfolio = Art::find($portfolioId);

        if($portfolio->USER_ID != $user->USER_ID) {
            abort(404, 'You are not owner of this hiring');
        }

        if($portfolio->ArtImages->count() > 0) {
            foreach($portfolio->ArtImages as $image) {
                if ($image->IMAGE_PATH != null) {
                    if(Str::startsWith($image->IMAGE_PATH, 'images/art/')) {
                        $filePath = $image->IMAGE_PATH;
                        Storage::disk('public')->delete($filePath);
                    }
                }
            }
        }

        $portfolio->delete();

        return redirect()->route('artist.show', ['id' => $artist->ARTIST_ID, 'section' => 'portfolio'])->with('status', 'Portfolio has been deleted successfully!');
    }

    public function update($id, Request $request)
    {
        $user = Auth::guard('MasterUser')->user();
        $portfolio = Art::find($id);

        if($portfolio->USER_ID != $user->USER_ID) {
            return redirect()->back()->withError(['message'=>'Artwork is not yours']);
        }

        if($portfolio->OrderItems->count() > 0) {
            return redirect()->back()->with('status','Cannot delete due to artwork has been sold');
        }

        $validated = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'portfolioWidth' => 'required',
            'portfolioHeight' => 'required',
            'dimensionUnit' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $portfolio->ART_TITLE = $request->title;
        $portfolio->DESCRIPTION = $request->description;
        $portfolio->WIDTH = $request->portfolioWidth;
        $portfolio->HEIGHT = $request->portfolioHeight;
        $portfolio->UNIT = $request->dimensionUnit;

        $imagePath = null;

        // If URL is provided
        if ($request->filled('imageLink')) {
            $imagePath = $request->input('imageLink');
            $this->deleteImage($portfolio->ART_ID);
        }

        // If file is uploaded
        if ($request->hasFile('imageFile')) {
            $uploadedFile = $request->file('imageFile');
            $imagePath = $uploadedFile->store('images/art', 'public'); // Save file in the `storage/app/public/images/art` directory
            $this->deleteImage($portfolio->ART_ID);
        }

        if($imagePath != null) {
            $portfolio->ArtImages()->create([
                'IMAGE_PATH' => $imagePath
            ]);
        }

        $portfolio->save();
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
}
