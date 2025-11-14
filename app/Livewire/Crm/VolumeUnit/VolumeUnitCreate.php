<?php

namespace App\Livewire\Crm\VolumeUnit;

use App\Models\VolumeUnit;
use Livewire\Attributes\On;
use Livewire\Component;

class VolumeUnitCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.crm.volume-unit.volume-unit-create');
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = VolumeUnit::where('name', $this->name)
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

        VolumeUnit::create(
            [
                'name' => $this->name,
                'created_user_id' => auth()->user()->id,
                'updated_user_id' => auth()->user()->id,
            ]
        );

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Volume Unit : " . $this->name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-volume-unit');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
