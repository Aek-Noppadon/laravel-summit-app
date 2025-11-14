<?php

namespace App\Livewire\Crm\Application;

use App\Models\Application;
use Livewire\Attributes\On;
use Livewire\Component;

class ApplicationEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.crm.application.application-edit');
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
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = Application::where('name', $this->name)
            ->where('id', '<>', $this->id)
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

        // $this->validate(
        //     [
        //         'name' => 'required|unique:applications,name,' . $this->id
        //     ],
        //     [
        //         'required' => 'The application :attribute field is required !!',
        //         'unique' => 'The application :attribute has already been taken !!',
        //     ]
        // );

        $application = Application::findOrFail($this->id);

        $application->update([
            'name' => $this->name,
            'updated_user_id' => auth()->user()->id,
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
