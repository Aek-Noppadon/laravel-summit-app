<?php

namespace App\Livewire\ProductItem;

use App\Models\ProductItem;
use App\Models\SrvProductItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListsAxModal extends Component
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

    #[On('save-product-ax')]
    public function saveProductAx($item_code)
    {
        // 1. ดึงข้อมูลจาก AX ก่อน (Fail Fast)
        $productItemAx = SrvProductItem::select(
            'ITEMID',
            'ITEMNAME',
            'BRAND',
            'BRANDDESC',
            'ITEMGROUP',
            'ITEMGROUPDESC',
            'ITEMSUBGROUP',
            'ITEMSUBGROUPDESC',
            'SCC_SUPPLIERSALESREPNAME',
            'PRINCIPALCODE',
            'PRINCIPALNAME',
            'SCC_DISCONTINUEDSTATUS'
        )
            ->where('ITEMID', $item_code)
            ->firstOrFail();

        try {
            // 2. เตรียม Instance หา Record เดิมหรือสร้างใหม่
            $productItem = ProductItem::firstOrNew(['code' => $item_code]);

            // 3. Fill ข้อมูลที่มาจาก AX (ยังไม่ใส่ User ID)
            $productItem->fill([
                'name'           => trim($productItemAx->ITEMNAME),
                'brand_code'     => trim($productItemAx->BRAND),
                'brand_name'     => trim($productItemAx->BRANDDESC),
                'group_code'     => trim($productItemAx->ITEMGROUP),
                'group_name'     => trim($productItemAx->ITEMGROUPDESC),
                'subgroup_code'  => trim($productItemAx->ITEMSUBGROUP),
                'subgroup_name'  => trim($productItemAx->ITEMSUBGROUPDESC),
                'supplier_rep'   => trim($productItemAx->SCC_SUPPLIERSALESREPNAME),
                'principal_code' => trim($productItemAx->PRINCIPALCODE),
                'principal_name' => trim($productItemAx->PRINCIPALNAME),
                'status'         => $productItemAx->SCC_DISCONTINUEDSTATUS,
                'source'         => $this->source,
            ]);

            // ถ้าเป็น Record ใหม่ หรือมีการเปลี่ยนชื่อ ให้เตรียม Update User ID
            if ($productItem->isDirty()) {
                $productItem->updated_user_id = auth()->id();

                if (!$productItem->exists) {
                    $productItem->created_user_id = auth()->id();
                }
            }

            // 4. เช็คความเปลี่ยนแปลง (ถ้าไม่มีอะไรเปลี่ยนเลยจริงๆ)
            if (!$productItem->isDirty()) {
                return $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "No Changes Detected !!",
                    text: "{$productItem->name} No data changed.",
                    icon: "info"
                );
            }

            // 5. ถ้ามีข้อมูลเปลี่ยนค่อยเริ่ม Transaction บันทึกข้อมูล
            DB::transaction(function () use ($productItem) {
                $productItem->save();
            });

            // 6. Success Feedback & Close Modal
            $this->dispatch('close-modal-product');

            // 7. แจ้งเตือนเมื่อสำเร็จ
            $this->dispatch(
                "sweet.success",
                position: "center",
                title: $productItem->wasRecentlyCreated ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Item : " . $productItem->name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $e) {
            // แบบโปร (เห็น Error ทั้งหมด รวมถึงบรรทัดที่พัง)
            logger()->error("CustomerAx Save Error: " . $e->getMessage(), [
                'exception' => $e,
                'productItem_code' => $item_code // ใส่ Context เพิ่มเพื่อความง่ายในการหาว่า Customer คนไหนที่พัง
            ]);

            $this->dispatch(
                "sweet.error",
                title: "Cannot save data !!",
                text: "Something went wrong. Please try again.",
                icon: "error"
            );
        }
    }

    #[On('refresh-data')]
    public function render()
    {
        $productItems = SrvProductItem::query()
            ->when(trim($this->search), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('ITEMID', 'like', "%$search%")
                        ->orWhere('ITEMNAME', 'like', "%$search%")
                        ->orWhere('BRANDDESC', 'like', "%$search%");
                });
            })
            ->paginate($this->pagination);

        return view('livewire.product-item.lists-ax-modal', compact('productItems'));
    }
}
