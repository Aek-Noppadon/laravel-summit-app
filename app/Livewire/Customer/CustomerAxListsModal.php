<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use App\Models\SrvCustomer;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerAxListsModal extends Component
{
    use WithPagination;
    public $search;
    public $source = 0;
    public $pagination = 20;

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
            // ->orderBy('CustomerNameThi')
            ->paginate($this->pagination);

        return view('livewire.customer.customer-ax-lists-modal', compact('customers'));
    }

    #[On('save-customer-ax')]
    public function saveCustomerAx($id)
    {
        $customerAx = SrvCustomer::select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi')
            ->where('CustomerCode', $id)
            ->firstOrFail(); // ใช้ firstOrFail เพื่อกันกรณีไม่พบข้อมูลใน AX

        // ค้นหาหรือสร้าง Instance ใหม่
        $customer = Customer::firstOrNew(['code' => $id]);

        $customer->fill([
            'name_english' => strtoupper(trim($customerAx->CustomerNameEng)),
            'name_thai' => trim($customerAx->CustomerNameThi),
            'parent_code' => trim($customerAx->ParentCode),
            'parent_name' => trim($customerAx->ParentName),
            'source' => $this->source,
            'updated_user_id' => auth()->id(),
        ]);

        // ถ้าเป็น Record ใหม่ ให้ใส่ created_user_id ด้วย
        if (!$customer->exists) {
            $customer->created_user_id = auth()->id();
        }

        // ตรวจสอบว่ามีการเปลี่ยนแปลงข้อมูลหรือไม่ (รวมถึงกรณสร้างใหม่ด้วย)
        if ($customer->isDirty()) {
            $isNew = !$customer->exists;
            $customer->save();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: $isNew ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Customer : " . $customer->name_english,
                icon: "success",
                timer: 3000,
            );

            $this->dispatch('close-modal-customer');
        }
    }
}
