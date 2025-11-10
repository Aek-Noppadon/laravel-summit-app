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
        if (is_null($this->search)) {
            $probabilities = Probability::orderBy('id', 'asc')
                ->paginate($this->pagination);
        } else {
            $probabilities = Probability::Where('name', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.crm.probability.probability-lists', compact('probabilities'));

        // return view('livewire.crm.probability.probability-lists', [
        //     'probabilities' => $probabilities
        // ]);
    }
}
