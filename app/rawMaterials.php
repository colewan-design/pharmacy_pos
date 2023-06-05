<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class rawMaterials extends Model
{
    use SoftDeletes;
    protected $table = 'raw_materials';
    protected $fillable = ['material', 'portions'];

    public function rawMaterialInventory() {
        return $this->hasMany('App\rawMaterialInventory', 'raw_materials_id', 'id');
    }

}
