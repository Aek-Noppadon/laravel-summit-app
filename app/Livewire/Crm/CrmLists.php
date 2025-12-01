<?php

namespace App\Livewire\Crm;

use App\Models\CrmDetail;
use App\Models\CrmHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CrmLists extends Component
{
    // use WithPagination;
    // public $search;
    public $search_customer, $search_contact, $search_product;
    public $pagination = 20;
    public $isOpenId = null;

    public function toggle($id)
    {
        $this->isOpenId = ($this->isOpenId === $id) ? null : $id;
    }

    public function render()
    {

        // $crms = CrmHeader::with('customer:id,code,name_english')
        //     ->with('crm_items:id,product_id')
        //     ->with('crm_items.product:id,product_name,brand,supplier_rep,principal')
        //     ->withCount('crm_items')
        //     ->get();

        // $crms = CrmHeader::with('customer:id,code,name_english')
        //     ->with('crm_items:id,product_id')
        //     ->with('crm_items.product:id,product_name,brand,supplier_rep,principal')
        //     ->withCount('crm_items')
        //     ->when($this->search, function ($query) {
        //         $query->whereHas('customer', function ($customerQuery) {
        //             $customerQuery->where('customer.name', 'like', '%' . $this->search . '%');
        //         });
        //     })
        //     ->get();

        $userId = auth()->user()->id;

        // $crms = CrmHeader::where(function ($userQuery) use ($userId) {
        //     $userQuery->where('created_user_id', $userId);
        // })
        //     ->when($this->search, function ($query) use ($userId) {
        //         $query->whereHas('customer', function ($customerQuery) {
        //             $customerQuery->where('name_english', 'like', '%' . $this->search . '%');
        //         });
        //         //->orWhere
        //     })

        // $crms = CrmHeader::where(function ($userQuery) use ($userId) {
        //     $userQuery->where('created_user_id', $userId);
        // })
        //     ->when($this->search, function ($query) use ($userId) {
        //         $query->whereHas('customer', function ($customerQuery) {
        //             $customerQuery->where('code', 'like', '%' . $this->search . '%')
        //                 ->orWhere('name_english', 'like', '%' . $this->search . '%');
        //         })
        //             ->where(function ($userQuery) use ($userId) {
        //                 $userQuery->where('created_user_id', $userId);
        //             })
        //             ->orWhere(function ($query) use ($userId) {
        //                 $query->whereHas('crm_items.product', function ($productQuery) {
        //                     $productQuery->where('product_name', 'like', '%' . $this->search . '%')
        //                         ->orWhere('brand', 'like', '%' . $this->search . '%');
        //                 })
        //                     ->where(function ($userQuery) use ($userId) {
        //                         $userQuery->where('created_user_id', $userId);
        //                     });
        //             });
        //     })

        // $crms = CrmHeader::where(function ($userQuery) use ($userId) {
        //     $userQuery->where('created_user_id', $userId);
        // })
        //     ->when($this->search_customer, function ($query) use ($userId) {
        //         $query->whereHas('customer', function ($customerQuery) {
        //             $customerQuery->where('code', 'like', '%' . $this->search_customer . '%')
        //                 ->orWhere('name_english', 'like', '%' . $this->search_customer . '%');
        //         })
        //             ->where(function ($userQuery) use ($userId) {
        //                 $userQuery->where('created_user_id', $userId);
        //             });
        //     })
        //     ->when($this->search_product, function ($query) use ($userId) {
        //         $query->whereHas('crm_items.product', function ($productQuery) {
        //             $productQuery->where('product_name', 'like', '%' . $this->search_product . '%')
        //                 ->orWhere('brand', 'like', '%' . $this->search_product . '%');
        //         })
        //             ->where(function ($userQuery) use ($userId) {
        //                 $userQuery->where('created_user_id', $userId);
        //             });
        //     })

        $crms = CrmHeader::where(function ($userQuery) use ($userId) {
            $userQuery->where('created_user_id', $userId);
        })
            ->when($this->search_contact, function ($contactQuery) {
                $contactQuery->where('contact', 'like', '%' . $this->search_contact . '%');
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
            ->when($this->search_product, function ($query) use ($userId) {
                $query->whereHas('crm_items.product', function ($productQuery) {
                    $productQuery->where('product_name', 'like', '%' . $this->search_product . '%')
                        ->orWhere('brand', 'like', '%' . $this->search_product . '%');
                })
                    ->where(function ($userQuery) use ($userId) {
                        $userQuery->where('created_user_id', $userId);
                    });
            })

            // eager load = fetch before use
            // control scope of model relations
            // ->with('crm_items:id,product_id')
            // ->with('customer')
            // ->with('crm_items.product:id,product_name,brand,supplier_rep,principal')
            // ->withCount('crm_items')
            ->get();

        // dd($crms);

        // $crmDetails = CrmDetail::with('product')
        //     ->get();

        // dd($crmDetails);

        // $crmDetails = CrmDetail::onlyTrashed()->get();

        // $this->crmHeaders = DB::table('customers')
        //     ->leftJoin('crm_headers', 'customers.id', 'customer_id')
        //     ->leftJoin('crm_details', 'crm_headers.id', 'crm_id')
        //     ->select(
        //         'crm_headers.created_at',
        //         'crm_headers.updated_at',
        //         'crm_headers.id',
        //         'crm_headers.customer_id',
        //         'customers.code',
        //         'customers.name_english',
        //         'customers.name_thai',
        //         'crm_headers.started_visit_date',
        //         'crm_headers.month_estimate_date',
        //         'crm_headers.contact',
        //         'crm_headers.created_at',
        //         'crm_headers.updated_at',
        //         DB::raw('COUNT(crm_details.id) as crm_details_count')
        //     )
        //     ->where('crm_headers.created_user_id', Auth::user()->id)
        //     ->groupBy(
        //         'crm_headers.created_at',
        //         'crm_headers.updated_at',
        //         'crm_headers.id',
        //         'crm_headers.customer_id',
        //         'customers.code',
        //         'customers.name_english',
        //         'customers.name_thai',
        //         'crm_headers.started_visit_date',
        //         'crm_headers.month_estimate_date',
        //         'crm_headers.contact',
        //         'crm_headers.created_at',
        //         'crm_headers.updated_at',
        //     )
        //     ->orderByDesc('crm_headers.id')
        //     ->get();

        // dd($this->crmHeaders);

        return view('livewire.crm.crm-lists', compact('crms'));
    }

    public function deleteCrm($id, $customer_name)
    {
        $this->dispatch("confirm", id: $id, name: $customer_name);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        // dd($id, $name);        

        CrmHeader::find($id)->delete();

        CrmDetail::where('crm_id', $id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted Successfully !!",
            text: "CRM ID : " . $id . " Customer: " . $name,
            // text: "Customer : " . $id . " - " . $name,
            icon: "success",
            timer: 3000,
            url: route('crm.list'),
        );

        // return $this->redirect(route('crm.list'), navigate: true);
    }
}
