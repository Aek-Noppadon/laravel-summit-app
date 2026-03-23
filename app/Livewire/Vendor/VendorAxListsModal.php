<?php

namespace App\Livewire\Vendor;

use App\Models\SrvVendor;
use App\Models\Vendor;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class VendorAxListsModal extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;
    public $source = 0;

    #[On('refresh-vendor-ax')]
    public function render()
    {
        $vendors = SrvVendor::select('ACCOUNTNUM', 'NAME')
            ->where('DATAAREAID', 'scc')
            ->where('BLOCKED', 0)
            ->when(trim($this->search), function ($query, $search) {
                // ใช้ function ($q) ครอบเพื่อให้ orWhere อยู่ในวงเล็บเดียวกัน
                $query->where(function ($q) use ($search) {
                    $q->where('ACCOUNTNUM', 'like', "%{$search}%")
                        ->orWhere('NAME', 'like', "%{$search}%");
                });
            })
            ->orderBy('NAME')
            ->paginate($this->pagination);

        return view('livewire.vendor.vendor-ax-lists-modal', compact('vendors'));
    }

    #[On('save-vendor-ax')]
    public function saveVendorAx($id)
    {
        $vendorAx = SrvVendor::select('ACCOUNTNUM', 'NAME')
            ->where('ACCOUNTNUM', $id)
            ->firstOrFail(); // ใช้ firstOrFail เพื่อกันกรณีไม่พบข้อมูลใน AX

        // ค้นหาหรือสร้าง Instance ใหม่
        $vendor = Vendor::firstOrNew(['code' => $id]);

        $vendor->fill([
            'name_english'    => strtoupper(trim($vendorAx->NAME)),
            'source'          => $this->source,
            'updated_user_id' => auth()->id(),
        ]);

        // ถ้าเป็น Record ใหม่ ให้ใส่ created_user_id ด้วย
        if (!$vendor->exists) {
            $vendor->created_user_id = auth()->id();
        }

        // ตรวจสอบว่ามีการเปลี่ยนแปลงข้อมูลหรือไม่ (รวมถึงกรณีสร้างใหม่ด้วย)
        if ($vendor->isDirty()) {
            $isNew = !$vendor->exists;
            $vendor->save();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: $isNew ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Vendor : " . $vendor->name_english,
                icon: "success",
                timer: 3000,
            );

            $this->dispatch('close-modal-vendor');
        }
    }

    /*
    #[On('save-vendor-ax')]
    public function saveVendorAx($id)
    {
        $vendorAx = SrvVendor::select('ACCOUNTNUM', 'NAME')
            ->where('ACCOUNTNUM', $id)
            ->first();

        $vendor = Vendor::where('code', $id)->first();

        if (is_null($vendor)) {

            $vendor = new Vendor;

            $vendor->code = $vendorAx->ACCOUNTNUM;
            $vendor->name_english = strtoupper(trim($vendorAx->NAME));
            $vendor->source = $this->source;
            $vendor->created_user_id = auth()->user()->id;
            $vendor->updated_user_id = auth()->user()->id;

            $vendor->save();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Created Successfully !!",
                text: "Vendor : " . $vendor->name_english,
                icon: "success",
                timer: 3000,
            );

            $this->dispatch('close-modal-vendor');
        }

        if (!is_null($vendor)) {

            $vendor->code = $vendorAx->ACCOUNTNUM;
            $vendor->name_english = strtoupper(trim($vendorAx->NAME));
            $vendor->source = $this->source;
            $vendor->updated_user_id = auth()->user()->id;

            if ($vendor->isDirty('name_english')) {

                $vendor->save();

                $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "Updated Successfully !!",
                    text: "Vendor : " . $vendor->name_english,
                    icon: "success",
                    timer: 3000,
                );

                $this->dispatch('close-modal-vendor');
            }
        }
    }

    โค้ดของคุณทำงานได้ถูกต้องตาม Logic ครับ แต่สามารถทำให้ Clean และกระชับขึ้นได้โดยใช้เมธอด updateOrCreate หรือปรับโครงสร้างเพื่อลดความซ้ำซ้อน (DRY - Don't Repeat Yourself) ดังนี้ครับ:

    จุดที่ปรับปรุง:
    1. firstOrNew: ช่วยลดการเขียน if (is_null($vendor)) ซ้ำซ้อน โดยจะคืนค่า Model instance ให้เลย (ถ้าไม่มีก็สร้างให้แต่ยังไม่ save)
    2. fill(): ช่วยให้กำหนดค่าหลายๆ Field ได้พร้อมกันในครั้งเดียว
    3. isDirty(): ตัวนี้ฉลาดพอที่จะเช็คว่าข้อมูลใน Object ต่างจากใน Database หรือไม่ (ถ้าเป็นของใหม่ที่เพิ่ง New มา มันจะถือว่าเป็น Dirty ทั้งหมดครับ)
    4.firstOrFail(): ช่วยหยุดการทำงานทันทีหากหาข้อมูลจาก SrvVendor ไม่เจอ เพื่อป้องกัน Error ตอนเรียกใช้ $vendorAx->NAME
    5.ต้องการให้เพิ่มส่วนการตรวจสอบ Validation (เช่น เช็คว่า $id เป็นค่าว่างไหม) เข้าไปด้วยไหมครับ?    
    */
}
