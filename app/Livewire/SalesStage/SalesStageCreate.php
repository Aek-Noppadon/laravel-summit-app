<?php

namespace App\Livewire\SalesStage;

use App\Models\SalesStage;
use Livewire\Attributes\On;
use Livewire\Component;

class SalesStageCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.sales-stage.sales-stage-create');
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = SalesStage::where('name', $this->name)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name', 'The sales stage name has already been taken.');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => 'The sales stage :attribute field is required.',
            ]
        );

        // $this->validate(
        //     [
        //         'name' => 'required|unique:sales_stages',
        //     ],
        //     [
        //         'required' => 'The sales state :attribute field is required !!',
        //         'unique' => 'The sales state :attribute has already been taken !!',
        //     ]
        // );

        SalesStage::create(
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
            text: "Sales Stage : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('sales-stage.list'),
        );

        $this->dispatch('close-modal-sales-stage');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
