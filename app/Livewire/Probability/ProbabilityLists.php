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
        if (is_null($this->search)) {
            $probabilities = Probability::orderBy('id', 'asc')
                ->paginate($this->pagination);
        } else {
            $probabilities = Probability::Where('name', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.probability.probability-lists', [
            'probabilities' => $probabilities
        ]);
    }

    public function deleteProbability($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        Probability::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            text: "Probability : " . $name,
            // text: "Probability Id : " . $id . ", Name : " . $name,
            icon: "success",
            timer: 3000,
            // url: route('probability.list'),
        );

        $this->dispatch('close-modal-probability');
    }
}
