<?php

namespace App\Observers;

use App\Models\NcpHeader;

class NcpHeaderObserver
{
    public function creating(NcpHeader $ncpHeader): void
    {
        // Code = NCP-26010001, Id = 1
        $prefix = "NCP-" . now()->format('y') . now()->format('m');

        $ncpHeaders = NcpHeader::withTrashed()->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->get();

        $lastId = count($ncpHeaders);
        $ncpHeaders->ncp_number = $prefix . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    }
}
