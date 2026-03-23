<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventiveAction extends Model
{
    public $fillable = [
        'name',
        'created_user_id',
        'updated_user_id',
    ];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
