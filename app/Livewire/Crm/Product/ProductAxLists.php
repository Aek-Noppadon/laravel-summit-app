<?php

namespace App\Livewire\Crm\Product;

use App\Models\SrvProduct;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductAxLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-product-ax')]
    public function render()
    {
        if (!$this->search) {
            $products = SrvProduct::orderBy('ProductName')
                ->paginate($this->pagination);
        } else {
            $products = SrvProduct::where('ProductName', 'LIKE', '%' . $this->search . '%')
                ->orWhere('ProductBrand', 'LIKE', '%' . $this->search . '%')
                ->orWhere('SupplierRep', 'LIKE', '%' . $this->search . '%')
                ->orWhere('Principal', 'LIKE', '%' . $this->search . '%')
                ->orderBy('ProductName')
                ->paginate($this->pagination);
        }

        // if (!$this->search) {
        //     $products = DB::connection('sqlsrv2')
        //         ->table('SCC_CRM_PRODUCTS_NEW')
        //         // ->orderBy('ProductCode')
        //         ->orderBy('ProductName')
        //         ->paginate($this->pagination);
        // } else {
        //     $products = DB::connection('sqlsrv2')
        //         ->table('SCC_CRM_PRODUCTS_NEW')
        //         ->where('ProductName', 'LIKE', '%' . $this->search . '%')
        //         ->orWhere('ProductBrand', 'LIKE', '%' . $this->search . '%')
        //         ->orWhere('SupplierRep', 'LIKE', '%' . $this->search . '%')
        //         ->orWhere('Principal', 'LIKE', '%' . $this->search . '%')
        //         // ->orderBy('ProductCode')
        //         ->orderBy('ProductName')
        //         ->paginate($this->pagination);
        // }

        return view('livewire.crm.product.product-ax-lists', compact('products'));
    }

    // public function render()
    // {
    //     return view('livewire.crm.product.product-ax-lists');
    // }
}
