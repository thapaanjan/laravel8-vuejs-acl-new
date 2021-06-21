<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    use HasFactory;
    protected $table = "admin_permission";
    protected $fillable = [
        'permission_id', 'admin_id'
    ];
    public function admin_permissions()
    {
        return $this->belongsToMany(Admin::class,'admin_permission');
    }
}
