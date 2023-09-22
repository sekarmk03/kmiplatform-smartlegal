<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductModel extends Model
{
    use HasFactory;
    protected $connection = 'rois';
    public $timestamps = false;
    protected $table = 'mst_product';
    protected $primaryKey = 'intProduct_ID';

    protected $fillable = ['txtArtCode', 'txtProductName'];
}
