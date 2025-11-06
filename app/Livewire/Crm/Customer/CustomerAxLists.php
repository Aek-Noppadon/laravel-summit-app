<?php

namespace App\Livewire\Crm\Customer;

use App\Models\SrvCustomer;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerAxLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-customer-ax')]
    public function render()
    {
        if (!$this->search) {
            $customers = SrvCustomer::select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
                ->orderBy('CustomerCode')
                ->paginate($this->pagination);

            // $customers = DB::connection('sqlsrv2')
            //     ->table('SCC_CRM_CUSTOMERS')
            //     ->select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
            //     ->orderBy('CustomerCode')
            //     ->paginate($this->pagination);

        } else {
            $customers = SrvCustomer::select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
                ->Where('CustomerCode', 'like', '%' . $this->search . '%')
                ->orWhere('CustomerNameEng', 'like', '%' . $this->search . '%')
                ->orWhere('CustomerNameThi', 'like', '%' . $this->search . '%')
                ->orWhere('ParentCode', 'like', '%' . $this->search . '%')
                ->orWhere('ParentName', 'like', '%' . $this->search . '%')
                ->orderBy('CustomerCode')
                ->paginate($this->pagination);

            // $customers = DB::connection('sqlsrv2')
            //     ->table('SCC_CRM_CUSTOMERS')
            //     ->select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
            //     ->Where('CustomerCode', 'like', '%' . $this->search . '%')
            //     ->orWhere('CustomerNameEng', 'like', '%' . $this->search . '%')
            //     ->orWhere('CustomerNameThi', 'like', '%' . $this->search . '%')
            //     ->orWhere('ParentCode', 'like', '%' . $this->search . '%')
            //     ->orWhere('ParentName', 'like', '%' . $this->search . '%')
            //     ->orderBy('CustomerCode')
            //     ->paginate($this->pagination);
        }

        return view('livewire.crm.customer.customer-ax-lists', compact('customers'));

        // return view('livewire.crm.customer.customer-ax-lists', [
        //     'customers' => $customers
        // ]);
    }
}
