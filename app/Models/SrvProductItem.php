<?php

namespace App\Models;

use App\Enums\ConnectionSRVEnum;
use Illuminate\Database\Eloquent\Model;

class SrvProductItem extends Model
{
    protected $connection = ConnectionSRVEnum::SRV2;
    protected $table = "QS3SCCPRODUCTVIEW";
}
