<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'code',
        'name_english',
        'name_thai',
        'source',
        'created_user_id',
        'updated_user_id',
        'created_at',
        'updated_at',
    ];

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
}
