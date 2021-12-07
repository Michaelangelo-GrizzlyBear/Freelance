<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\PackageItem;
use Illuminate\Support\Facades\DB;

class PackageItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPackageItems()
    {
        // $packageitems = PackageItem::get();
        
        $packageitems = DB::table('packageitems')
        ->select(
            'items.name',
            'packageitems.price',
        )
        ->join('items', 'items.id', '=', 'packageitems.item_id')
        ->where('items.activeInactive', '=', 'Active')
        ->get();

        return response()->json($packageitems);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addPackageItem(Request $request)
{
        $user = Auth::user();
        $item = Item::arrayPackageItemSelect();

        $fields = $request->validate([
            'user_id' => 'required',
            'item_id' => 'required',
            'price' => 'required|numeric'
        ]);

        
         $package = PackageItem::create([
            'user_id' => $user->id,
            'item_id' =>  $fields['item_id'],
            'price'=> $fields['price']
        ]);

        return response()->json($package, 201);
        
    }
    /**1
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PackageItem  $packageItem
     * @return \Illuminate\Http\Response
     */
    public function updatePackageItem(Request $request, $id)
    {

        if(PackageItem::where('id', $id)->exists()){
            $packageitem = PackageItem::find($id);

            $packageitem->item_id = $request->input('item_id');
            $packageitem->price = $request->input('price');
            $packageitem->update();

            return response()->json([
                'PackageItem' => $packageitem,
                'message' => 'Package Item Updated Successfully'
            ], 200);
        }else{
            return response()->json([
                "message" => 'Package Item not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackageItem  $packageItem
     * @return \Illuminate\Http\Response
     */
    public function removePackageItem(PackageItem $packageItem, $id)
    {
        $packageitem = PackageItem::find($id);
        $packageitem->delete();

        return response()->json('Package Item has been deleted!');

    }
}
