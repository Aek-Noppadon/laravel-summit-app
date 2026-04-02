<?php

namespace App\Livewire\Vendor;

use App\Models\SrvVendor;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class VendorAxListsModal extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;
    public $source = 0;

    // เพิ่มฟังก์ชันนี้เพื่อให้ Search ทำงานไม่เพี้ยน
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // ฟังก์ชันนี้จะทำงานทุกครั้งที่ $name มีการเปลี่ยนแปลง
    public function updatedName($value)
    {
        $this->name = ucwords(trim($value));
    }

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
        // 1. ดึงข้อมูลจาก AX ก่อน (Fail Fast)
        $vendorAx = SrvVendor::select('ACCOUNTNUM', 'NAME')
            ->where('ACCOUNTNUM', $id)
            ->firstOrFail();

        try {
            // 2. เตรียม Instance หา Record เดิมหรือสร้างใหม่
            $vendor = Vendor::firstOrNew(['code' => $id]);

            // 3. Fill ข้อมูลที่มาจาก AX (ยังไม่ใส่ User ID)
            $vendor->fill([
                'name_english' => $vendorAx->NAME,
                'source'       => $this->source,
            ]);

            // ถ้าเป็น Record ใหม่ หรือมีการเปลี่ยนชื่อ ให้เตรียม Update User ID
            if ($vendor->isDirty()) {
                $vendor->updated_user_id = auth()->id();

                if (!$vendor->exists) {
                    $vendor->created_user_id = auth()->id();
                }
            }

            // 4. เช็คความเปลี่ยนแปลง (ถ้าไม่มีอะไรเปลี่ยนเลยจริงๆ)
            if (!$vendor->isDirty()) {
                return $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "No Changes Detected !!",
                    text: "{$vendor->name_english}: No data changed.",
                    icon: "info"
                );
            }

            // 5. ถ้ามีข้อมูลเปลี่ยนค่อยเริ่ม Transaction
            DB::transaction(function () use ($vendor) {
                $vendor->save();
            });

            // 6. Success Feedback & Close Modal
            $this->dispatch('close-modal-vendor');

            // 7. แจ้งเตือนเมื่อสำเร็จ
            $this->dispatch(
                "sweet.success",
                position: "center",
                title: $vendor->wasRecentlyCreated ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Vendor: " . $vendor->name_english,
                icon: "success",
                timer: 3000
            );
        } catch (\Throwable $e) {
            // แบบโปร (เห็น Error ทั้งหมด รวมถึงบรรทัดที่พัง)
            logger()->error("VendorAx Save Error: " . $e->getMessage(), [
                'exception' => $e,
                'vendor_id' => $id // ใส่ Context เพิ่มเพื่อความง่ายในการหาว่า Vendor คนไหนที่พัง
            ]);

            $this->dispatch(
                "sweet.error",
                title: "Cannot save data !!",
                text: "Something went wrong. Please try again.",
                icon: "error"
            );
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
