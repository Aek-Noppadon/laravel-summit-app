<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerEdit extends Component
{
    // public $customer;
    public $id, $name_english, $name_thai;

    public function render()
    {
        return view('livewire.customer.customer-edit');
    }

    #[On('edit-customer')]
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        $this->id = $customer->id;
        $this->name_english = $customer->name_english;
        $this->name_thai = $customer->name_thai;
    }

    public function save()
    {
        $this->name_english = strtoupper(trim($this->name_english));
        $this->name_thai = strtoupper(trim($this->name_thai));

        $departmentId = auth()->user()->department_id;

        $exists = Customer::where('name_english', $this->name_english)
            ->where('source', 0)
            ->orWhere('name_english', $this->name_english)
            ->where('id', '<>', $this->id)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query
                    ->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name_english', 'The customer name has already been taken.');
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

        // $this->validate(
        //     [
        //         'name_english' => 'required|unique:customers,name_english,' . $this->id,
        //     ],
        //     [
        //         'required' => 'The customer :attribute field is required !!',
        //         'unique' => 'The customer :attribute has already been taken !!',
        //     ]
        // );

        $customer = Customer::findOrFail($this->id);

        $customer->update([
            'name_english' => $this->name_english,
            'name_thai' => $this->name_thai,
            'updated_user_id' => auth()->user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Customer : " . $this->name_english,
            // text: "Customer Id : " . $this->id . ", Name : " . $this->name_english,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-customer');
    }
}
