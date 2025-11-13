<?php

namespace App\Livewire\Crm\Probability;

use App\Models\Probability;
use Livewire\Attributes\On;
use Livewire\Component;

class ProbabilityCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.crm.probability.probability-create');
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = Probability::where('name', $this->name)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name', 'The probability name has already been taken.');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => 'The probability :attribute field is required.',
            ]
        );

        // $this->validate(
        //     [
        //         'name' => 'required|unique:probabilities',
        //     ],
        //     [
        //         'required' => 'The probability :attribute field is required !!',
        //         'unique' => 'The probability :attribute has already been taken !!',
        //     ]
        // );

        Probability::create(
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
