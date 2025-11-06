<?php

namespace App\Livewire\Crm\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
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
        // dd("Save ");

        $this->product_name = Str::trim(Str::upper($this->product_name));
        $this->brand = Str::trim($this->brand);
        $this->supplier_rep = Str::trim($this->supplier_rep);
        $this->principal = Str::trim($this->principal);

        $departmentId = auth()->user()->department_id;
        // dd($departmentId);

        // $this->id = auth()->user()->id;
        // $this->created_user_id = "";

        // dd($this->product_name . $this->brand . $this->supplier_rep . $this->principal);


        // dd($product);

        $unique_rule = Rule::unique('products')
            ->where(function ($productQuery) use ($departmentId) {
                $productQuery
                    ->where('product_name', $this->product_name)
                    ->whereHas('userCreated.department', function ($query) use ($departmentId) {
                        $query->where('id', $departmentId);
                    });
            });

        $this->validate(
            [
                'product_name' => ['required', $unique_rule],
                'brand' => 'required',
            ],
            [
                'required' => 'The :attribute field is required !!',
                'unique' => 'The :attribute has already been taken !!',
            ]
        );

        // $this->validate(
        //     [
        //         'product_name' => 'required|unique:products',
        //         'brand' => 'required',
        //     ],
        //     [
        //         'required' => 'The :attribute field is required !!',
        //         'unique' => 'The :attribute has already been taken !!',
        //     ]
        // );

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
