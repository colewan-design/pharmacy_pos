<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = 'items';
    protected $fillable = [ 'itemId',
                            'categoryId',
                            'itemName',
                            'itemDescription',
                            'itemQty',
                            'itemPrice',
                            'itemUse',
                            'created_at',
                            'update_at'
                          ];

    public function category() {
        return $this->belongsTo('App\category', 'categoryId', 'categoryId');
    }

    public function inventory() {
        return $this->hasMany('App\inventory', 'inventoryId');
    }

    public function itemRawMaterial() {
        return $this->hasMany('App\itemRawMaterial', 'items_id', 'itemId');
    }
}
