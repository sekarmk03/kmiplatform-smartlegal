<?php

namespace Modules\ROIS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LevelMenu extends Model
{
    protected $connection = 'rois';
    protected $table = 'level_has_menu';

    protected $fillable = ['intLevel_ID', 'intMenu_ID'];

    public function menu(){
        return $this->hasMany('Modules\ROIS\Entities\Menu', 'intMenu_ID');
    }
}
