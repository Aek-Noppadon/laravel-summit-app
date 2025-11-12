<?php

namespace App\Livewire\Crm\CustomerType;

use App\Models\CustomerType;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTypeLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-customer-type')]
    public function render()
    {
        /*
        ==========================================================
        Created : Aek Noppadon
        Date    : 12/11/2025
        ==========================================================
        Discription :                    
        Show customer types data by user & department 
        ==========================================================
        */

        $departmentId = auth()->user()->department_id;

        $customer_types = CustomerType::whereHas('userCreated.department', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate();
        // =======================================================

        return view('livewire.crm.customer-type.customer-type-lists', compact('customer_types'));

        // if (is_null($this->search)) {
        //     $customer_types = CustomerType::orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // } else {
        //     $customer_types = CustomerType::Where('name', 'like', '%' . $this->search . '%')
        //         ->orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // }

        // return view('livewire.crm.customer-type.customer-type-lists', [
        //     'customer_types' => $customer_types
        // ]);
    }

    public function deleteCustomerType($id, $name)
    {
        $this->dispatch("confirm-delete-customer-type", id: $id, name: $name);
    }

    #[On('destroy-customer-type')]
    public function destroy($id, $name)
    {
        CustomerType::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            text: "Customer Type : " . $name,
            // text: "Customer Type Id : " . $id . ", Name : " . $name,
            icon: "success",
            timer: 3000,
            // url: route('customer-type.list'),
        );

        $this->dispatch('close-modal-customer-type');
    }
}
