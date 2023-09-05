<?php

namespace Modules\Smartlegal\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Model
{
    use HasFactory;
    protected $connection = 'smartlegal';
    protected $table = 'muserroles';

    const CREATED_AT = 'dtmCreatedAt';
    const UPDATED_AT = 'dtmUpdatedAt';
    protected $primaryKey = 'intUserRoleID';
    protected $fillable = ['intUserID', 'intRoleID', 'txtCreatedBy'];
    
    public function users() {
        return $this->belongsTo(User::class, 'intUserID', 'id');
    }

    public function roles() {
        return $this->belongsTo(Role::class, 'intRoleID', 'intRoleID');
    }

    public static function rules() {
        return [
            'intUserID' => 'required',
            'intRoleID' => 'required',
            'txtCreatedBy' => 'string'
        ];
    }

    public static function attributes() {
        return [
            'intUserID' => 'User',
            'intRoleID' => 'Role',
            'txtCreatedBy' => 'CreatedBy'
        ];
    }
}
