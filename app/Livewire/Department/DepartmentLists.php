<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-department')]
    public function render()
    {
        $departments = Department::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->orderBy('id')
            ->paginate($this->pagination);

        return view('livewire.department.department-lists', [
            'departments' => $departments
        ]);
    }

    public function deleteDepartment($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        Department::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            text: "Department : " . $name,
            // text: "Department Id : " . $id . ", Name : " . $name,
            icon: "success",
            timer: 3000,
            // url: route('department.list'),
        );

        $this->dispatch('close-modal-department');
    }
}
