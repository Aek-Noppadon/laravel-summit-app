<?php

namespace App\Livewire\Vendor;

use App\Models\Vendor;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class VendorListsModal extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    // เพิ่มฟังก์ชันนี้เพื่อให้ Search ทำงานไม่เพี้ยน
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('refresh-vendor')]
    public function render()
    {
        // $vendors = Vendor::orderBy('name_english')
        //     ->paginate($this->pagination);

        $vendors = Vendor::query()
            // 1. กำหนด Scope การมองเห็นข้อมูล (เหมือนกันทั้งตอนโหลดปกติ และตอนค้นหา)
            ->where(function ($query) {
                $query->where('source', 0);
            })
            // 2. ถ้ามีการค้นหา ให้เพิ่มเงื่อนไข Like เข้าไป
            ->when(trim($this->search), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name_english', 'like', "%{$search}%");
                });
            })
            ->orderBy('name_english')
            ->paginate($this->pagination);

        return view('livewire.vendor.vendor-lists-modal', compact('vendors'));
    }
}
