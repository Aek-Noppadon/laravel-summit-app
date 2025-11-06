<?php

namespace App\Livewire\Crm\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerCreate extends Component
{
    public $customer_id, $name_english, $name_thai;
    public $source = '1';

    public function render()
    {
        return view('livewire.crm.customer.customer-create');
    }

    public function save()
    {
        $this->name_english = Str::trim(Str::upper($this->name_english));
        $this->name_thai = Str::trim($this->name_thai);

        $this->validate(
            [
                'name_english' => 'required|unique:customers',
                'name_thai' => 'unique:customers',
            ],
            [
                'required' => 'The customer :attribute field is required !!',
                'unique' => 'The customer :attribute has already been taken !!',
            ]
        );

        Customer::create(
            [
                'name_english' => $this->name_english,
                'name_thai' => $this->name_thai,
                'source' => $this->source,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ]
        );

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Customer : " . $this->name_english,
            icon: "success",
            timer: 3000,
            // url: route('crm.create'),
        );

        $this->dispatch('close-modal-customer');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
