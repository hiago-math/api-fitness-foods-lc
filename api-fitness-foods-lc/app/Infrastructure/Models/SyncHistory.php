<?php

namespace Infrastructure\Models;

use Jenssegers\Mongodb\Eloquent\Model as ModelMongo;

class SyncHistory extends ModelMongo
{
    protected $connection = 'mongodb';

    protected $guarded = ['created_at', 'updated_at'];
    protected $collection = 'sync_history';

    protected $fillable = [
        'hash',
        'filename',
        'status',
        'sync_at'
    ];
}
