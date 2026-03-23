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

    // ฟังก์ชันนี้จะทำงานทุกครั้งที่ $name มีการเปลี่ยนแปลง
    public function updatedName($value)
    {
        $this->name = ucwords(trim($value));
    }

    public function render()
    {
        return view('livewire.found-activity.create-modal');
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

        // 1. ค้นหาหรือสร้าง Instance ใหม่
        $foundActivity = FoundActivity::firstOrNew(['id' => $this->id]);

        // 2. Fill ข้อมูล
        $foundActivity->fill([
            'name' => $this->name,
            'updated_user_id' => auth()->id(),
        ]);

        if (!$foundActivity->exists) {
            $foundActivity->created_user_id = auth()->id();
        }

        // 3. เช็คว่ามีการเปลี่ยนแปลงไหม (Dirty Check)
        if (!$foundActivity->isDirty()) {
            $this->dispatch('close-found-activity-add-modal');
            return;
        }

        DB::beginTransaction();
        try {
            $isNew = !$foundActivity->exists;
            $foundActivity->save();

            DB::commit();

            $this->dispatch(
                "sweet.success",
                title: $isNew ? "Created Successfully !!" : "Updated Successfully !!",
                text: "Found During Activity : {$this->name}",
                icon: "success",
                timer: 3000
            );

            $this->dispatch('close-found-activity-add-modal');
            $this->dispatch('refresh-data'); // แนะนำให้เพิ่ม Dispatch เพื่อโหลด List ใหม่

        } catch (\Throwable $e) {
            DB::rollBack();

            $this->dispatch(
                "sweet.error",
                title: "Cannot save data !!",
                text: "Error: " . $e->getMessage(),
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

    // public function save()
    // {
    //     $this->validate();

    //     // ค้นหาหรือสร้าง Instance ใหม่
    //     $foundActivity = FoundActivity::firstOrNew(['id' => $this->id]);

    //     $foundActivity->fill([
    //         'name' => $this->name,
    //         'updated_user_id' => auth()->id(),
    //     ]);

    //     // ถ้ายังไม่มีใน DB ให้ใส่ created_user_id
    //     if (!$foundActivity->exists) {
    //         $foundActivity->created_user_id = auth()->id();
    //     }

    //     if ($foundActivity->isDirty()) {

    //         $foundActivity->save();

    //         $this->dispatch(
    //             "sweet.success",
    //             position: "center",
    //             title: $foundActivity->wasRecentlyCreated ? "Created Successfully !!" : "Updated Successfully !!",
    //             text: "Found During Activity : " . $this->name,
    //             icon: "success",
    //             timer: 3000,
    //         );

    //         $this->dispatch('close-found-activity-add-modal');
    //     }
    // }
}
