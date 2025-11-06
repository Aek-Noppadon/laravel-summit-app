<?php

namespace App\Livewire\Crm;

use App\Models\CrmHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CrmLists extends Component
{
    public $crmHeaders;

    public function render()
    {
        // dd(Auth::user()->id);

        $this->crmHeaders = DB::table('customers')
            ->leftJoin('crm_headers', 'customers.id', 'customer_id')
            ->leftJoin('crm_details', 'crm_headers.id', 'crm_id')
            ->select(
                'crm_headers.created_at',
                'crm_headers.updated_at',
                'crm_headers.id',
                'crm_headers.customer_id',
                'customers.code',
                'customers.name_english',
                'customers.name_thai',
                'crm_headers.started_visit_date',
                'crm_headers.month_estimate_date',
                'crm_headers.contact',
                'crm_headers.created_at',
                'crm_headers.updated_at',
                DB::raw('COUNT(crm_details.id) as crm_details_count')
            )
            ->where('crm_headers.created_user_id', Auth::user()->id)
            ->groupBy(
                'crm_headers.created_at',
                'crm_headers.updated_at',
                'crm_headers.id',
                'crm_headers.customer_id',
                'customers.code',
                'customers.name_english',
                'customers.name_thai',
                'crm_headers.started_visit_date',
                'crm_headers.month_estimate_date',
                'crm_headers.contact',
                'crm_headers.created_at',
                'crm_headers.updated_at',
            )
            ->orderByDesc('crm_headers.id')
            ->get();

        // dd($this->crmHeaders);

        return view('livewire.crm.crm-lists');
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

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Deleted successfully !!",
            text: "CRM Id : " . $id . " Customer: " . $name,
            // text: "Customer : " . $id . " - " . $name,
            icon: "success",
            timer: 3000,
            url: route('crm.list'),
        );

        // return $this->redirect(route('crm.list'), navigate: true);
    }
}
