<?php

namespace App\Livewire\Crm;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class SelectProduct extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-product')]
    public function render()
    {
        if (is_null($this->search)) {
            $products = Product::orderBy('source', 'asc')
                ->orderBy('brand', 'asc')
                ->orderBy('product_name', 'asc')
                ->paginate($this->pagination);
        } else {
            $products = Product::Where('product_name', 'like', '%' . $this->search . '%')
                ->orWhere('brand', 'like', '%' . $this->search . '%')
                ->orWhere('supplier_rep', 'like', '%' . $this->search . '%')
                ->orWhere('principal', 'like', '%' . $this->search . '%')
                ->orderBy('source', 'asc')
                ->orderBy('brand', 'asc')
                ->orderBy('product_name', 'asc')
                ->paginate($this->pagination);
        }

        // dd($products);

        return view('livewire.crm.select-product', [
            'products' => $products
        ]);
    }

    public function deleteProduct($id, $product_name)
    {
        $this->dispatch("confirm-delete-product", id: $id, name: $product_name);
    }

    #[On('destroy-product')]
    public function destroy($id, $name)
    {
        Product::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfuly !!",
            text: "Product : " . $name,
            icon: "success",
            timer: 3000,
            // url: route('product.list'),
        );

        $this->dispatch('close-modal-product');
    }
}
