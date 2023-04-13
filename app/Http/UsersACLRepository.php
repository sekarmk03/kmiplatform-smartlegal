<?php

namespace App\Http;
use Illuminate\Support\Facades\Auth;
use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use App\Models\ModuleModel as Modules;

class UsersACLRepository implements ACLRepository{
    public function getUserID()
    {
        return Auth::id();
    }
    public function getRules(): array
    {
        if (Auth::user()->intLevel_ID === 1) {
            return [
                ['disk' => 'modules', 'path' => '*', 'access' => 2],
            ];
        } else {
            $result = [
                ['disk' => 'modules', 'path' => '/', 'access' => 2]
            ];
            $var = Modules::whereHas('user', function($query){
                $query->where('intDepartment_ID', Auth::user()->intDepartment_ID);
            })->get();
            foreach ($var as $key => $val) {
                for ($i=0; $i < 2; $i++) {
                    $result[] = [
                        'disk' => 'modules',
                        'path' => ($i == 0?$val->txtModuleName:$val->txtModuleName.'/*'),
                        'access' => 2
                    ];
                }
            }
            return $result;
        }
        
    }
}