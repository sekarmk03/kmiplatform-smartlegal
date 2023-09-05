<?php

namespace Modules\Faceid\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;
    protected $connection = 'faceid';
    protected $table = 'devices';

    protected $guarded = [];

    protected static function newFactory()
    {
        // return \Modules\Faceid\Database\factories\DeviceFactory::new();
    }
}
