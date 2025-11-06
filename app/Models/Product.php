<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'product_name',
        'brand',
        'supplier_rep',
        'principal',
        'status',
        'source',
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
