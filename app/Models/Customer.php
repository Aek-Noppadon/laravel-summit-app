<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'code',
        'name_thai',
        'name_english',
        'parent_code',
        'parent_name',
        'source',
        'created_user_id',
        'updated_user_id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Created by Sun 20/10/2025
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    // Created by Sun 20/10/2025
    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
