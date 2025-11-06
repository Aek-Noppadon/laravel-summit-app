<?php

namespace App\Livewire\SalesStage;

use App\Models\SalesStage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class SalesStageEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.sales-stage.sales-stage-edit');
    }

    #[On('edit-sales-stage')]
    public function edit($id)
    {
        $sales_stage = SalesStage::findOrFail($id);

        $this->id = $sales_stage->id;
        $this->name = $sales_stage->name;
    }

    public function save()
    {
        $this->name = Str::trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:sales_stages,name,' . $this->id
            ],
            [
                'required' => 'The sales stage :attribute field is required !!',
                'unique' => 'The sales stage :attribute has already been taken !!',
            ]
        );

        $sales_stage = SalesStage::findOrFail($this->id);

        $sales_stage->update([
            'name' => $this->name,
            'updated_user_id' => Auth::user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Sales Stage : " . $this->name,
            // text: "Sales Stage Id : " . $this->id . ", Name : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('sales-stage.list'),
        );

        $this->dispatch('close-modal-sales-stage');
    }
}
