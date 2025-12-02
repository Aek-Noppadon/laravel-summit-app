<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'crm_id',
        'product_id',
        'update_visit',
        'quantity',
        'unit_price',
        'volume_qty',
        'application_id',
        'sales_stage_id',
        'probability_id',
        'total_price',
        'packing_unit_id',
        'volume_unit_id',
        'additional',
        'competitor',
        'created_user_id',
        'updated_user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function salesStage()
    {
        return $this->belongsTo(SalesStage::class, 'sales_stage_id');
    }
}
