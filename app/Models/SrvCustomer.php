<?php

namespace App\Models;

use App\Enums\ConnectionSRVEnum;
use Illuminate\Database\Eloquent\Model;

class SrvCustomer extends Model
{
    protected $connection = ConnectionSRVEnum::SRV2;
    protected $table = "SCC_CRM_CUSTOMERS";
}
