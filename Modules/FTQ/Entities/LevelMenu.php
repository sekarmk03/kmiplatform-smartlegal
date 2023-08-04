<?php

namespace Modules\FTQ\Entities;

use Illuminate\Database\Eloquent\Model;

class LevelMenu extends Model
{
    protected $connection = 'ftq';
    protected $table = 'level_has_menu';

    protected $fillable = ['intLevel_ID', 'intMenu_ID'];

    public function menu(){
        return $this->hasMany('Modules\FTQ\Entities\Menu', 'intMenu_ID');
    }
}
