<?php

namespace App\Livewire\SalesStage;

use App\Models\SalesStage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
        // dd("Save");

        $this->name = Str::trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:sales_stages',
            ],
            [
                'required' => 'The sales state :attribute field is required !!',
                'unique' => 'The sales state :attribute has already been taken !!',
            ]
        );

        SalesStage::create(
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
