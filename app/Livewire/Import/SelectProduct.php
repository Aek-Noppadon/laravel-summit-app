<?php

namespace App\Livewire\Import;

use App\Models\Product;
use Livewire\Component;

class SelectProduct extends Component
{
    protected $selectProducts = [];

    public function render()
    {
        $products = Product::where('prod_status', 1)->get();

        // dd($products);

        return view('livewire.import.select-product', [
            'products' => $products
        ]);
    }


    // public function selectedProduct($id)
    // {
    //     dd('SelectProduct: ' . $id);

    //     $product = Product::findOrFail($id);

    //     $this->selectProducts[] = [
    //         'product_id' => $product->id,
    //         'product_name' => $product->prod_name,
    //     ];
    // }

    // public function showProducts()
    // {
    //     dd($this->selectProducts);
    // }
}
