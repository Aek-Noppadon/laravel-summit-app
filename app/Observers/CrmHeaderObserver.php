<?php

namespace App\Observers;

use App\Models\CrmHeader;

class CrmHeaderObserver
{
    /**
     * Handle the CrmHeader "created" event.
     */
    public function created(CrmHeader $crmHeader): void
    {
        // 
    }

    public function creating(CrmHeader $crmHeader): void
    {

        // 1. use SoftDeleted on model 
        //2. edit migration file

        // Code = CRM-2500001
        // ID = 1
        $prefix = "CRM-" . now()->format('y') . now()->format('m');

        // $members = CrmHeader::withTrashed()
        $crmHeaders = CrmHeader::withTrashed()->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->get();

        $lastId = count($crmHeaders);
        $crmHeader->document_no = $prefix . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Handle the CrmHeader "updated" event.
     */
    public function updated(CrmHeader $crmHeader): void
    {
        //
    }

    /**
     * Handle the CrmHeader "deleted" event.
     */
    public function deleted(CrmHeader $crmHeader): void
    {
        //
    }

    /**
     * Handle the CrmHeader "restored" event.
     */
    public function restored(CrmHeader $crmHeader): void
    {
        //
    }

    /**
     * Handle the CrmHeader "force deleted" event.
     */
    public function forceDeleted(CrmHeader $crmHeader): void
    {
        //
    }
}
