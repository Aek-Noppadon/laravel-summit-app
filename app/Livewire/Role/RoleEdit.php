<?php

namespace App\Livewire\Role;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleEdit extends Component
{
    public $id, $name, $role;
    public $allPermissions = [];
    public $permissions = [];

    public function mount()
    {
        $this->allPermissions = Permission::get();
    }

    public function render()
    {
        return view('livewire.role.role-edit');
    }

    #[On('edit-role')]
    public function edit($id)
    {
        $this->role = Role::findOrFail($id);

        $this->id = $this->role->id;
        $this->name = $this->role->name;
        $this->id = $this->role->id;
        $this->name = $this->role->name;
        $this->permissions = $this->role->permissions()->pluck("id");
    }

    public function save()
    {
        $this->name = trim($this->name);

        // Convert checkbox item them to integers
        $this->permissions = collect($this->permissions)->map(fn($val) => (int)$val);

        $this->isCheckValue();

        $this->isValidate();

        $this->role->name = $this->name;

        $this->role->save();

        $this->role->syncPermissions($this->permissions);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
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
            'name'        => 'required|unique:roles,name,' . $this->role->id,
            'permissions' => 'required',
        ]);
    }
}
