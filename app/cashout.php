<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cashout extends Model
{
    protected $fillable = [ 'cashOutId',
                            'cashoutUserId',
                            'receiveBy',
                            'amount',
                            'note',
                            'created_at',
                            'update_at'
                            ];
}
