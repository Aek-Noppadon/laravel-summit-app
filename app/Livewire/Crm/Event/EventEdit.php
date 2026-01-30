<?php

namespace App\Livewire\Crm\Event;

use App\Models\Event;
use Livewire\Attributes\On;
use Livewire\Component;

class EventEdit extends Component
{
    public $id, $name;

    public function render()
    {
        return view('livewire.crm.event.event-edit');
    }

    #[On('edit-event')]
    public function edit($id)
    {
        $event = Event::findOrFail($id);

        $this->id = $event->id;
        $this->name = $event->name;
    }

    public function save()
    {
        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        $exists = Event::where('name', $this->name)
            ->where('id', '<>', $this->id)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('name', 'The Event name has already been taken.');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ],
            [
                'required' => 'The Event :attribute field is required.',
            ]
        );

        $event = Event::findOrFail($this->id);

        $event->update([
            'name' => $this->name,
            'updated_user_id' => auth()->user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Event : " . $this->name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-event');
    }
}
