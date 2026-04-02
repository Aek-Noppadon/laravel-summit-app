<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NcpImage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ncp_id',
        'name',
    ];
}
