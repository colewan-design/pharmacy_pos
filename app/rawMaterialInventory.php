<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rawMaterialInventory extends Model
{
    protected $table = 'raw_material_inventories';
    protected $fillable = [
        'raw_materials_id', 
        'batchCode',
        'originalPortions',
        'expiryDate',
        'value'
    ];
    
    public function rawMaterial() {
        return $this->belongsTo('rawMaterials');
    }
}
