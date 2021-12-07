<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function getAllItems()
    {
        $items = Item::get();
        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addItems(Request $request)
    {
        $user = Auth::user();
        $fields = $request->validate([
            'user_id'=> 'required',
            'name' => 'required|string',
            'price'=> 'required|numeric',
            'itemdescription' => 'required|string',
            'activeInactive' => 'required|string'
        ]);

        $items = Item::create([
            'user_id' => $user->id,
            'name' => $fields['name'],
            'price' => $fields['price'],
            'itemdescription' => $fields['itemdescription'],
            'activeInactive' => $fields['activeInactive'],
        ]);

        return response($items, 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function updateItem(Request $request, $id)
    {
        if(Item::where('id', $id)->exists()){
            
        $updatingItem = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'phone' => 'required|numeric',
            'password' => 'required|max:255',
        ]);
        $item = Item::whereId($id)->update($updatingItem);
            
        // $item = Item::find($id);
        // $item->name = $request->input('name');
        // $item->price = $request->input('price');
        // $item->itemdescription = $request->input('itemdescription');
        // $item->activeInactive = $request->input('activeInactive');            
        // $item->update();

        return response()->json([
            'item' => $item,
            'message' => 'Item Updated Successfully'
        ], 200);
        } else{
            return response()->json([
                "message" => 'Item not found'
            ], 404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function removeItem(Item $item, $id)
    {
        $item = Item::find($id);
        $item->delete();

        return response()->json('Item has been deleted');
    }
}
