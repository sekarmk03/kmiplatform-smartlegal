<?php

namespace Modules\ROonline\Entities;

use Illuminate\Database\Eloquent\Model;

class LevelMenu extends Model
{
    protected $connection = 'roonline';
    protected $table = 'level_has_menu';

    protected $fillable = ['intLevel_ID', 'intMenu_ID'];

    public function menu(){
        return $this->hasMany('Modules\ROonline\Entities\Menu', 'intMenu_ID');
    }
}
