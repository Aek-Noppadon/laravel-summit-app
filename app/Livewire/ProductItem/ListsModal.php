<?php

namespace App\Livewire\ProductItem;

use App\Models\ProductItem;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListsModal extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    // เพิ่มฟังก์ชันนี้เพื่อให้ Search ทำงานไม่เพี้ยน
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('refresh-data')]
    public function render()
    {
        $productItems = ProductItem::query()->paginate($this->pagination);

        return view('livewire.product-item.lists-modal', compact('productItems'));
    }
}
