<?php

namespace App\Livewire\Probability;

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

        return view('livewire.probability.probability-lists', compact('probabilities'));

        // if (is_null($this->search)) {
        //     $probabilities = Probability::orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // } else {
        //     $probabilities = Probability::Where('name', 'like', '%' . $this->search . '%')
        //         ->orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // }

        // return view('livewire.probability.probability-lists', [
        //     'probabilities' => $probabilities
        // ]);
    }

    public function deleteProbability($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        try {
            Probability::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Sales Stage : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Can not Deleted !!",
                text: "Probability : " . $name . " there is a transaction in CRM.",
                icon: "error",
            );
        }

        $this->dispatch('close-modal-probability');
    }
}
