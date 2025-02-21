<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\Art;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart($id)
    {
        $user = Auth::user();
        $art = Art::find($id);

        if($art == null) {
            abort(404,"Art not found");
        }

        if($user->Carts->count() > 0) {
            $prevCartUserId = $user->Carts[0]->Art->USER_ID;
            if($prevCartUserId != $art->USER_ID) {
                return redirect()->back()->withErrors(['You cannot add arts from different artist to the cart']);
            }
        }

        if(Cart::where('ART_ID','=',$id)->count() > 0)
        {
            return redirect()->back()->with('status','Artwork already in cart');
        }
        else{
            $user->Carts()->create([
                'ART_ID' => $art->ART_ID
            ]);

            return redirect()->back()->with('status','Artwork has been added to cart');
        }

    }

    public function removeFromCart($id)
    {
        $cart = Cart::find($id);

        if($cart == null) {
            abort(404,"Cart data not found");
        }

        $cart->delete();

        return redirect()->back()->with('status','Artwork has been removed from cart');
    }
}
