<?php

namespace App\Livewire\Application;

use App\Models\Application;
use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.application.application-create');
    }

    public function save()
    {

        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = Application::where('name', $this->name)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name', 'This application name has already been taken.');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => 'The application :attribute field is required.',
            ]
        );

        Application::create(
            [
                'name' => $this->name,
                'created_user_id' => auth()->user()->id,
                'updated_user_id' => auth()->user()->id,
            ]
        );

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Application : " . $this->name,
            icon: "success",
            timer: 3000,
            // url: route('application.list'),
        );

        $this->dispatch('close-modal-application');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
