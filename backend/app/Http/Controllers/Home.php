<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Validator;

class Home extends Controller
{

    public function allAddress()
    {    
        $address = Address::where(['user_id'=> Auth::user()->id])->get();
        return response()->json([
          'All of my Address' => $address
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addAddress(Request $request)
    {
        $user = Auth::user();
        $fields = $request->validate([
            'user_id' => 'required',
            'houseNo' => 'required|numeric',
            'street' => 'required|string',
            'barangay'=>'required|string',
            'region'=>'required|string',
            'city'=>'required|string',
            'zipCode'=>'required|numeric',
        ]);

        $address = Address::create([
            'user_id' =>  $user->id,
            'houseNo' => $fields['houseNo'],
            'street' => $fields['street'],
            'barangay'=> $fields['barangay'],
            'region'=> $fields['region'],
            'city'=> $fields['city'],
            'zipCode'=>$fields['zipCode'],
        ]);

        return response($address, 201);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAddress(Request $request, $id)
    {
        if (Address::where('id', $id)->exists()) {
            $address = Address::find($id);
    
            // $address->houseNo = is_null($request->houseNo) ? $address->houseNo : $address->houseNo;
            // $address->street = is_null($request->street) ? $address->street : $address->street;
            // $address->barangay = is_null($request->barangay) ? $address->barangay : $address->barangay;
            // $address->region = is_null($request->region) ? $address->region : $address->region;
            // $address->city = is_null($request->city) ? $address->city : $address->city;
            // $address->zipCode = is_null($request->zipCode) ? $address->zipCode : $address->zipCode;
            // $address->save();

            $address->houseNo = $request->input('houseNo');
            $address->street = $request->input('street');
            $address->barangay = $request->input('barangay');
            $address->region = $request->input('region');
            $address->city = $request->input('city');
            $address->zipCode = $request->input('zipCode');
            $address->update(); 
    
            // $address->update($request->all());

            return response()->json([
            "address" => $address, 
              "message" => "Address Updated successfully"
            ], 200);

          } else {
            return response()->json([
              "message" => "Address not found"
            ], 404);
          }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeAddress($id)
    {
        $address = Address::find($id);
        $address->delete();

        return response()->json('The Address has been deleted');
    }
}
