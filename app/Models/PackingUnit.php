<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingUnit extends Model
{
    protected $fillable = [
        'name',
        'created_user_id',
        'updated_user_id',
    ];
}
