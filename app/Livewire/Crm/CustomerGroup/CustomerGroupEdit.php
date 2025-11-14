<?php

namespace App\Livewire\Crm\CustomerGroup;

use App\Models\CustomerGroup;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerGroupEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.crm.customer-group.customer-group-edit');
    }

    #[On('edit-customer-group')]
    public function edit($id)
    {
        $customer_group = CustomerGroup::findOrFail($id);

        $this->id = $customer_group->id;
        $this->name = $customer_group->name;
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = CustomerGroup::where('name', $this->name)
            ->where('id', '<>', $this->id)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name', 'The customer group name has already been taken.');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => 'The customer group :attribute field is required.',
            ]
        );

        // $this->validate(
        //     [
        //         'name' => 'required|unique:customer_groups,name,' . $this->id
        //     ],
        //     [
        //         'required' => 'The customer type :attribute field is required !!',
        //         'unique' => 'The customer type :attribute has already been taken !!',
        //     ]
        // );

        $customer_group = CustomerGroup::findOrFail($this->id);

        $customer_group->update([
            'name' => $this->name,
            'updated_user_id' => auth()->user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Customer Group : " . $this->name,
            // text: "Customer Group Id : " . $this->id . ", Name : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('customer-group.list'),
        );

        $this->dispatch('close-modal-customer-group');
    }
}
