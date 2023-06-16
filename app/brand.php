<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{
    protected $table = 'brands';
    protected $fillable = [ 'brandId',
                            'categoryId',
                            'brandName',
                            'brandDescription',
                            'brandStyle',
                            'brandUse',
                            'created_at',
                            'update_at',
                            'deleted_at',
                            ];

    public function item() {
        return $this->hasMany('App\item', 'brandId', 'brandId');
    }
}
