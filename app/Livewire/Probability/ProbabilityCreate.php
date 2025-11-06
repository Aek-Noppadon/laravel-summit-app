<?php

namespace App\Livewire\Probability;

use App\Models\Probability;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ProbabilityCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.probability.probability-create');
    }

    public function save()
    {
        // dd("Save");

        $this->name = Str::trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:probabilities',
            ],
            [
                'required' => 'The probability :attribute field is required !!',
                'unique' => 'The probability :attribute has already been taken !!',
            ]
        );

        Probability::create(
            [
                'name' => $this->name,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ]
        );

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Probability : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('probability.list'),
        );

        $this->dispatch('close-modal-probability');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
