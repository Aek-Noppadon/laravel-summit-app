<?php

namespace App\Livewire\Crm\VolumeUnit;

use App\Models\VolumeUnit;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class VolumeUnitLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-volume-unit')]
    public function render()
    {
        $departmentId = auth()->user()->department_id;

        $volume_units = VolumeUnit::whereHas('userCreated.department', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate();


        return view('livewire.crm.volume-unit.volume-unit-lists', compact('volume_units'));
    }

    public function deleteConfirm($id, $name)
    {
        $this->dispatch("confirm-delete-volume-unit", id: $id, name: $name);
    }

    #[On('destroy-volume-unit')]
    public function destroy($id, $name)
    {
        VolumeUnit::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            text: "Sales Stage : " . $name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-volume-unit');
    }
}
