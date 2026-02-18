<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Livewire\Attributes\On;
use Livewire\Component;

class EventCreate extends Component
{
    public $name;

    public function render()
    {
        return view('livewire.event.event-create');
    }

    public function save()
    {

        $this->name = trim($this->name);

        $departmentId = auth()->user()->department_id;

        if (empty($departmentId)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Unable to add event !!",
                text: "Please fill in the department.",
                icon: "error",
                url: route('user.profile'),
            );
        } else {
            $exists = Event::where('name', $this->name)
                ->whereHas('userCreated', function ($query) use ($departmentId) {
                    $query->where('department_id', $departmentId);
                })->exists();

            if ($exists) {
                $this->addError('name', 'The event name has already been taken.');
                return;
            }

            $this->validate(
                [
                    'name' => 'required',
                ],
                [
                    'required' => 'The event :attribute field is required.',
                ]
            );

            Event::create(
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
                text: "Event : " . $this->name,
                icon: "success",
                timer: 3000,
            );

            $this->dispatch('close-modal-event');
        }
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
