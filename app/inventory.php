<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    protected $table = 'inventories';
    protected $fillable = [
        'itemId',
        'dateEncoded',
        'batchCode',
        'originalQty',
        'currentQty',
        'expiryDate'
    ];

    public function item() {
        return $this->belongsTo('App\item', 'itemId', 'itemId');
    }
}
