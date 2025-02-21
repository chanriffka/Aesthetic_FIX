<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Buyer;

class BuyerController extends Controller
{
    public function updateBuyerProfile(Request $request)
    {
        $user = Auth::user();
        $buyer = Buyer::where('USER_ID',$user->USER_ID)->first();

        if ($buyer == null) {
            abort(404, 'Artist not found.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user->USERNAME = $request->username;
        $buyer->FULLNAME = $request->name;
        $buyer->PHONE_NUMBER = $request->phone;
        $buyer->ADDRESS = "";
        $imagePath = $buyer->PROFILE_IMAGE_URL;

        if ($request->hasFile('picture')) {
            $uploadedFile = $request->file('picture');
            if($uploadedFile != null) {
                // dd($uploadedFile);
                $imagePath = $uploadedFile->store('images/user', 'public'); // Save file in the `storage/app/public/images/art` directory

                if($buyer->PROFILE_IMAGE_URL != null) {
                    $filePath = $buyer->PROFILE_IMAGE_URL; // Relative to the storage/app directory
                    Storage::disk('public')->delete($filePath);
                }
            }
        }

        $buyer->PROFILE_IMAGE_URL = $imagePath;
        $user->save();
        $buyer->save();

        return redirect()->back()->with('success','Profile has been updated successfully');
    }
}
