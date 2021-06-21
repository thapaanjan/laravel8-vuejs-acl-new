<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $table = 'admins';
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'phone_number','password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function roles() {
        return $this->belongsToMany(Role::class,'admin_role');
    }

    public function resources() {
        return $this->belongsToMany(Resource::class, 'admin_resource');
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class,'admin_permission');
    }
}
