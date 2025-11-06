<?php

namespace App\Livewire\Crm;

use App\Models\Customer;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SelectCustomer extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-customer')]
    public function render()
    {
        if (is_null($this->search)) {
            $customers = Customer::orderBy('code', 'asc')
                ->paginate($this->pagination);
        } else {
            $customers = Customer::Where('code', 'like', '%' . $this->search . '%')
                ->orWhere('name_english', 'like', '%' . $this->search . '%')
                ->orWhere('name_thai', 'like', '%' . $this->search . '%')
                ->orWhere('parent_code', 'like', '%' . $this->search . '%')
                ->orderBy('code', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.crm.select-customer', [
            'customers' => $customers
        ]);
    }

    public function deleteCustomer($id, $customer_name)
    {
        $this->dispatch("confirm-delete-customer", id: $id, name: $customer_name);
    }

    #[On('destroy-customer')]
    public function destroy($id, $name)
    {
        Customer::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfuly !!",
            text: "Customer : " . $name,
            // text: "Customer : " . $id . " - " . $name,
            icon: "success",
            timer: 3000,
            // url: route('customer.list'),
        );

        $this->dispatch('close-modal-customer');
    }
}
