<?php

namespace App\Livewire\Crm\CustomerType;

use App\Models\CustomerType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerTypeEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.crm.customer-type.customer-type-edit');
    }

    #[On('edit-customer-type')]
    public function edit($id)
    {
        $customer_type = CustomerType::findOrFail($id);

        $this->id = $customer_type->id;
        $this->name = $customer_type->name;
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = CustomerType::where('name', $this->name)
            ->where('id', '<>', $this->id)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name', 'This customer type name has already been taken.');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => 'The customer type :attribute field is required.',
            ]
        );

        // $this->validate(
        //     [
        //         'name' => 'required|unique:customer_types,name,' . $this->id
        //     ],
        //     [
        //         'required' => 'The customer type :attribute field is required !!',
        //         'unique' => 'The customer type :attribute has already been taken !!',
        //     ]
        // );

        $customer_type = CustomerType::findOrFail($this->id);

        $customer_type->update([
            'name' => $this->name,
            'updated_user_id' => auth()->user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Customer Type : " . $this->name,
            // text: "Customer Type Id : " . $this->id . ", Name : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('customer-type.list'),
        );

        $this->dispatch('close-modal-customer-type');
    }
}
