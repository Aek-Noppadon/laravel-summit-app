<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = [
        'code',
        'name',
        'brand_code',
        'brand_name',
        'group_code',
        'group_name',
        'subgroup_code',
        'subgroup_name',
        'supplier_rep',
        'principal_code',
        'principal_name',
        'status',
        'source',
        'unit_price',
        'created_user_id',
        'updated_user_id',
    ];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function userUpdated()
    {
        // return $this->belongsTo(User::class, 'updated_user_id');

        // ใส่ withDefault() เพื่อให้มันคืนค่า Object เปล่าๆ ออกมาแทน null
        return $this->belongsTo(User::class, 'updated_user_id')->withDefault([
            'name' => 'N/A'
        ]);
    }
}
