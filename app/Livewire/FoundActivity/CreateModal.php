<?php

namespace App\Livewire\FoundActivity;

use App\Models\FoundActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateModal extends Component
{
    public $id, $name;

    // เมื่อมีการพิมพ์ใน input wire:model="name"
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
                Rule::unique('found_activities', 'name')->ignore($this->id)
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
            'name' => 'Found Activity Name',
        ];
    }

    #[On('edit-found-activity')]
    public function edit($id)
    {
        $this->resetValidation(); // ล้าง error เก่าก่อนเริ่มแก้ไข

        $foundActivity = FoundActivity::findOrFail($id);

        // ใช้ fill เพื่อความรวดเร็ว (ต้องมี property $id และ $name ใน class)
        $this->fill($foundActivity->only('id', 'name'));
    }

    public function save()
    {
        $this->validate();

        try {
            // 1. เตรียม Instance หา Record เดิมหรือสร้างใหม่
            $foundActivity = FoundActivity::firstOrNew(['id' => $this->id]);

            // 2. Fill ข้อมูลที่มาจาก AX เท่านั้น (ยังไม่ใส่ User ID)
            $foundActivity->name = $this->name;

            // ถ้าเป็น Record ใหม่ หรือมีการเปลี่ยนชื่อ ให้เตรียม Update User ID
            if ($foundActivity->isDirty()) {
                $foundActivity->updated_user_id = auth()->id();

                if (!$foundActivity->exists) {
                    $foundActivity->created_user_id = auth()->id();
                }
            }

            // 3. เช็คความเปลี่ยนแปลง (ถ้าไม่มีอะไรเปลี่ยนเลยจริงๆ)
            if (!$foundActivity->isDirty()) {
                return $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "No Changes Detected !!",
                    text: $foundActivity->name . ": No data changed.",
                    icon: "info",
                );
            }

            // 4. ถ้ามีข้อมูลเปลี่ยนค่อยเริ่ม Transaction บันทึกข้อมูล
            DB::transaction(function () use ($foundActivity) {
                $foundActivity->save();
            });

            // 5. Success Feedback & Close Modal
            $this->dispatch('close-found-activity-add-modal');

            $this->dispatch(
                "sweet.success",
                title: $foundActivity->wasRecentlyCreated ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Found During Activity: {$this->name}",
                icon: "success",
                timer: 3000
            );
        } catch (\Throwable $e) {
            // แบบโปร (เห็น Error ทั้งหมด รวมถึงบรรทัดที่พัง)
            logger()->error("Found Activity Save Error: " . $e->getMessage(), [
                'exception' => $e,
                'foundActivity_id' => $this->id // ใส่ Context เพิ่มเพื่อความง่ายในการหาว่า Found Activity คนไหนที่พัง
            ]);

            $this->dispatch(
                "sweet.error",
                title: "Cannot save data !!",
                text: "Something went wrong. Please try again.",
                icon: "error"
            );
        }
    }

    #[On('reset-modal')]
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
        return view('livewire.found-activity.create-modal');
    }
}
