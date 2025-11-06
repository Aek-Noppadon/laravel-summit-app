<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class DepartmentEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.department.department-edit');
    }

    #[On('edit-department')]
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        $this->id = $department->id;
        $this->name = $department->name;
    }

    public function save()
    {
        $this->name = Str::trim(Str::upper($this->name));

        $this->validate(
            [
                'name' => 'required|unique:departments,name,' . $this->id
            ],
            [
                'required' => 'The department :attribute field is required !!',
                'unique' => 'The department :attribute has already been taken !!',
            ]
        );

        $department = Department::findOrFail($this->id);

        $department->update([
            'name' => $this->name,
            'updated_user_id' => Auth::user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Department : " . $this->name,
            // text: "Department Id : " . $this->id . ", Name : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('department.list'),
        );

        $this->dispatch('close-modal-department');
    }
}
