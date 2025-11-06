<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductCreate extends Component
{
    public $product_name, $brand, $supplier_rep, $principal;
    public $status = '0', $source = '1';

    public function render()
    {
        return view('livewire.product.product-create');
    }

    public function save()
    {
        // dd("Save Product");

        $this->product_name = Str::trim(Str::upper($this->product_name));
        $this->brand = Str::trim($this->brand);
        $this->supplier_rep = Str::trim($this->supplier_rep);
        $this->principal = Str::trim($this->principal);

        $this->validate(
            [
                'product_name' => 'required|unique:products',
                'brand' => 'required',
            ],
            [
                'required' => 'The :attribute field is required !!',
                'unique' => 'The :attribute has already been taken !!',
            ]
        );

        Product::create(
            [
                'product_name' => $this->product_name,
                'brand' => $this->brand,
                'supplier_rep' => $this->supplier_rep,
                'principal' => $this->principal,
                'status' => $this->status,
                'source' => $this->source,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ]
        );

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Product : " . $this->product_name,
            icon: "success",
            timer: 3000,
            // url: route('product.list'),
        );

        $this->dispatch('close-modal-product');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
