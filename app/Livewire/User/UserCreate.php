<?php

namespace App\Livewire\User;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserCreate extends Component
{
    public $departments;
    public $name, $last_name, $email, $sales_id, $department_id, $password, $confirm_password;

    public function mount()
    {
        $this->departments = Department::all();
    }

    public function render()
    {
        return view('livewire.user.user-create');
    }

    public function selectedDepartment()
    {
        $this->departments = Department::all();
    }

    public function save()
    {
        $this->validate(
            [
                "name"          => "required",
                "last_name"     => "required",
                "email"         => "required|unique:users,email",
                "sales_id"      => "required|min:3|max:3|unique:users,sales_id",
                "department_id" => "required",
                "password"      =>  "required|same:confirm_password"
            ],
            [
                "required"      => "The :attribute field is required !!",
                "min"           => "The :attribute field must be at least 3 characters !!",
                "max"           => "The :attribute field must not be greater than 3 characters !!",
                "unique"        => "The :attribute has already been taken !!",
            ]
        );

        $dataUser = [
            "first_name"    => ucfirst(trim($this->name)),
            "last_name"     => ucfirst(trim($this->last_name)),
            "email"         => strtolower(trim($this->email)),
            "sales_id"      => $this->sales_id,
            "department"    => $this->department_id,
            "password"      => Hash::make(trim($this->password)),
        ];


        User::create([
            "name" => $dataUser['first_name'],
            "last_name" => $dataUser['last_name'],
            "email" => $dataUser['email'],
            "sales_id" => $dataUser['sales_id'],
            "department_id" => $dataUser['department'],
            "password" => $dataUser['password'],
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "User : " . $dataUser['first_name'] . " " . $dataUser['last_name'],
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-user');
    }
}
