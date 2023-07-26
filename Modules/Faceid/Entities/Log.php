<?php

namespace Modules\Faceid\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
    protected $connection = 'faceid';
    protected $table = 'logs';

    protected $guarded = [];

    protected static function newFactory()
    {
        // return \Modules\Faceid\Database\factories\LogFactory::new();
    }
}
