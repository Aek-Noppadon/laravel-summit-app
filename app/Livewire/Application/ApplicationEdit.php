<?php

namespace App\Livewire\Application;

use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.application.application-edit');
    }

    #[On('edit-application')]
    public function edit($id)
    {
        $application = Application::findOrFail($id);

        $this->id = $application->id;
        $this->name = $application->name;
    }

    public function save()
    {
        $this->name = Str::trim($this->name);

        $this->validate(
            [
                'name' => 'required|unique:applications,name,' . $this->id
            ],
            [
                'required' => 'The application :attribute field is required !!',
                'unique' => 'The application :attribute has already been taken !!',
            ]
        );

        $application = Application::findOrFail($this->id);

        $application->update([
            'name' => $this->name,
            'updated_user_id' => Auth::user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Application : " . $this->name,
            // text: "Application Id : " . $this->id . ", Name : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('application.list'),
        );

        $this->dispatch('close-modal-application');
    }
}
