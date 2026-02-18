<?php

namespace App\Livewire\User;

use App\Models\Department;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UserLists extends Component
{
    use WithPagination;
    public $departments, $department_id;
    public $search;
    public $pagination = 20;

    public function mount()
    {
        $this->departments = Department::all();
    }

    #[On('refresh-user')]
    public function render()
    {
        $users = User::when($this->department_id, function ($query) {
            $query->where('department_id', $this->department_id);
        })
            ->when($this->search, function ($query) {
                $query->where(function ($qSearch) {
                    $qSearch->where('department_id', $this->department_id)
                        ->where('sales_id', 'like', '%' . $this->search . '%')
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('department_id')
            ->orderBy('id')
            ->paginate($this->pagination);

        return view('livewire.user.user-lists', compact('users'));
    }

    public function selectedDepartment()
    {
        $this->departments = Department::all();
    }

    public function deleteUser($id, $first_name, $last_name)
    {
        $this->dispatch("confirm", id: $id, name: $first_name, last_name: $last_name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        try {
            User::find($id)->delete();
            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfuly !!",
                text: "User : " . $name,
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

        $this->dispatch('close-modal-user');
    }
}
