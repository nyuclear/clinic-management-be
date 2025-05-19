<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'alias';
    public $incrementing = false; // nếu không phải số tự tăng
    protected $keyType = 'string'; // nếu là string

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'user_id', 'role_alias');
    }
}
