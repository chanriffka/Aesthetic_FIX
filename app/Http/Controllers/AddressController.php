<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->Addresses;

        return view('layouts.choose-address', compact('addresses'));
    }

    public function add()
    {
        return view('layouts.new-address');
    }

    public function edit($addressId)
    {
        $address = Address::find($addressId);

        return view('layouts.edit-address', compact('address'));
    }

    public function store(Request $request) {
        $user = Auth::user();

        $validated = Validator::make($request->all(), [
            'FULLNAME' => 'required',
            'PHONE' => 'required',
            'ADDRESS' => 'required',
            'PROVINCE' => 'required',
            'CITY' => 'required',
            'POSTAL_CODE' => 'required',
        ]);

        if($user->Addresses()->count() == 0) {
            $request['IS_ACTIVE'] = 1;
        } else {
            $request['IS_ACTIVE'] = 0;
        }

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $user->Addresses()->create($request->all());

        return redirect()->route('order.address.show')->with('status','New address has been added!');
    }

    public function update(Request $request,$addressId) {
        $user = Auth::user();
        $address = Address::find($addressId);

        $validated = Validator::make($request->all(), [
            'FULLNAME' => 'required',
            'PHONE' => 'required',
            'ADDRESS' => 'required',
            'PROVINCE' => 'required',
            'CITY' => 'required',
            'POSTAL_CODE' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withError($validated->error());
        }

        $address->FULLNAME = $request->FULLNAME;
        $address->PHONE = $request->PHONE;
        $address->ADDRESS = $request->ADDRESS;
        $address->PROVINCE = $request->PROVINCE;
        $address->CITY = $request->CITY;
        $address->POSTAL_CODE = $request->POSTAL_CODE;
        $address->save();

        return redirect()->route('order.address.show')->with('status','New address has been added!');
    }

    public function active($id)
    {
        $user = Auth::user();
        $addresses = $user->Addresses;

        foreach($addresses as $address) {
            $address['IS_ACTIVE'] = 0;
            $address->save();
        }

        $address = Address::find($id);
        $address['IS_ACTIVE'] = 1;
        $address->save();

        if($address->USER_ID != $user->USER_ID) {
            return redirect()->back()->withError('status','Address not yours');
        }

        return redirect()->route('order.my')->with('status','Active address has been setted up!');
    }

    public function destroy($id) {
        $user = Auth::user();
        $address = Address::find($id);

        // dd($address->USER_ID);

        if($address->USER_ID != $user->USER_ID) {
            return redirect()->back()->withError('status','Address not yours');
        }

        $address->delete();

        return redirect()->back()->with('status','Address has been deleted!');
    }
}
