<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'roonline';
    protected $table = 'mst_product';
    protected $primaryKey = 'intProduct_ID';

    protected $fillable = ['txtArtCode', 'txtProductName'];
}
