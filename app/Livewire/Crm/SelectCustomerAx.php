<?php

namespace App\Livewire\Crm;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SelectCustomerAx extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-customer-ax')]
    public function render()
    {
        if (!$this->search) {
            $customers = DB::connection('sqlsrv2')
                ->table('SCC_CRM_CUSTOMERS')
                ->select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
                ->orderBy('CustomerCode')
                ->paginate($this->pagination);

            // dd($customers);
        } else {
            $customers = DB::connection('sqlsrv2')
                ->table('SCC_CRM_CUSTOMERS')
                ->select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
                ->Where('CustomerCode', 'like', '%' . $this->search . '%')
                ->orWhere('CustomerNameEng', 'like', '%' . $this->search . '%')
                ->orWhere('CustomerNameThi', 'like', '%' . $this->search . '%')
                ->orWhere('ParentCode', 'like', '%' . $this->search . '%')
                ->orWhere('ParentName', 'like', '%' . $this->search . '%')
                ->orderBy('CustomerCode')
                ->paginate($this->pagination);
        }

        return view('livewire.crm.select-customer-ax', [
            'customers' => $customers
        ]);
    }
}
