<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function checkBeforeCheckout()
    {
        $user = null;

        if (Auth::user() != null)
        {
            $user = Auth::User();
        }

        $usercarts = $user->Carts;
        $total = $usercarts->count();

        foreach($usercarts as $cart) {
            if($cart->Art->isInStock() == false) {
                $cart->delete();
                $total -= 1;
            }
        }

        if($total > 0) {
            return redirect()->route('order.my');
        } else {
            return redirect()->back()->withErrors(['message'=>'Nothing to checkout']);
        }
    }

    public function index()
    {
        $user = null;

        if (Auth::user() != null)
        {
            $user = Auth::User();
        }

        // $order = Order::where('USER_ID',$user->USER_ID)->latest('created_at')->first();

        $carts = $user->Carts;

        // dd($carts);

        $activeAddress = Address::where('USER_ID',$user->USER_ID)->where('IS_ACTIVE',1)->first();

        return view('layouts.checkout', compact('carts','activeAddress'));
    }

    public function checkout()
    {
        $user = Auth::User();

        // dd($user->Carts->first());
        $activeAddress = Address::where('USER_ID',$user->USER_ID)->where('IS_ACTIVE',1)->first();

        if($activeAddress == null) {
            return redirect()->back()->withErrors(['message'=>'No active address']);
        }

        $carts = $user->Carts;

        if($carts->count() <= 0) {
            return redirect()->back()->withErrors(['message'=>'Nothing to checkout']);
        }

        $order = Order::where('USER_ID', $user->USER_ID)->orderBy('created_at', 'DESC')->first();

        $order = $user->Orders()->create([
            'FULLNAME' => $activeAddress->FULLNAME,
            'PHONE' => $activeAddress->PHONE,
            'ADDRESS' => $activeAddress->ADDRESS,
            'PROVINCE' => $activeAddress->PROVINCE,
            'CITY' => $activeAddress->CITY,
            'POSTAL_CODE' => $activeAddress->POSTAL_CODE,
            'STATUS' => 2
        ]);

        // if($order == null) {
            
        // } else {
        //     if ($order->STATUS != 1) {
        //         $order = $user->Orders()->create([
        //             'FULLNAME' => $activeAddress->FULLNAME,
        //             'PHONE' => $activeAddress->PHONE,
        //             'ADDRESS' => $activeAddress->ADDRESS,
        //             'PROVINCE' => $activeAddress->PROVINCE,
        //             'CITY' => $activeAddress->CITY,
        //             'POSTAL_CODE' => $activeAddress->POSTAL_CODE,
        //         ]);
        //     }
        // }

        if (count($carts) > 0) {
            foreach ($carts as $cart) {
                $order->OrderItems()->create([
                    'ART_ID' => $cart->ART_ID,
                    'QUANTITY' => $cart->QUANTITY,
                    'PRICE_PER_ITEM' => $cart->Art->PRICE,
                ]);

                $cart->delete();
            }
        }

        return redirect()->route('order.summary',['id'=>$order->ORDER_ID]);
    }

    public function show($id)
    {
        $user = Auth::user();
        $order = Order::find($id);

        if($order == null) {
            return redirect()->route('landing')->withErrors(['message'=>'Order not found']);
        }

        if($order->USER_ID != $user->USER_ID) {
            return redirect()->route('landing')->withErrors(['message'=>'Order not belonge to you']);
        }

        return view('layouts.order-summary', compact('order'));
    }

    public function history()
    {
        $user = Auth::user();
        $orders = Order::where('USER_ID',$user->USER_ID)->orderBy('created_at','DESC')->get();

        return view('profile.order-history', compact('user','orders'));
    }

    public function artistOrder()
    {
        $user = Auth::user();
        $userId = $user->USER_ID;
        $orders = Order::whereHas('OrderItems', function ($query) use ($userId) {
            $query->whereHas('Art', function ($query) use ($userId) {
                $query->where('USER_ID', $userId);
            });
        })->get();

        // dd($orders);

        $orderItems = OrderItem::whereHas('Art', function ($query) use ($userId) {
            $query->where('USER_ID', $userId);
        })->get();

        // dd($orderItems);

        return view('profile.update-order', compact('orderItems','orders'));
    }

    public function updateStatusOrder($id, Request $request)
    {
        $user = Auth::user();
        $userId = $user->USER_ID;

        $order = Order::find($id);

        if($order == null) {
            return redirect()->back()->withErrors(['message'=>'Order data not found']);
        }

        if($order->OrderItems->first()->Art->USER_ID != $userId) {
            return redirect()->back()->withErrors(['message'=>'Order data is not yours']);
        }

        $validator = Validator::make($request->all(), [
            'STATUS' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->all());
        }

        $order->STATUS = $request->STATUS;
        $order->save();

        $order = Order::find($id);

        return redirect()->back()->with('status','Order #'.$order->ORDER_ID.' status has been updated to '.$order->status_text);
    }
}
