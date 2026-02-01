<?php

namespace App\Livewire\Crm\Event;

use App\Models\Event;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class EventLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;


    #[On('refresh-event')]
    public function render()
    {
        /*
        ==========================================================
        Created : Aek Noppadon
        Date    : 29/01/2026
        ==========================================================
        Discription : Events List user & department 
        ==========================================================
        */

        $departmentId = auth()->user()->department_id;

        $events = Event::whereHas('userCreated.department', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            // ->orderBy('name')
            ->latest()
            ->paginate($this->pagination);
        // =======================================================

        return view('livewire.crm.event.event-lists', compact('events'));
    }

    public function deleteEvent($id, $name)
    {
        $this->dispatch("confirm-delete-event", id: $id, name: $name);
    }

    #[On('destroy-event')]
    public function destroy($id, $name)
    {
        try {
            Event::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Cannot Deleted !!",
                text: "Event : " . $name . " there is a transaction in CRM.",
                icon: "error",
            );
        }

        $this->dispatch('close-modal-event');
    }
}
