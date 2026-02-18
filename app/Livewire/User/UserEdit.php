<?php

namespace App\Livewire\User;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;

class UserEdit extends Component
{
    public $departments, $user;
    public $id, $sales_id, $name, $last_name, $email, $department_id, $password, $confirm_password;

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function render()
    {
        return view('livewire.user.user-edit');
    }

    public function selectedDepartment()
    {
        $this->departments = Department::all();
    }

    #[On('edit-user')]
    public function edit($id)
    {
        $this->user = User::findOrFail($id);

        $this->id = $this->user->id;
        $this->sales_id = $this->user->sales_id;
        $this->name = $this->user->name;
        $this->last_name = $this->user->last_name;
        $this->email = $this->user->email;
        $this->department_id = $this->user->department_id;
    }

    public function save()
    {
        $this->validate(
            [
                "name"          => "required",
                "last_name"     => "required",
                "email"         => "required|unique:users,email," . $this->id,
                "sales_id"      => "required|min:3|max:3|unique:users,sales_id," . $this->id,
                "department_id" => "required",
                "password"      =>  "same:confirm_password"
            ],
            [
                "required"      => "The :attribute field is required !!",
                "min"           => "The :attribute field must be at least 3 characters !!",
                "max"           => "The :attribute field must not be greater than 3 characters !!",
                "unique"        => "The :attribute has already been taken !!",
            ]
        );

        $this->user->name = ucfirst(trim($this->name));
        $this->user->last_name = ucfirst(trim($this->last_name));
        $this->user->email = strtolower(trim($this->email));
        $this->user->sales_id = $this->sales_id;
        $this->user->department_id = $this->department_id;

        if ($this->password) {
            $this->user->password = Hash::make(trim($this->password));
        }

        $this->user->save();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "User : " . $this->name . " " . $this->last_name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-user');
    }
}
