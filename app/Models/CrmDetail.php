<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'crm_id',
        // 'product_code',
        // 'product_name',
        // 'product_brand',
        // 'supplier_rep',
        // 'principal',
        'product_id',
        'update_visit',
        'quantity',
        'unit_price',
        'volumn_qty',
        'application_id',
        'sales_state_id',
        'probability_id',
        'total_price',
        'packing_unit_id',
        'volumn_unit_id',
        'additional',
        'competitor',
        'created_user_id',
        'updated_user_id',
    ];
}
