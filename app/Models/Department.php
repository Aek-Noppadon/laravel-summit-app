<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'created_user_id',
        'updated_user_id',
    ];

    // public function departmentUser()
    // {
    //     return $this->hasMany(User::class, 'department_id');
    // }
}
