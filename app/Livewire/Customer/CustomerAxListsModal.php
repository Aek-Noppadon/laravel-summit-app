<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use App\Models\SrvCustomer;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerAxListsModal extends Component
{
    use WithPagination;
    public $search;
    public $source = 0;
    public $pagination = 20;

    // เพิ่มฟังก์ชันนี้เพื่อให้ Search ทำงานไม่เพี้ยน
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('save-customer-ax')]
    public function saveCustomerAx($id)
    {
        // 1. ดึงข้อมูลจาก AX ก่อน (Fail Fast)
        $customerAx = SrvCustomer::select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
            ->where('CustomerCode', $id)
            ->firstOrFail();

        try {
            // 2. เตรียม Instance หา Record เดิมหรือสร้างใหม่
            $customer = Customer::firstOrNew(['code' => $id]);

            // 3. Fill ข้อมูลที่มาจาก AX (ยังไม่ใส่ User ID)
            $customer->fill([
                'name_english' => $customerAx->CustomerNameEng,
                'name_thai'    => $customerAx->CustomerNameThi,
                'parent_code'  => $customerAx->ParentCode,
                'parent_name'  => $customerAx->ParentName,
                'source'       => $this->source,
            ]);

            // ถ้าเป็น Record ใหม่ หรือมีการเปลี่ยนชื่อ ให้เตรียม Update User ID
            if ($customer->isDirty()) {
                $customer->updated_user_id = auth()->id();

                if (!$customer->exists) {
                    $customer->created_user_id = auth()->id();
                }
            }

            // 4. เช็คความเปลี่ยนแปลง (ถ้าไม่มีอะไรเปลี่ยนเลยจริงๆ)
            if (!$customer->isDirty()) {
                return $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "No Changes Detected !!",
                    text: "{$customer->name_english}: No data changed.",
                    icon: "info"
                );
            }

            // 5. ถ้ามีข้อมูลเปลี่ยนค่อยเริ่ม Transaction บันทึกข้อมูล
            DB::transaction(function () use ($customer) {
                $customer->save();
            });

            // 6. Success Feedback & Close Modal
            $this->dispatch('close-modal-customer');

            // 7. แจ้งเตือนเมื่อสำเร็จ
            $this->dispatch(
                "sweet.success",
                position: "center",
                title: $customer->wasRecentlyCreated ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Customer: " . $customer->name_english,
                icon: "success",
                timer: 3000
            );
        } catch (\Throwable $e) {
            // แบบโปร (เห็น Error ทั้งหมด รวมถึงบรรทัดที่พัง)
            logger()->error("CustomerAx Save Error: " . $e->getMessage(), [
                'exception' => $e,
                'customer_id' => $id // ใส่ Context เพิ่มเพื่อความง่ายในการหาว่า Customer คนไหนที่พัง
            ]);

            $this->dispatch(
                "sweet.error",
                title: "Cannot save data !!",
                text: "Something went wrong. Please try again.",
                icon: "error"
            );
        }
    }

    #[On('refresh-customer-ax')]
    public function render()
    {
        $customers = SrvCustomer::select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi')
            ->when(trim($this->search), function ($query, $search) {
                $query->where('CustomerCode', 'like', "%{$search}%")
                    ->orWhere('CustomerNameEng', 'like', "%{$search}%")
                    ->orWhere('CustomerNameThi', 'like', "%{$search}%");
            })
            ->orderBy('CustomerCode')
            ->paginate($this->pagination);

        return view('livewire.customer.customer-ax-lists-modal', compact('customers'));
    }
}
