<?php

namespace App\Livewire\CustomerGroup;

use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerGroupCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.customer-group.customer-group-create');
    }

    public function save()
    {
        // dd("Save");

        $this->name = Str::trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:customer_groups',
            ],
            [
                'required' => 'The customer group :attribute field is required !!',
                'unique' => 'The customer group :attribute has already been taken !!',
            ]
        );

        CustomerGroup::create(
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
            text: "Customer Group : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('customer-group.list'),
        );

        $this->dispatch('close-modal-customer-group');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
