<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FoundActivity extends Model
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

    protected function name(): Attribute
    {
        /**
         * จัดการข้อมูล name อัตโนมัติก่อนเข้า Database
         */
        return Attribute::make(
            // ตอนดึงข้อมูลออกมา (Accessor) - ถ้าอยากให้พิมพ์ใหญ่ตอนโชว์ด้วย
            get: fn(string $value) => ucwords($value),

            // ตอนเซตข้อมูล (Mutator) - หัวใจสำคัญที่คุณต้องการ
            set: fn(string $value) => ucwords(trim($value)),
        );
    }
}
