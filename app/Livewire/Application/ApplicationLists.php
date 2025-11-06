<?php

namespace App\Livewire\Application;

use App\Models\Application;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-application')]
    public function render()
    {
        if (is_null($this->search)) {
            $applications = Application::orderBy('name', 'asc')
                ->paginate($this->pagination);
        } else {
            $applications = Application::Where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.application.application-lists', [
            'applications' => $applications
        ]);
    }

    public function deleteApplication($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        Application::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            text: "Application : " . $name,
            // text: "Application Id : " . $id . ", Name : " . $name,
            icon: "success",
            timer: 3000,
            // url: route('application.list'),
        );

        $this->dispatch('close-modal-application');
    }
}
