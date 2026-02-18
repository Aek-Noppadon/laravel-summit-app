<?php

namespace App\Livewire\User;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class UserProfile extends Component
{
    public $departments, $user;
    public $id, $name, $last_name, $email, $sales_id, $department_id;

    public function mount()
    {
        $this->id = Auth::user()->id;

        $user = User::findOrFail($this->id);

        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->department_id = $user->department_id;
        $this->sales_id = $user->sales_id;

        $this->departments = Department::all();
    }

    public function render()
    {
        return view('livewire.user.user-profile');
    }

    public function selectedDepartment()
    {
        $this->departments = Department::all();
    }

    public function save()
    {
        $this->name = Str::trim($this->name);
        $this->last_name = Str::trim($this->last_name);
        $this->email = Str::trim($this->email);
        $this->department_id = $this->department_id;

        $this->validate(
            [
                'name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email,' . $this->id,
                'sales_id' => 'required|min:3|max:3|unique:users,sales_id,' . $this->id,
                'department_id' => 'required',
            ],
            [
                'required' => 'The :attribute field is required !!',
                'min' => 'The :attribute field must be at least 3 characters !!',
                'max' => 'The :attribute field must not be greater than 3 characters !!',
                'unique' => 'The :attribute has already been taken !!',
            ]
        );

        $user = User::findOrFail($this->id);

        $user->update([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'sales_id' => $this->sales_id,
            'department_id' => $this->department_id,
            'updated_at' => Auth::user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "User : " . $this->name . " " . $this->last_name,
            icon: "success",
            timer: 3000,
        );
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
