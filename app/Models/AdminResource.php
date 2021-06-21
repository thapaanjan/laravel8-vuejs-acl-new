<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminResource extends Model
{
    use HasFactory;

    protected $table = 'admin_resource';
    protected $fillable = [
        'resource_id', 'admin_id'
    ];

    public function admin_resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id');
    }

}
