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

        if (empty($departmentId)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Unable to add application !!",
                text: "Please fill in the department.",
                icon: "error",
                url: route('user.profile'),
            );
        } else {
            $exists = Application::where('name', $this->name)
                ->whereHas('userCreated', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                })->exists();

            if ($exists) {
                $this->addError('name', 'The application name has already been taken.');
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
            );

            $this->dispatch('close-modal-application');
        }
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
