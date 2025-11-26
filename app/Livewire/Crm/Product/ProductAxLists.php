<?php

namespace App\Livewire\Crm\Product;

use App\Models\Product;
use App\Models\SrvProduct;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductAxLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;
    public $source = '0';

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

    #[On('save-product-ax')]
    public function saveProductAx($name)
    {
        // dd("Save AX");

        // ทำมั้ยไม่ใช่ Proudct Code ?

        // $product_ax = DB::connection('sqlsrv2')
        //     ->table('SCC_CRM_PRODUCTS_NEW')
        //     ->where('ProductName', $name)
        //     ->first();

        $product_ax = SrvProduct::where('ProductName', $name)
            ->first();

        if (empty($product_ax->ProductName)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "No have product list",
                text: "Please refresh product",
                // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                icon: "error",
                timer: 3000,
            );
        } else {
            if (empty($product_ax->ProductCode)) {

                // ตรวจสอบสินค้าว่ามีอยู่ใน Database ไหม, ถ้าไม่มีให้ Insert, ถ้ามีให้ Update
                $product = Product::where('product_name', $product_ax->ProductName)
                    ->first();

                if (empty($product)) {
                    Product::create([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'created_user_id' => auth()->user()->id,
                        'updated_user_id' => auth()->user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Created Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                        // url: route('crm.create'),
                    );
                } else {
                    $product->update([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'updated_user_id' => auth()->user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Updated Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                    );
                }
            } else {
                // ตรวจสอบสินค้าว่ามีอยู่ใน Database ไหม, ถ้าไม่มีให้ Insert, ถ้ามีให้ Update
                $product = Product::where('code', $product_ax->ProductCode)
                    ->first();

                if (empty($product)) {
                    Product::create([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'created_user_id' => auth()->user()->id,
                        'updated_user_id' => auth()->user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Created Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                        // url: route('crm.create'),
                    );
                } else {
                    $product->update([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'updated_user_id' => auth()->user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Updated Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                    );
                }
            }
        }

        $this->dispatch('close-modal-product');
    }
}
