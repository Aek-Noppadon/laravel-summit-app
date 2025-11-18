<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    #[On('refresh-product')]
    public function render()
    {
        $departmentId = auth()->user()->department_id;

        $products = Product::where(function ($productQuery) use ($departmentId) {
            $productQuery->where('source', '0')
                ->orWhere('source', '1')
                ->whereHas('userCreated.department', function ($query) use ($departmentId) {
                    $query->where('id', $departmentId);
                });
        })
            ->when($this->search, function ($query) use ($departmentId) {
                $query->where(function ($searchQuery) use ($departmentId) {
                    $searchQuery->where(function ($q) {
                        $q->where('source', '0')
                            ->where(function ($qq) {
                                $qq->where('product_name', 'like', '%' . $this->search . '%')
                                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                                    ->orWhere('supplier_rep', 'like', '%' . $this->search . '%')
                                    ->orWhere('principal', 'like', '%' . $this->search . '%');
                            });
                    })->orWhere(function ($q) use ($departmentId) {
                        $q->where('source', '1')
                            ->whereHas('userCreated.department', function ($query) use ($departmentId) {
                                $query->where('id', $departmentId);
                            })
                            ->where(function ($qq) {
                                $qq->where('product_name', 'like', '%' . $this->search . '%')
                                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                                    ->orWhere('supplier_rep', 'like', '%' . $this->search . '%')
                                    ->orWhere('principal', 'like', '%' . $this->search . '%');
                            });
                    });
                });
            })
            ->orderBy('code')
            ->orderBy('product_name', 'asc')
            ->orderBy('brand', 'asc')
            ->with(['userCreated:id,name,department_id', 'userCreated.department:id,name'])
            ->paginate($this->pagination);

        // if (is_null($this->search)) {
        //     $products = Product::orderBy('source', 'asc')
        //         ->orderBy('brand', 'asc')
        //         ->orderBy('product_name', 'asc')
        //         ->paginate($this->pagination);
        // } else {
        //     $products = Product::Where('product_name', 'like', '%' . $this->search . '%')
        //         ->orWhere('brand', 'like', '%' . $this->search . '%')
        //         ->orWhere('supplier_rep', 'like', '%' . $this->search . '%')
        //         ->orWhere('principal', 'like', '%' . $this->search . '%')
        //         ->orderBy('source', 'asc')
        //         ->orderBy('brand', 'asc')
        //         ->orderBy('product_name', 'asc')
        //         ->paginate($this->pagination);
        // }

        // dd($products);

        return view('livewire.product.product-lists', [
            'products' => $products
        ]);
    }

    public function deleteProduct($id, $product_name)
    {
        $this->dispatch("confirm", id: $id, name: $product_name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        try {

            Product::find($id)->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfuly !!",
                text: "Product : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Can not Deleted !!",
                text: "Product : " . $name . " there is a transaction in CRM.",
                icon: "error",
                // timer: 3000,
            );
        }

        $this->dispatch('close-modal-product');
    }
}
