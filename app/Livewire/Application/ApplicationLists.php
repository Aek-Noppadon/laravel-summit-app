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
        /*
        =======================================================
        Created : Aek Noppadon
        Date    : 12/11/2025
        =======================================================
        Discription :                    
        Show applications data by user & department 
        =======================================================
        */

        $departmentId = auth()->user()->department_id;

        $applications = Application::whereHas('userCreated.department', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate($this->pagination);

        // ====================================================

        return view('livewire.application.application-lists', compact('applications'));
    }

    public function deleteApplication($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        try {
            Application::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Application : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Can not Deleted !!",
                text: "Application : " . $name . " there is a transaction in CRM.",
                icon: "error",
            );
        }

        $this->dispatch('close-modal-application');
    }
}
