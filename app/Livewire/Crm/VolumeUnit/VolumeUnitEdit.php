<?php

namespace App\Livewire\Crm\VolumeUnit;

use App\Models\VolumeUnit;
use Livewire\Attributes\On;
use Livewire\Component;

class VolumeUnitEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.crm.volume-unit.volume-unit-edit');
    }

    #[On('edit-volume-unit')]
    public function edit($id)
    {
        $volume_unit = VolumeUnit::findOrFail($id);

        $this->id = $volume_unit->id;
        $this->name = $volume_unit->name;
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = VolumeUnit::where('name', $this->name)
            ->where('id', '<>', $this->id)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name', 'The volume unit name has already been taken.');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => 'The volume unit :attribute field is required.',
            ]
        );

        $volume_unit = VolumeUnit::findOrFail($this->id);

        $volume_unit->update([
            'name' => $this->name,
            'updated_user_id' => auth()->user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Volume Unit : " . $this->name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-volume-unit');
    }
}
