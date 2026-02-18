<?php

namespace App\Livewire\Crm\Probability;

use App\Models\Probability;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProbabilityLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-probability')]
    public function render()
    {
        /*
        =======================================================
        Created : Aek Noppadon
        Date    : 12/11/2025
        =======================================================
        Discription :                    
        Show probabilities data by user & department 
        =======================================================
        */

        $departmentId = auth()->user()->department_id;

        $probabilities = Probability::whereHas('userCreated.department', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate();

        // ====================================================

        return view('livewire.crm.probability.probability-lists', compact('probabilities'));
    }

    public function deleteConfirm($id, $name)
    {
        $this->dispatch("confirm-delete-probability", id: $id, name: $name);
    }

    #[On('destroy-probability')]
    public function destroy($id, $name)
    {
        try {
            Probability::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Probability : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Cannot Deleted !!",
                text: $name . " there is a transaction in CRM.",
                icon: "error",
            );
        }

        $this->dispatch('close-modal-volume-unit');
    }
}
