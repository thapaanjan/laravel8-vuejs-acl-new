<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug',
    ];

    // public function admins() {
    //     return $this->belongsToMany(Admin::class,'admin_resource');  
    // }
    public function admins() {
        return $this->belongsToMany(Admin::class,'admin_new_resource');  
    }
}
