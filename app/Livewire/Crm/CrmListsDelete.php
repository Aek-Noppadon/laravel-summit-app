<?php

namespace App\Livewire\Crm;

use App\Models\CrmDetail;
use App\Models\CrmHeader;
use App\Models\CustomerGroup;
use App\Models\CustomerType;
use App\Models\SalesStage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CrmListsDelete extends Component
{
    use WithPagination;
    public $departmentId;
    public $search_start_visit, $search_end_visit, $search_start_estimate_date, $search_end_estimate_date, $search_start_update_visit, $search_end_update_visit;
    public $search_customer, $search_customer_type, $search_customer_group, $search_contact, $search_sales_stage, $search_product;
    public $pagination = 20;
    public $paginationItem = 20;
    public $isOpenId = null;
    public $isOpenSearch = true;
    public $isOpenSearchItem = true;
    public $customerTypes, $customerGroups, $salesStages;

    public function mount()
    {
        $this->departmentId = auth()->user()->department_id;

        $this->customerTypes = CustomerType::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })
            ->orderBy('name')
            ->get();

        $this->customerGroups = CustomerGroup::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })
            ->orderBy('name')
            ->get();

        $this->salesStages = SalesStage::all();
    }

    public function render()
    {
        $userId = auth()->user()->id;

        $crms = CrmHeader::onlyTrashed()
            ->where(function ($userQuery) use ($userId) {
                $userQuery->where('created_user_id', $userId);
            })
            ->when($this->search_start_visit, function ($startVisitQuery) {
                if ($this->search_start_visit && $this->search_end_visit) {
                    $startVisitQuery->whereBetween('started_visit_date', [$this->search_start_visit, $this->search_end_visit]);
                }
            })
            ->when($this->search_start_estimate_date, function ($estimateDateQuery) {
                if ($this->search_start_estimate_date && $this->search_end_estimate_date) {
                    $estimateDateQuery->whereBetween('month_estimate_date', [$this->search_start_estimate_date, $this->search_end_estimate_date]);
                }
            })
            ->when($this->search_contact, function ($contactQuery) {
                $contactQuery->where('contact', 'like', '%' . $this->search_contact . '%');
            })
            ->when($this->search_customer_type, function ($customerTypeQuery) {
                $customerTypeQuery->where('customer_type_id', $this->search_customer_type);
            })
            ->when($this->search_customer_group, function ($customerGroupQuery) {
                $customerGroupQuery->where('customer_group_id', $this->search_customer_group);
            })
            ->when($this->search_customer, function ($query) use ($userId) {
                $query->whereHas('customer', function ($customerQuery) {
                    $customerQuery->where('code', 'like', '%' . $this->search_customer . '%')
                        ->orWhere('name_english', 'like', '%' . $this->search_customer . '%');
                })
                    ->where(function ($userQuery) use ($userId) {
                        $userQuery->where('created_user_id', $userId);
                    });
            })
            ->when($this->search_start_update_visit, function ($query) {
                if ($this->search_start_update_visit && $this->search_end_update_visit) {
                    $query->whereHas('crm_items_deleted', function ($startVisitUpdateQuery) {
                        $startVisitUpdateQuery->whereBetween('update_visit', [$this->search_start_update_visit, $this->search_end_update_visit]);
                    });
                }
            })
            ->when($this->search_sales_stage, function ($query) {
                $query->whereHas('crm_items_deleted', function ($salesStageQuery) {
                    $salesStageQuery->where('sales_stage_id', $this->search_sales_stage);
                });
            })
            ->when($this->search_product, function ($query) use ($userId) {
                $query->whereHas('crm_items_deleted.product', function ($productQuery) {
                    $productQuery->where('product_name', 'like', '%' . $this->search_product . '%')
                        ->orWhere('brand', 'like', '%' . $this->search_product . '%');
                })
                    ->where(function ($userQuery) use ($userId) {
                        $userQuery->where('created_user_id', $userId);
                    });
            })
            ->with(['crm_items_deleted.product'])

            ->withCount('crm_items_deleted')
            ->orderByDesc('deleted_at')
            ->paginate($this->pagination);

        $crmDetails =   CrmDetail::onlyTrashed()
            ->whereHas('crmHeader', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->where('created_user_id', auth()->id())
            ->orderByDesc('deleted_at')
            ->paginate($this->paginationItem);

        return view('livewire.crm.crm-lists-delete', compact('crms', 'crmDetails'));
    }

    public function toggleSearch($value)
    {
        $this->isOpenSearch = ($this->isOpenSearch === $value) ? null : $value;

        $this->isOpenId = null;
    }

    public function toggleSearchItem($value)
    {
        $this->isOpenSearchItem = ($this->isOpenSearchItem === $value) ? null : $value;
    }

    public function toggle($id)
    {
        $this->isOpenId = ($this->isOpenId === $id) ? null : $id;

        $this->isOpenSearch = true;
    }

    public function confirmRestoreCrm($id, $document_no, $name_english)
    {
        $this->dispatch("confirmRestoreCrm", id: $id, document_no: $document_no, name_english: $name_english);
    }

    #[On('restoreCrm')]
    public function restoreCrm($id, $document_no, $name_english)
    {
        CrmHeader::withTrashed()
            ->where('id', $id)
            ->restore();

        CrmDetail::withTrashed()
            ->where('crm_id', $id)
            ->restore();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Restored Successfully !!",
            text: $document_no . ", Customer: " . $name_english,
            icon: "success",
            timer: 3000,
            url: route('crm.list.delete'),
        );
    }

    public function confirmRestoreCrmItem($id, $document_no, $product_name)
    {
        $this->dispatch("confirmRestoreCrmItem", id: $id, document_no: $document_no, product_name: $product_name);
    }

    #[On('restoreCrmItem')]
    public function restoreCrmItem($id, $document_no, $product_name)
    {
        CrmDetail::withTrashed()
            ->where('id', $id)
            ->restore();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Restored Successfully !!",
            text: $document_no . ", Product: " . $product_name,
            icon: "success",
            timer: 3000,
            url: route('crm.list.delete'),
        );
    }

    public function confirmDeleteCrm($id, $document_no, $name_english)
    {
        $this->dispatch("confirmCrm", id: $id, document_no: $document_no, name_english: $name_english);
    }

    #[On('destroyCrm')]
    public function destroyCrm($id, $document_no, $name_english)
    {
        CrmHeader::withTrashed()
            ->where('id', $id)
            ->forceDelete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            html: $document_no . "<br>" . $name_english,
            icon: "success",
            timer: 3000,
            url: route('crm.list.delete'),
        );
    }

    public function confirmDeleteCrmItem($id, $document_no, $product_name)
    {
        $this->dispatch("confirmDeleteCrmItem", id: $id, document_no: $document_no, product_name: $product_name);
    }

    #[On('destroyCrmItem')]
    public function destroyCrmItem($id, $document_no, $product_name)
    {
        CrmDetail::withTrashed()
            ->where('id', $id)
            ->forceDelete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            html: $document_no . "<br>" . $product_name,
            icon: "success",
            timer: 3000,
            url: route('crm.list.delete'),
        );
    }
}
