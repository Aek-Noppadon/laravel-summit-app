<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductEdit extends Component
{
    public $id, $product_name, $brand, $supplier_rep, $principal;

    public function render()
    {
        return view('livewire.product.product-edit');
    }

    #[On('edit-product')]
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->id = $product->id;
        $this->product_name = $product->product_name;
        $this->brand = $product->brand;
        $this->supplier_rep = $product->supplier_rep;
        $this->principal = $product->principal;
    }

    public function save()
    {
        $this->product_name = trim($this->product_name);
        $this->brand = trim($this->brand);
        $this->supplier_rep = trim($this->supplier_rep);
        $this->principal = trim($this->principal);

        /*
         * =================================================================
         Create by Aek 06/11/2025
         Validate unique AX product & product and department befor save
         * =================================================================
        */

        $departmentId = auth()->user()->department_id;

        $exists = Product::where('product_name', $this->product_name)
            ->where('source', 0)
            ->orWhere('product_name', $this->product_name)
            ->where('id', '<>', $this->id)
            ->whereHas('userCreated', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })->exists();

        if ($exists) {
            $this->addError('product_name', 'The product name has already been taken.');
            return;
        }
        // * ================================================   

        $this->validate(
            [
                'product_name' => 'required',
                'brand' => 'required',
            ],
            [
                'required' => 'The :attribute field is required.',
            ]

        );

        // $this->validate(
        //     [
        //         'product_name' => 'required|unique:products,product_name,' . $this->id,
        //         'brand' => 'required',
        //     ],
        //     [
        //         'required' => 'The :attribute field is required !!',
        //         'unique' => 'The :attribute has already been taken !!',
        //     ]
        // );

        $product = Product::findOrFail($this->id);

        $product->update([
            'product_name' => $this->product_name,
            'brand' => $this->brand,
            'supplier_rep' => $this->supplier_rep,
            'principal' => $this->principal,
            'updated_user_id' => auth()->user()->id,
        ]);

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Updated Successfully !!",
            text: "Product : " . $this->product_name,
            // text: "Product Id : " . $this->id . ", Name : " . $this->product_name,
            icon: "success",
            timer: 3000,
        );

        $this->dispatch('close-modal-product');
    }
}
