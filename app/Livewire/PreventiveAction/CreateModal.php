<?php

namespace App\Livewire\PreventiveAction;

use App\Models\PreventiveAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function render()
    {
        return view('livewire.preventive-action.create-modal');
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

        // ใช้ fill เพื่อความรวดเร็ว (ต้องมี property $id และ $name ใน class)
        $this->fill($preventiveAction->only('id', 'name'));
    }

    public function save()
    {
        $this->validate();

        // 1. เตรียม Object
        $preventiveAction = PreventiveAction::findOrNew($this->id);
        $isNew = !$preventiveAction->exists;

        // 2. Mapping ข้อมูล
        $preventiveAction->name = $this->name;
        $preventiveAction->updated_user_id = auth()->id();

        if ($isNew) {
            $preventiveAction->created_user_id = auth()->id();
        }

        // 3. Dirty Check: ถ้าไม่มีการแก้ไข ให้ปิด Modal ไปเลย
        if (!$isNew && !$preventiveAction->isDirty()) {
            $this->dispatch('close-modal');
            return;
        }

        DB::beginTransaction();
        try {
            $preventiveAction->save();
            DB::commit();

            $this->dispatch(
                "sweet.success",
                title: $isNew ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Preventive Action : {$this->name}",
                icon: "success",
                timer: 3000
            );

            $this->dispatch('close-preventive-action-add-modal');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Preventive Action Save Error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            $this->dispatch(
                "sweet.error",
                title: "Something went wrong!",
                text: "Unable to process your request at this moment.",
                icon: "error"
            );
        }
    }

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
}
