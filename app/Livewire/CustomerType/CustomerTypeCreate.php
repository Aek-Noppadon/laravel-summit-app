<?php

namespace App\Livewire\CustomerType;

use App\Models\CustomerType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerTypeCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.customer-type.customer-type-create');
    }

    public function save()
    {
        // dd("Save");

        $this->name = Str::trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:customer_types',
            ],
            [
                'required' => 'The customer type :attribute field is required !!',
                'unique' => 'The customer type :attribute has already been taken !!',
            ]
        );

        CustomerType::create(
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
            text: "Customer Type : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('customer-type.list'),
        );

        $this->dispatch('close-modal-customer-type');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
