<?php

namespace App\Livewire\Crm\CustomerType;

use App\Models\CustomerType;
use Livewire\Attributes\On;
use Livewire\Component;

class CustomerTypeCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.crm.customer-type.customer-type-create');
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        if (empty($departmentId)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Unable to add customer type !!",
                text: "Please fill in the department.",
                icon: "error",
                url: route('user.profile'),
            );
        } else {
            $exists = CustomerType::where('name', $this->name)
                ->whereHas('userCreated', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                })->exists();

            if ($exists) {
                $this->addError('name', 'The customer type name has already been taken.');
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

            CustomerType::create(
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
                text: "Customer Type : " . $this->name,
                icon: "success",
                timer: 3000,
                // url: route('customer-type.list'),
            );

            $this->dispatch('close-modal-customer-type');
        }
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
