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

        // if (is_null($this->search)) {
        //     $probabilities = Probability::orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // } else {
        //     $probabilities = Probability::Where('name', 'like', '%' . $this->search . '%')
        //         ->orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // }


        // return view('livewire.crm.probability.probability-lists', [
        //     'probabilities' => $probabilities
        // ]);
    }
}
