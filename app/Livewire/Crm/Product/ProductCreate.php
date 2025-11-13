<?php

namespace App\Livewire\Crm\Product;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductCreate extends Component
{
    public $product_name, $brand, $supplier_rep, $principal, $id;
    public $status = '0', $source = '1';

    public function render()
    {
        return view('livewire.crm.product.product-create');
    }

    public function save()
    {
        $this->product_name = strtoupper(trim($this->product_name));
        $this->brand = strtoupper(trim($this->brand));
        $this->supplier_rep = strtoupper(trim($this->supplier_rep));
        $this->principal = strtoupper(trim($this->principal));

        /*
         * =================================================================
         Create by Sun 06/11/2025
         Validate unique AX product & product and department befor save
         * =================================================================
        */

        $departmentId = auth()->user()->department_id;

        $exists = Product::where('product_name', $this->product_name)
            ->where('source', '0')
            ->orWhere('product_name', $this->product_name)
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

        Product::create(
            [
                'product_name' => $this->product_name,
                'brand' => $this->brand,
                'supplier_rep' => $this->supplier_rep,
                'principal' => $this->principal,
                'status' => $this->status,
                'source' => $this->source,
                'created_user_id' => auth()->user()->id,
                'updated_user_id' => auth()->user()->id,
            ]
        );

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Created Successfully !!",
            text: "Product : " . $this->product_name,
            icon: "success",
            timer: 3000,
            // url: route('crm.create'),
        );

        $this->dispatch('close-modal-product');
    }

    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset();
    }
}
