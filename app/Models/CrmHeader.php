<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmHeader extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'document_no',
        'started_visit_date',
        'estimate_date',
        'original_estimate_date',
        'customer_type_id',
        'customer_group_id',
        'event_id',
        'contact',
        'purpose',
        'detail',
        'opportunity',
        'source',
        'created_user_id',
        'updated_user_id',
    ];

    public function userCreated()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function crm_items()
    {
        return $this->hasMany(CrmDetail::class, 'crm_id');
    }

    public function crm_items_deleted()
    {
        return $this->hasMany(CrmDetail::class, 'crm_id')->withTrashed();
    }

    public function customer_type()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type_id');
    }
}
