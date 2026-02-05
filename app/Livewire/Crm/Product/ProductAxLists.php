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
    public $source = 0;

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

        return view('livewire.crm.product.product-ax-lists', compact('products'));
    }

    #[On('save-product-ax')]
    public function saveProductAx($product_code, $product_name, $product_brand, $supplier_rep, $principal)
    {
        // dd($product_code, $product_name, $product_brand, $supplier_rep, $principal);

        $productAx = SrvProduct::where('ProductName', $product_name)
            ->where('ProductBrand', $product_brand)
            ->where('SupplierRep', $supplier_rep)
            ->where('Principal', $principal)
            ->first();

        if (empty($productAx)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "No have product list",
                text: "Please refresh product",
                icon: "error",
                timer: 3000,
            );
            return;
        }

        if ($productAx) {
            // Update product name to product master
            $product = Product::where('product_name', $productAx->ProductName)
                ->where('brand', $productAx->ProductBrand)
                ->where('supplier_rep', $supplier_rep)
                ->where('principal', $principal)
                ->first();

            if ($product) {
                $product->update([
                    'code' => $productAx->ProductCode,
                    'product_name' => $productAx->ProductName,
                    'brand' => $productAx->ProductBrand,
                    'supplier_rep' => $productAx->SupplierRep,
                    'principal' => $productAx->Principal,
                    'status' => $productAx->Status,
                    'source' => $this->source,
                    'updated_user_id' => auth()->user()->id,
                ]);
                $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "Updated Successfully !!",
                    text: "Product : " . $productAx->ProductName,
                    icon: "success",
                    timer: 3000,
                );

                // Insert product name to product master
            } else {
                Product::create([
                    'code' => $productAx->ProductCode,
                    'product_name' => $productAx->ProductName,
                    'brand' => $productAx->ProductBrand,
                    'supplier_rep' => $productAx->SupplierRep,
                    'principal' => $productAx->Principal,
                    'status' => $productAx->Status,
                    'source' => $this->source,
                    'created_user_id' => auth()->user()->id,
                    'updated_user_id' => auth()->user()->id,
                ]);

                $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "Created Successfully !!",
                    text: "Product : " . $productAx->ProductName,
                    icon: "success",
                    timer: 3000,
                );
            }
        }

        $this->dispatch('close-modal-product');
    }
}
