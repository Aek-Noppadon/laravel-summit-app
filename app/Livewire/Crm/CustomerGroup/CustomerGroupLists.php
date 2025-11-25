<?php

namespace App\Livewire\Crm\CustomerGroup;

use App\Models\CustomerGroup;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerGroupLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-customer-group')]
    public function render()
    {
        /*
        =======================================================
        Created : Aek Noppadon
        Date    : 12/11/2025
        =======================================================
        Discription :                    
        Show customer group data by user & department 
        =======================================================
        */

        $departmentId = auth()->user()->department_id;

        $customer_groups = CustomerGroup::whereHas('userCreated', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate();
        // ====================================================

        return view('livewire.crm.customer-group.customer-group-lists', compact('customer_groups'));

        // if (is_null($this->search)) {
        //     $customer_groups = CustomerGroup::orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // } else {
        //     $customer_groups = CustomerGroup::Where('name', 'like', '%' . $this->search . '%')
        //         ->orderBy('id', 'asc')
        //         ->paginate($this->pagination);
        // }

        // return view('livewire.crm.customer-group.customer-group-lists', [
        //     'customer_groups' => $customer_groups
        // ]);
    }

    public function deleteCustomerGroup($id, $name)
    {
        $this->dispatch("confirm-delete-customer-group", id: $id, name: $name);
    }

    #[On('destroy-customer-group')]
    public function destroy($id, $name)
    {
        try {
            CustomerGroup::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Customer Group : " . $name,
                // text: "Customer Group Id : " . $id . ", Name : " . $name,
                icon: "success",
                timer: 3000,
                // url: route('customer-group.list'),
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Can not Deleted !!",
                text: "Customer group : " . $name . " there is a transaction in CRM.",
                icon: "error",
                // timer: 3000,
            );
        }

        $this->dispatch('close-modal-customer-group');
    }
}
