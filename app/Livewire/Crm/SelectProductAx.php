<?php

namespace App\Livewire\Crm;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SelectProductAx extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-product-ax')]
    public function render()
    {
        if (!$this->search) {
            $products = DB::connection('sqlsrv2')
                ->table('SCC_CRM_PRODUCTS_NEW')
                // ->orderBy('ProductCode')
                ->orderBy('ProductName')
                ->paginate($this->pagination);
        } else {
            $products = DB::connection('sqlsrv2')
                ->table('SCC_CRM_PRODUCTS_NEW')
                ->where('ProductName', 'LIKE', '%' . $this->search . '%')
                ->orWhere('ProductBrand', 'LIKE', '%' . $this->search . '%')
                ->orWhere('SupplierRep', 'LIKE', '%' . $this->search . '%')
                ->orWhere('Principal', 'LIKE', '%' . $this->search . '%')
                // ->orderBy('ProductCode')
                ->orderBy('ProductName')
                ->paginate($this->pagination);
        }

        return view('livewire.crm.select-product-ax', [
            'products' => $products
        ]);
    }
}
