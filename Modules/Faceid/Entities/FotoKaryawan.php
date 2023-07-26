<?php

namespace Modules\Faceid\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoKaryawan extends Model
{
    use HasFactory;
    protected $connection = 'faceid';
    protected $table = 'foto_karyawans';

    protected $guarded = [];

    protected static function newFactory()
    {

        // return \Modules\Faceid\Database\factories\FotoKaryawanFactory::new();
    }
}
