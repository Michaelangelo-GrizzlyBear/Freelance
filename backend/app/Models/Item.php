<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'itemdescription',
        'activeInactive'
    ];

    public function packageitems()
    {
    	return $this->hasMany(PackageItem::class);
    }

    public static function arrayPackageItemSelect()
    {
        $arr = [];
        $items = Item::all();
        foreach($items as $item){
            $arr[$item->id] = $item->name;
        }

        return $arr;
    }

}
