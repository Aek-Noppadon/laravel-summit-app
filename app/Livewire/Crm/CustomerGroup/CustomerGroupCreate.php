<?php

namespace App\Livewire\Crm\CustomerGroup;

use App\Models\CustomerGroup;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerGroupCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.crm.customer-group.customer-group-create');
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        if (empty($departmentId)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Unable to add customer group !!",
                text: "Please fill in the department.",
                icon: "error",
                url: route('user.profile'),
            );
        } else {
            $exists = CustomerGroup::where('name', $this->name)
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

            CustomerGroup::create(
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
                text: "Customer Group : " . $this->name,
                icon: "success",
                timer: 3000,
                // url: route('customer-group.list'),
            );

            $this->dispatch('close-modal-customer-group');
        }
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
