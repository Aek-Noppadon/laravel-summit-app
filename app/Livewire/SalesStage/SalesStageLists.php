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
        if (is_null($this->search)) {
            $sales_stages = SalesStage::orderBy('id', 'asc')
                ->paginate($this->pagination);
        } else {
            $sales_stages = SalesStage::Where('name', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.sales-stage.sales-stage-lists', [
            'sales_stages' => $sales_stages
        ]);
    }

    public function deleteSalesStage($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        SalesStage::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            text: "Sales Stage : " . $name,
            // text: "Sales Stage Id : " . $id . ", Name : " . $name,
            icon: "success",
            timer: 3000,
            // url: route('sales-stage.list'),
        );

        $this->dispatch('close-modal-sales-stage');
    }
}
