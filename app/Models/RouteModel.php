<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteModel extends Model
{
    use HasFactory;
    const CREATED_AT = 'dtmCreated';
    const UPDATED_AT = 'dtmUpdated';
    protected $table = 'trroutes';
    protected $primaryKey = 'intRoute_ID';
    protected $fillable = [
        'intSubmenu_ID', 'txtRouteTitle', 'txtRouteName'
    ];

    public function submenus()
    {
        return $this->belongsTo('App\Models\SubmenuModel', 'intSubmenu_ID');
    }
}
