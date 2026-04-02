<?php

namespace App\Livewire\PreventiveAction;

use App\Models\PreventiveAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateModal extends Component
{
    public $id, $name;

    // ฟังก์ชันนี้จะทำงานทุกครั้งที่ $name มีการเปลี่ยนแปลง
    public function updatedName($value)
    {
        $this->name = ucwords(trim($value));
    }

    protected function rules()
    {
        return [
            // ใช้ Rule class จะช่วยลดโอกาสพิมพ์ผิดและอ่านง่ายกว่า
            'name' => [
                'required',
                'max:255',
                Rule::unique('preventive_actions', 'name')->ignore($this->id)
            ]
        ];
    }

    protected function messages()
    {
        return [
            "required" => "The :attribute field is required.",
            "max"      => "The :attribute field must not be greater than 255 characters.",
            "unique"   => "The :attribute has already been taken.",
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => 'Preventive Action Name',
        ];
    }

    #[On('edit')]
    public function edit($id)
    {
        $this->resetValidation(); // ล้าง error เก่าก่อนเริ่มแก้ไข

        $preventiveAction = PreventiveAction::findOrFail($id);

        // dd($preventiveAction);

        // ใช้ fill เพื่อความรวดเร็ว (ต้องมี property $id และ $name ใน class)
        $this->fill($preventiveAction->only('id', 'name'));
    }

    public function save()
    {
        $this->validate();

        try {
            // 1. เตรียม Instance หา Record เดิมหรือสร้างใหม่
            $preventiveAction = PreventiveAction::firstOrNew(['id' => $this->id]);

            // 2. Fill ข้อมูลที่มาจาก AX เท่านั้น (ยังไม่ใส่ User ID)
            $preventiveAction->name = $this->name;

            // ถ้าเป็น Record ใหม่ หรือมีการเปลี่ยนชื่อ ให้เตรียม Update User ID
            if ($preventiveAction->isDirty()) {
                $preventiveAction->updated_user_id = auth()->id();

                if (!$preventiveAction->exists) {
                    $preventiveAction->created_user_id = auth()->id();
                }
            }

            // 3. เช็คความเปลี่ยนแปลง (ถ้าไม่มีอะไรเปลี่ยนเลยจริงๆ)
            if (!$preventiveAction->isDirty()) {
                return $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "No Changes Detected !!",
                    text: $preventiveAction->name . ": No data changed.",
                    icon: "info",
                );
            }

            // 4. ถ้ามีข้อมูลเปลี่ยนค่อยเริ่ม Transaction บันทึกข้อมูล
            DB::transaction(function () use ($preventiveAction) {
                $preventiveAction->save();
            });

            // 5. Success Feedback & Close Modal
            $this->dispatch('close-preventive-action-add-modal');

            $this->dispatch(
                "sweet.success",
                title: $preventiveAction->wasRecentlyCreated ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Found During Activity: {$this->name}",
                icon: "success",
                timer: 3000
            );
        } catch (\Throwable $e) {
            // แบบโปร (เห็น Error ทั้งหมด รวมถึงบรรทัดที่พัง)
            logger()->error("Preventive Action Save Error: " . $e->getMessage(), [
                'exception' => $e,
                'preventiveAction_id' => $this->id // ใส่ Context เพิ่มเพื่อความง่ายในการหาว่า Preventive Action คนไหนที่พัง
            ]);

            $this->dispatch(
                "sweet.error",
                title: "Cannot save data !!",
                text: "Something went wrong. Please try again.",
                icon: "error"
            );
        }
    }

    // public function save()
    // {
    //     $this->validate();

    //     try {
    //         DB::beginTransaction();

    //         // 1. หา Record เดิมหรือสร้าง Instance ใหม่
    //         $preventiveAction = PreventiveAction::findOrNew($this->id);
    //         $isNew = !$preventiveAction->exists;

    //         // 2. Fill ข้อมูลที่มาจาก AX เท่านั้น (ยังไม่ใส่ User ID)
    //         $preventiveAction->name = $this->name;

    //         // 3. ตรวจสอบว่ามีการเปลี่ยนแปลง หรือ เป็น Record ใหม่หรือไม่
    //         // isDirty() จะเป็น true ถ้า name เปลี่ยน
    //         // !$preventiveAction->exists จะเป็น true ถ้าเป็นรายการใหม่ที่ยังไม่มีใน DB
    //         if ($preventiveAction->isDirty() || !$preventiveAction->exists) {

    //             $isNew = !$preventiveAction->exists;

    //             if ($isNew) {
    //                 $preventiveAction->created_user_id = auth()->id();
    //             }

    //             // อัปเดต updated_user_id ทุกกรณีที่มีการเปลี่ยนแปลง (หรือเฉพาะตอน Update ตามต้องการ)
    //             $preventiveAction->updated_user_id = auth()->id();

    //             $preventiveAction->save();

    //             DB::commit();

    //             $this->dispatch(
    //                 "sweet.success",
    //                 title: $isNew ? "Created Successfully !!" : "Updated Successfully !!",
    //                 text: "Preventive Action: {$this->name}",
    //                 icon: "success",
    //                 timer: 3000
    //             );

    //             $this->dispatch('close-preventive-action-add-modal');
    //         } else {
    //             // กรณีไม่มีอะไรเปลี่ยนแปลง (isDirty เป็น false และ exists เป็น true)
    //             DB::rollBack(); // ไม่มีการทำอะไรก็ rollback หรือไม่ต้องเริ่ม transaction ตั้งแต่แรกก็ได้ครับ

    //             // กรณีข้อมูลเหมือนเดิมเป๊ะ และไม่ใช่การสร้างใหม่
    //             $this->dispatch(
    //                 "sweet.success",
    //                 position: "center",
    //                 title: "No Changes Detected !!",
    //                 text: $preventiveAction->name . ": No data changed.",
    //                 icon: "info",
    //             );
    //         }
    //     } catch (\Throwable $e) {
    //         DB::rollBack();

    //         Log::error("Preventive Action Save Error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

    //         $this->dispatch(
    //             "sweet.error",
    //             title: "Something went wrong!",
    //             text: "Unable to process your request at this moment.",
    //             icon: "error"
    //         );
    //     }
    // }

    #[On('reset-form')]
    public function resetForm()
    {
        $this->reset();
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->resetValidation(); // ล้างข้อความ Error ด้วย
        $this->reset();
    }

    public function render()
    {
        return view('livewire.preventive-action.create-modal');
    }
}
