<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\ArtistHire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArtistHireController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();

        $validated = Validator::make($request->all(), [
            'projectTitle' => 'required',
            'projectDescription' => 'required',
            'timeline' => 'required',
            'budget' => 'required',
            'skills' => 'required',
            'experienceLevel' => 'required',
            'otherRequirements' => 'required'
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        ArtistHire::create([
            'ARTIST_ID' => $artist->ARTIST_ID,
            'PROJECT_TITLE' => $request->projectTitle,
            'PROJECT_DESCR' => $request->projectDescription,
            'PROJECT_TIMELINE' => $request->timeline,
            'PROJECT_BUDGET' => $request->budget,
            'PROJECT_SKILLS' => $request->skills,
            'PROJECT_EXPERIENCE_LEVEL' => $request->experienceLevel,
            'OTHER_REQUIREMENTS' => $request->otherRequirements
        ]);

        return redirect()->back()->with('status', 'Hire has been added successfully!');
    }

    public function destroy($id)
    {
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();
        if($artist == null) {
            abort(404, 'You are not artist');
        }
        
        $hire = ArtistHire::find($id);

        if($hire->ARTIST_ID != $artist->ARTIST_ID) {
            abort(404, 'You are not owner of this hiring');
        }

        $hire->delete();

        return redirect()->back()->with('status', 'Hire has been deleted successfully!');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('MasterUser')->user();
        $artist = Artist::where('ARTIST_ID','=',$user->Artist->ARTIST_ID)->first();

        $hire = ArtistHire::find($id);

        if($hire->ARTIST_ID != $artist->ARTIST_ID) {
            abort(404, 'You are not owner of this hiring');
        }

        $validated = Validator::make($request->all(), [
            'projectTitle' => 'required',
            'projectDescription' => 'required',
            'timeline' => 'required',
            'budget' => 'required',
            'skills' => 'required',
            'experienceLevel' => 'required',
            'otherRequirements' => 'required'
        ]);

        $hire->PROJECT_TITLE = $request->projectTitle;
        $hire->PROJECT_DESCR = $request->projectDescription;
        $hire->PROJECT_TIMELINE = $request->timeline;
        $hire->PROJECT_BUDGET = $request->budget;
        $hire->PROJECT_SKILLS = $request->skills;
        $hire->PROJECT_EXPERIENCE_LEVEL = $request->experienceLevel;
        $hire->OTHER_REQUIREMENTS = $request->otherRequirements;
        
        $hire->save();


        return redirect()->back()->with('status', 'Hire has been updated successfully!');
    }
}
