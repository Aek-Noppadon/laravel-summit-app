<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NcpItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ncp_id',
        'product_id',
        'to_wh',
        'batch_no',
        'quantity',
        'ref_document_no',
        'ref_invoice_no',
        'remark',
    ];
}
