<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table = 'categories';
    protected $fillable = [ 'categoryId',
                            'departmentId',
                            'categoryName',
                            'categoryDescription',
                            'categoryStyle',
                            'categoryUse',
                            'categoryIsDeleted',
                            'created_at',
                            'update_at'
                            ];

    public function item() {
        return $this->hasMany('App\item', 'categoryId', 'categoryId');
    }
}
