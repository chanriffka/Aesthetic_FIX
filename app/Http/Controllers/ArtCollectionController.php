<?php

namespace App\Http\Controllers;

use App\Models\ArtCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtCollectionController extends Controller
{
    public function destroy($id) {
        // Find the specific collection by its ID
        $artCollection = ArtCollection::where('ART_COLLECTION_ID', $id)->first();

        if (!$artCollection) {
            return redirect()->back()->withErrors(['error' => 'Collection not found.']);
        }
        
        $artCollection->delete();

        return redirect()->back()->with('status', 'Collection has been updated successfully!');
    }
}
