<?php

namespace App\Livewire\Role;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleCreate extends Component
{
    public $name;
    public $permissions = [];
    public $allPermissions = [];

    public function render()
    {
        $this->allPermissions = Permission::get();

        return view('livewire.role.role-create');
    }

    public function save()
    {
        // Convert checkbox item them to integers
        $this->permissions = collect($this->permissions)->map(fn($val) => (int)$val);

        $this->isCheckValue();

        $this->isValidate();

        $role = Role::create(
            [
                'name' => $this->name,
            ]
        );

        $role->syncPermissions($this->permissions);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Role : " . $this->name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-role');
    }

    public function isCheckValue()
    {
        $this->name = ucfirst(trim($this->name));
    }

    public function isValidate()
    {
        $this->validate([
            'name'        => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
