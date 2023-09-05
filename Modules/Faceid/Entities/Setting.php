<?php

namespace Modules\Faceid\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;
    protected $connection = 'faceid';
    protected $table = 'settings';

    protected $fillable = ['limit'];

    protected static function newFactory()
    {
        return \Modules\Faceid\Database\factories\SettingFactory::new();
    }
}
