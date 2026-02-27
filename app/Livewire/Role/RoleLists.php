<?php

namespace App\Livewire\Role;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleLists extends Component
{
    #[On('refresh-role')]
    public function render()
    {
        $roles = Role::get();

        return view('livewire.role.role-lists', compact('roles'));
    }

    public function deleteRole($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        try {
            Role::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Role : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Cannot Deleted !!",
                text: $name . " there is a transaction in CRM.",
                icon: "error",
            );
        }

        $this->dispatch('close-modal-role');
    }
}
