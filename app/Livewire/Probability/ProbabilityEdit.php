<?php

namespace App\Livewire\Probability;

use App\Models\Probability;
use Livewire\Attributes\On;
use Livewire\Component;

class ProbabilityEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.probability.probability-edit');
    }

    #[On('edit-probability')]
    public function edit($id)
    {
        $probability = Probability::findOrFail($id);

        $this->id = $probability->id;
        $this->name = $probability->name;
    }

    public function save()
    {
        $this->name = trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:probabilities,name,' . $this->id
            ],
            [
                'required' => 'The probability :attribute field is required !!',
                'unique' => 'The probability :attribute has already been taken !!',
            ]
        );

        $probability = Probability::findOrFail($this->id);

        $probability->update([
            'name' => $this->name,
            'updated_user_id' => auth()->user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Probability : " . $this->name,
            // text: "Probability Id : " . $this->id . ", Name : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('probability.list'),
        );

        $this->dispatch('close-modal-probability');
    }
}
