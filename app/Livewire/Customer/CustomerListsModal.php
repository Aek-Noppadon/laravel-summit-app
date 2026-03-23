<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerListsModal extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-customer')]
    public function render()
    {
        $customers = Customer::query()
            // 1. กำหนด Scope การมองเห็นข้อมูล (เหมือนกันทั้งตอนโหลดปกติและตอนค้นหา)
            ->where(function ($query) {
                $query->where('source', 0);
            })
            // 2. ถ้ามีการค้นหา ให้เพิ่มเงื่อนไข Like เข้าไป
            ->when(trim($this->search), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name_english', 'like', "%{$search}%")
                        ->orWhere('name_thai', 'like', "%{$search}%")
                        ->orWhere('parent_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('code')
            ->paginate($this->pagination);

        return view('livewire.customer.customer-lists-modal', compact('customers'));
    }


    /*
    โค้ดของคุณมีการเขียนเงื่อนไขซ้ำซ้อนกันระหว่างการดึงข้อมูลหลักกับการค้นหาครับ เราสามารถยุบรวมเงื่อนไขเรื่องสิทธิ์การมองเห็น (Scope) ไว้ที่จุดเดียว
    แล้วค่อยใช้คำสั่งค้นหาครอบทับเข้าไป เพื่อให้โค้ดสะอาดและดูแลรักษาง่ายขึ้น ลองปรับเป็นแบบนี้ดูครับ:
    จุดที่ปรับปรุง:
    1.  ลดความซ้ำซ้อน: ไม่ต้องเช็ค source หรือ department_id สองรอบในส่วนของ search เพราะเงื่อนไขหลัก (ข้อ 1) ทำหน้าที่กรองด่านแรกไว้อยู่แล้วครับ
    2.  ความอ่านง่าย: การแยก logic ของ "สิทธิ์การมองเห็น" ออกจาก "การค้นหา" ทำให้เราอ่านโค้ดรู้เรื่องขึ้นทันที
    3.  Performance: ผลลัพธ์ทาง SQL จะเหมือนเดิมแต่โครงสร้าง Query จะไม่ซับซ้อนจนเกินไปครับ
    4.  คุณต้องการให้เพิ่มการ Search ในฟิลด์อื่นๆ หรือต้องการเพิ่มระบบ Filter แยกตาม Source ด้วยไหมครับ ?

    #[On('refresh-customer')]
    public function render()
    {
        $departmentId = auth()->user()->department_id;

        $customers = Customer::where(function ($customerQuery) use ($departmentId) {
            $customerQuery->where('source', 0)
                ->orWhere(function ($q) use ($departmentId) {
                    $q->whereIn('source', [1, 2])
                        ->whereHas('userCreated.department', function ($query) use ($departmentId) {
                            $query
                                ->where('id', $departmentId);
                        });
                });
        })
            ->when($this->search, function ($query) use ($departmentId) {
                $query->where(function ($searchQuery) use ($departmentId) {
                    $searchQuery->where(function ($q) {
                        $q->where('source', 0)
                            ->where(function ($qq) {
                                $qq->where('code', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_english', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_thai', 'like', '%' . $this->search . '%')
                                    ->orWhere('parent_code', 'like', '%' . $this->search . '%');
                            });
                    })->orWhere(function ($q) use ($departmentId) {
                        $q->whereIn('source', [1, 2])
                            ->whereHas('userCreated.department', function ($query) use ($departmentId) {
                                $query->where('id', $departmentId);
                            })
                            ->where(function ($qq) {
                                $qq->where('code', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_english', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_thai', 'like', '%' . $this->search . '%')
                                    ->orWhere('parent_code', 'like', '%' . $this->search . '%');
                            });
                    });
                });
            })
            ->orderBy('source')
            ->orderBy('code')
            ->with(['userCreated:id,name,department_id', 'userCreated.department:id,name'])
            ->paginate($this->pagination);

        return view('livewire.customer.customer-lists-modal', compact('customers'));
    }
    */
}
