<?php

namespace App\Livewire\VolumeUnit;

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
        $volume_units = VolumeUnit::orderBy('id', 'asc')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate();

        return view('livewire.volume-unit.volume-unit-lists', compact('volume_units'));
    }

    public function deleteConfirm($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
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
