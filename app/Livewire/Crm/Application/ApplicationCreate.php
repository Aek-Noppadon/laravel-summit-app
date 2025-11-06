<?php

namespace App\Livewire\Crm\Application;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.crm.application.application-create');
    }

    public function save()
    {
        // dd("Save");

        $this->name = Str::trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:applications',
            ],
            [
                'required' => 'The application :attribute field is required !!',
                'unique' => 'The application :attribute has already been taken !!',
            ]
        );

        Application::create(
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
            text: "Application : " . $this->name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-application');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
