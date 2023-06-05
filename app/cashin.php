<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cashin extends Model
{
    protected $fillable = [ 'cashInId',
                            'cashinUserId',
                            'giveBy',
                            'amount',
                            'note',
                            'created_at',
                            'update_at'
                            ];
}
