<?php

namespace App\Livewire\Event;

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
        =======================================================
        Created : Aek Noppadon
        Date    : 06/02/2025
        =======================================================
        Discription :                    
        Show events data by user & department 
        =======================================================
        */

        $departmentId = auth()->user()->department_id;

        $events = Event::where(function ($query) use ($departmentId) {
            $query->where('id', 1)
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhere(function ($query) use ($departmentId) {
                    $query->whereHas('userCreated.department', function ($query) use ($departmentId) {
                        $query
                            ->where('id', $departmentId);
                    })
                        ->when($this->search, function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        });
                });
        })
            ->latest()
            ->paginate($this->pagination);

        // ====================================================

        return view('livewire.event.event-lists', compact('events'));
    }

    public function deleteEvent($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        try {
            Event::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Event : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Cannot Deleted !!",
                text: $name . " there is a transaction in CRM.",
                icon: "error",
            );
        }

        $this->dispatch('close-modal-event');
    }
}
