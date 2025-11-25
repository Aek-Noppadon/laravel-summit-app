<?php

namespace App\Livewire\SalesStage;

use App\Models\SalesStage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SalesStageLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-sales-stage')]
    public function render()
    {
        /*
        =======================================================
        Created : Aek Noppadon
        Date    : 19/11/2025
        =======================================================
        Discription :                    
        Show sales stages data by user & department 
        =======================================================
        */

        $sales_stages = SalesStage::orderBy('id')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate();

        // ====================================================

        return view('livewire.sales-stage.sales-stage-lists', compact('sales_stages'));
    }

    public function deleteSalesStage($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        try {
            SalesStage::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Sales Stage : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Can not Deleted !!",
                text: "Sales Stage : " . $name . " there is a transaction in CRM.",
                icon: "error",
            );
        }

        $this->dispatch('close-modal-sales-stage');
    }
}
