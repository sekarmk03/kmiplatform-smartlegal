<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class LevelAccess {
    
    public static function canAccess($title) {
        $path = request()->path();
        $access = DB::table('trroutes AS route')
            ->selectRaw("route.intRoute_ID, msub.intSubmenu_ID, msub.txtSubmenuTitle, route.txtRouteName,
            route.txtRouteTitle, tla.intAccessible")
            ->join('msubmenus AS msub', 'msub.intSubmenu_ID', '=', 'route.intSubmenu_ID')
            ->join('trlevel_access AS tla', 'tla.intRoute_ID', '=', 'route.intRoute_ID')
            ->where([
                'msub.txtUrl' => $path,
                'tla.intLevel_ID' => Auth::user()->intLevel_ID,
                'route.txtRouteTitle' => $title
            ])
            ->first();
        return $access;
    }

    public static function authorize($route, $level)
    {
        $access = DB::table('trroutes AS route')
            ->selectRaw("route.intRoute_ID, msub.txtSubmenuTitle, route.txtRouteName,
            route.txtRouteTitle, tla.intAccessible")
            ->join('msubmenus AS msub', 'msub.intSubmenu_ID', '=', 'route.intSubmenu_ID')
            ->join('trlevel_access AS tla', 'tla.intRoute_ID', '=', 'route.intRoute_ID')
            ->where([
                    'route.txtRouteName' => $route,
                    'tla.intLevel_ID' => $level
                ])
            ->first();
        if (!empty($access)) {
            if ($access->intAccessible <> 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public static function btnAction($ID)
    {
        $btn_edit = '<button onclick="edit('.$ID.')" class="btn btn-sm btn-success"><i class="fas fa-pencil"></i></button>';
        $btn_delete = '<button onclick="destroy('.$ID.')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';

        switch (true) {
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_edit.' '.$btn_delete;
                break;
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible != 1):
                return $btn_edit;
                break;
            case (self::canAccess('edit')->intAccessible != 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_delete;
                break;
            
            default:
                return 'Unavailable';
                break;
        }
    }

    public static function btnLevelAction($ID)
    {
        $btn_access = '<button onclick="access('.$ID.')" class="btn btn-sm btn-info"><i class="fa-solid fa-list-check"></i></button>';
        $btn_edit = '<button onclick="edit('.$ID.')" class="btn btn-sm btn-success"><i class="fas fa-pencil"></i></button>';
        $btn_delete = '<button onclick="destroy('.$ID.')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';

        switch (true) {
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible == 1 && self::canAccess('access')->intAccessible == 1):
                return $btn_access.' '.$btn_edit.' '.$btn_delete;
                break;
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_edit.' '.$btn_delete;
                break;
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible != 1):
                return $btn_edit;
                break;
            case (self::canAccess('edit')->intAccessible != 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_delete;
                break;
            default:
                return 'Unavailable';
                break;
        }
    }

    public static function btnDatabaseAction($ID)
    {
        $btn_db = '<a href="'.route('manage.database.index', openssl_encrypt($ID, "AES-128-CTR", "Standardization", 0, '1234567891011121')).'" class="btn btn-sm btn-info"><i class="fa-solid fa-database"></i></a>';
        $btn_edit = '<button onclick="edit('.$ID.')" class="btn btn-sm btn-success"><i class="fas fa-pencil"></i></button>';
        $btn_delete = '<button onclick="destroy('.$ID.')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';

        switch (true) {
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_db.' '.$btn_edit.' '.$btn_delete;
                break;
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible != 1):
                return $btn_db.' '.$btn_edit;
                break;
            case (self::canAccess('edit')->intAccessible != 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_db.' '.$btn_delete;
                break;
            
            default:
                return $btn_db;
                break;
        }
    }

    public static function btnUsersAction($ID)
    {
        $btn_access = '<button onclick="resetPassword('.$ID.')" class="btn btn-sm btn-warning"><i class="fa-solid fa-key"></i></button>';
        $btn_edit = '<button onclick="edit('.$ID.')" class="btn btn-sm btn-success"><i class="fas fa-pencil"></i></button>';
        $btn_delete = '<button onclick="destroy('.$ID.')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>';

        switch (true) {
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible == 1 && self::canAccess('reset')->intAccessible == 1):
                return $btn_access.' '.$btn_edit.' '.$btn_delete;
                break;
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_edit.' '.$btn_delete;
                break;
            case (self::canAccess('edit')->intAccessible == 1 && self::canAccess('delete')->intAccessible != 1):
                return $btn_edit;
                break;
            case (self::canAccess('edit')->intAccessible != 1 && self::canAccess('delete')->intAccessible == 1):
                return $btn_delete;
                break;
            default:
                return 'Unavailable';
                break;
        }
    }

    public static function createBtn()
    {
        $btn = '';
        if (self::canAccess('create')->intAccessible == 1) {
            $btn = '<button onclick="create()" class="btn btn-sm btn-primary float-end"><i class="fas fa-plus"></i> New Data</button>';
        }
        return $btn;
    }
}