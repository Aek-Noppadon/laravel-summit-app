<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class DepartmentCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.department.department-create');
    }

    public function save()
    {
        // dd("Save");

        $this->name = Str::trim(Str::upper($this->name));

        $this->validate(
            [
                'name' => 'required|unique:departments',
            ],
            [
                'required' => 'The department :attribute field is required !!',
                'unique' => 'The department :attribute has already been taken !!',
            ]
        );

        Department::create(
            [
                'name' => $this->name,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ]
        );

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Department : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('department.list'),
        );

        $this->dispatch('close-modal-department');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
