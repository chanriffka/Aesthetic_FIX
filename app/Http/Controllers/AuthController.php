<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\MasterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        if (Auth::guard('MasterUser')->check()) {
            return redirect()->route('landing');
        }

        return view('register');
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userName' => 'required|unique:MASTER_USER,USERNAME|max:255',
            'password' => 'required|confirmed|min:6',
            'email' => 'required|email:rfc,dns|unique:MASTER_USER,EMAIL',
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $MasterUser = new MasterUser();
        $Buyer = new Buyer();

        $MasterUser->USERNAME = $request->userName;
        $MasterUser->PASSWORD = Hash::make($request->password);
        $MasterUser->EMAIL = $request->email;
        $MasterUser->USER_LEVEL = 1;
        $MasterUser->save();

        $Buyer->USER_ID = $MasterUser->USER_ID;
        $Buyer->FULLNAME = $request->firstName.' '.$request->lastName;
        $Buyer->PHONE_NUMBER = $request->phone;
        $Buyer->ADDRESS = "Dummy";
        $Buyer->save();

        return redirect()->route('login');
    }

    public function login()
    {
        if (Auth::guard('MasterUser')->check()) {
            return redirect()->route('landing');
        }
        else{
            return view('login');
        }
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('MasterUser')->attempt($credentials)) {
            $user = Auth::guard('MasterUser')->user();

            // Load related models
            $buyer = $user->Buyer;
            $artist = $user->Artist;

            $buyerInactive = $user->Buyer && $user->Buyer->IS_ACTIVE == 0;
            // $artistInactive = $user->Artist && $user->Artist->IS_ACTIVE == 0;

            if ($buyerInactive) {
                Auth::guard('MasterUser')->logout(); // Log out the user
                return redirect()->route('login')->withErrors([
                    'Inactive' => 'Warning!']);
            }

            if($user->USER_LEVEL == 3) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('landing');
            }
        } else {
            return redirect()->back()->withErrors([
                'authorization' => 'Warning!'
            ]);
        }
    }

    public function logout()
    {
        if (Auth::guard('MasterUser')->check()) {
            Auth::guard('MasterUser')->logout();
        }

        if (Auth::guard('BuyerUser')->check()) {
            Auth::guard('BuyerUser')->logout();
        }
        
        if (Auth::guard('ArtistUser')->check()) {
            Auth::guard('ArtistUser')->logout();
        }
        
        return redirect()->route('landing');
    }

    public function resetpassword(Request $request)
    {
        if (Auth::guard('MasterUser')->check()) {
            return redirect()->route('landing');
        }
        
        return view('resetpassword'); 
    }

    public function resetPasswordPost(Request $request){

        $credentials = $request->only('email', 'password');

        if (Auth::guard('MasterUser')->attempt($credentials)) {
            // Fetch the MasterUser instance
            $MasterUser = MasterUser::where('EMAIL', '=', $request->email)->first();

            // Update the password
            $MasterUser->PASSWORD = Hash::make($request->newPassword);
            $MasterUser->save();

            Auth::guard('MasterUser')->logout();
            return redirect()->route('login')->with('status', 'Password has been reset successfully.');
        } else {
            return redirect()->back()->withErrors([
                'authorization' => 'Warning! Wrong Email Or Password'
            ]);
        }

    }
}
