<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function nameEnglish(): Attribute
    {
        /**
         * จัดการข้อมูล name_english อัตโนมัติก่อนเข้า Database
         */
        return Attribute::make(
            // ตอนดึงข้อมูลออกมา (Accessor) - ถ้าอยากให้พิมพ์ใหญ่ตอนโชว์ด้วย
            get: fn(string $value) => strtoupper($value),

            // ตอนเซตข้อมูล (Mutator) - หัวใจสำคัญที่คุณต้องการ
            set: fn(string $value) => strtoupper(trim($value)),
        );
    }

    protected function nameThai(): Attribute
    {
        /**
         * จัดการข้อมูล name_thai อัตโนมัติก่อนเข้า Database
         */
        return Attribute::make(
            // ตอนเซตข้อมูล (Mutator) - หัวใจสำคัญที่คุณต้องการ
            set: fn(string $value) => trim($value),
        );
    }

    protected function parentCode(): Attribute
    {
        /**
         * จัดการข้อมูล name_thai อัตโนมัติก่อนเข้า Database
         */
        return Attribute::make(
            // ตอนเซตข้อมูล (Mutator) - หัวใจสำคัญที่คุณต้องการ
            set: fn(string $value) => trim($value),
        );
    }

    protected function parentName(): Attribute
    {
        /**
         * จัดการข้อมูล name_thai อัตโนมัติก่อนเข้า Database
         */
        return Attribute::make(
            // ตอนเซตข้อมูล (Mutator) - หัวใจสำคัญที่คุณต้องการ
            set: fn(string $value) => trim($value),
        );
    }
}
