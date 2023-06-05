<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class itemRawMaterial extends Model
{
    use SoftDeletes;
    protected $table = 'item_raw_materials';
    protected $fillable = [
        'items_id',
        'raw_materials_id',
        'portionConsumed'
    ];

    public function rawMaterial() {
        return $this->hasMany('App\rawMaterials', 'id', 'raw_materials_id');
    }
}
