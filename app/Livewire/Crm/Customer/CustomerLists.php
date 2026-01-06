<?php

namespace App\Livewire\Crm\Customer;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-customer')]
    public function render()
    {
        // ================================================================================
        // Created by Sun 20/10/2025
        // ================================================================================
        $departmentId = auth()->user()->department_id;

        $customers = Customer::where(function ($customerQuery) use ($departmentId) {
            $customerQuery->where('source', 0)
                ->orWhere(function ($q) use ($departmentId) {
                    $q->where('source', 1)
                        ->whereHas('userCreated.department', function ($query) use ($departmentId) {
                            $query
                                ->where('id', $departmentId);
                        });
                });
        })
            ->when($this->search, function ($query) use ($departmentId) {
                $query->where(function ($searchQuery) use ($departmentId) {
                    $searchQuery->where(function ($q) {
                        $q->where('source', 0)
                            ->where(function ($qq) {
                                $qq->where('code', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_english', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_thai', 'like', '%' . $this->search . '%')
                                    ->orWhere('parent_code', 'like', '%' . $this->search . '%');
                            });
                    })->orWhere(function ($q) use ($departmentId) {
                        $q->where('source', 1)
                            ->whereHas('userCreated.department', function ($query) use ($departmentId) {
                                $query->where('id', $departmentId);
                            })
                            ->where(function ($qq) {
                                $qq->where('code', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_english', 'like', '%' . $this->search . '%')
                                    ->orWhere('name_thai', 'like', '%' . $this->search . '%')
                                    ->orWhere('parent_code', 'like', '%' . $this->search . '%');
                            });
                    });
                });
            })
            ->orderBy('code', 'asc')
            ->with(['userCreated:id,name,department_id', 'userCreated.department:id,name'])
            ->paginate($this->pagination);

        // ================================================================================

        return view('livewire.crm.customer.customer-lists', compact('customers'));

        // if (is_null($this->search)) {
        //     $customers = Customer::orderBy('code', 'asc')
        //         ->paginate($this->pagination);
        // } else {
        //     $customers = Customer::Where('code', 'like', '%' . $this->search . '%')
        //         ->orWhere('name_english', 'like', '%' . $this->search . '%')
        //         ->orWhere('name_thai', 'like', '%' . $this->search . '%')
        //         ->orWhere('parent_code', 'like', '%' . $this->search . '%')
        //         ->orderBy('code', 'asc')
        //         ->paginate($this->pagination);
        // }

        // return view('livewire.crm.customer.customer-lists', [
        //     'customers' => $customers
        // ]);
    }

    public function deleteCustomer($id, $customer_name)
    {
        $this->dispatch("confirm-delete-customer", id: $id, name: $customer_name);
    }

    #[On('destroy-customer')]
    public function destroy($id, $name)
    {
        try {

            Customer::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfuly !!",
                text: "Customer : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Can not Deleted !!",
                text: "Customer : " . $name . " there is a transaction in CRM.",
                icon: "error",
                // timer: 3000,
            );
        }

        $this->dispatch('close-modal-customer');
    }
}
