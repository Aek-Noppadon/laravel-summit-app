<?php

namespace App\Models;

use App\Enums\ConnectionSRVEnum;
use Illuminate\Database\Eloquent\Model;

class SrvProduct extends Model
{
    protected $connection = ConnectionSRVEnum::SRV2;
    protected $table = "SCC_CRM_PRODUCTS_NEW";
}
