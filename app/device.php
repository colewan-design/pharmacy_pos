<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    protected $fillable = [ 'deviceId',
                            'departmentId',
                            'deviceName',
                            'deviceDescription',
                            'deviceUse',
                            'deviceIsDeleted',
                            'created_at',
                            'update_at'
                          ];
}
