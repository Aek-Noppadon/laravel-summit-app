<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NcpHeader extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ncp_number',
        'source_type',
        'customer_id',
        'found_activity_id',
        'preventive_action_id',
        'report_user_id',
        'to_user_id',
        'authorize_user_id',
        'excute_user_id',
        'problem',
        'corrective_action',
        'result',
        'report_date',
        'authorize_date',
        'excute_date',
    ];
}
