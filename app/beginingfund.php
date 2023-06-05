<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class beginingfund extends Model
{
    protected $fillable = [ 'beginingfundId',
                            'beginingfundUserId',
                            'beginingAmount',
                            'created_at',
                            'update_at'
                            ];
}
