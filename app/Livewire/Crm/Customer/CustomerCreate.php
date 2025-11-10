<?php

namespace App\Livewire\Crm\Customer;

use App\Models\Customer;
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
        $this->name_english = strtoupper(trim($this->name_english));
        $this->name_thai = strtoupper(trim($this->name_thai));

        /*
         * =================================================================
         Create by Aek 06/11/2025
         Validate unique AX customer & customer and department befor save
         * =================================================================
        */

        $departmentId = auth()->user()->department_id;

        $exists = Customer::where('name_english', $this->name_english)
            ->where('source', '0')
            ->orWhere('name_english', $this->name_english)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name_english', 'This Customer has already been taken.');
            return;
        }

        $this->validate(
            [
                'name_english' => 'required',
            ],
            [
                'required' => 'The customer :attribute field is required.',
            ]
        );

        Customer::create(
            [
                'name_english' => $this->name_english,
                'name_thai' => $this->name_thai,
                'source' => $this->source,
                'created_user_id' => auth()->user()->id,
                'updated_user_id' => auth()->user()->id,
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
