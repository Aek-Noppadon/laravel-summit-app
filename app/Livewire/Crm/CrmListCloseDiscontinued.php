<?php

namespace App\Livewire\Crm;

use App\Models\CrmDetail;
use App\Models\CrmHeader;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CrmListCloseDiscontinued extends Component
{
    use WithPagination;
    public $pagination = 20;
    public $isOpenId = null;
    public $isOpenSearch = true;
    public $yearAgo, $userId;
    public $backDate = 2;

    #[On('refresh-crm')]
    public function render()
    {
        // $this->yearAgo = Carbon::now()->subYear($this->yearAgo);
        $this->yearAgo = Carbon::now()->subYear($this->backDate);

        $this->userId = auth()->user()->id;

        $crms = CrmHeader::where(function ($query) {
            $query->where('original_user_id', $this->userId);
        })->where(function ($query) {
            $query->where('estimate_date', '<=', $this->yearAgo);
        })
            ->whereHas('crm_items', function ($query) {
                $query->whereIn('sales_stage_id', [1, 2, 3]);
            })
            ->withCount('crm_items')
            ->orderByDesc('document_no')
            // ->orderByDesc('estimate_date')
            ->paginate($this->pagination);

        return view('livewire.crm.crm-list-close-discontinued', compact('crms'));
    }

    public function toggleSearch($value)
    {
        $this->isOpenSearch = ($this->isOpenSearch === $value) ? null : $value;

        $this->isOpenId = null;
    }

    public function toggle($id)
    {
        $this->isOpenId = ($this->isOpenId === $id) ? null : $id;

        $this->isOpenSearch = true;
    }

    public function crmDiscontinued($id, $document_no, $name_english)
    {
        $this->dispatch("confirm", id: $id, document_no: $document_no, name_english: $name_english);
    }

    #[On('discontinued')]
    public function discontinued($id, $document_no, $name_english)
    {

        CrmDetail::where('crm_id', $id)
            ->whereIn('sales_stage_id', [1, 2, 3])
            ->update([
                'updated_visit_date' => now()->format('Y-m-d'),
                'sales_stage_id' => 6
            ]);

        // Loop through the collection to save each model individually 
        // $crmDetails = CrmDetail::where('crm_id', $id)
        //     ->whereIn('sales_stage_id', [1, 2, 3])
        //     ->get();

        // foreach ($crmDetails as $item) {
        //     $item->updated_visit_date = now()->format('Y-m-d');
        //     $item->sales_stage_id = 6;
        //     $item->save();
        // }

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Discontinued Successfully !!",
            text: $document_no . " : " . $name_english,
            icon: "success",
            timer: 3000,
            url: route('crm.list.close.discontinued'),
        );
    }
}
