<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{

    protected $fillable = [
        'user_id',
        'item_id',
        'price'
    ];

    protected $table='packageitems';

    public  function itemModel()
    {
    	return $this->belongsTo(Item::class);
    }

}
