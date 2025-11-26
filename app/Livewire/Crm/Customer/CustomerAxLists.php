<?php

namespace App\Livewire\Crm\Customer;

use App\Models\Customer;
use App\Models\SrvCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerAxLists extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;
    public $source = '0';
    // public $customerCode, $CustomerNameEng;

    #[On('refresh-customer-ax')]
    public function render()
    {
        if (!$this->search) {
            $customers = SrvCustomer::select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
                ->orderBy('CustomerCode')
                ->paginate($this->pagination);

            // $customers = DB::connection('sqlsrv2')
            //     ->table('SCC_CRM_CUSTOMERS')
            //     ->select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
            //     ->orderBy('CustomerCode')
            //     ->paginate($this->pagination);

        } else {
            $customers = SrvCustomer::select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
                ->Where('CustomerCode', 'like', '%' . $this->search . '%')
                ->orWhere('CustomerNameEng', 'like', '%' . $this->search . '%')
                ->orWhere('CustomerNameThi', 'like', '%' . $this->search . '%')
                ->orWhere('ParentCode', 'like', '%' . $this->search . '%')
                ->orWhere('ParentName', 'like', '%' . $this->search . '%')
                ->orderBy('CustomerCode')
                ->paginate($this->pagination);

            // $customers = DB::connection('sqlsrv2')
            //     ->table('SCC_CRM_CUSTOMERS')
            //     ->select('CustomerCode', 'CustomerNameEng', 'CustomerNameThi', 'ParentCode', 'ParentName')
            //     ->Where('CustomerCode', 'like', '%' . $this->search . '%')
            //     ->orWhere('CustomerNameEng', 'like', '%' . $this->search . '%')
            //     ->orWhere('CustomerNameThi', 'like', '%' . $this->search . '%')
            //     ->orWhere('ParentCode', 'like', '%' . $this->search . '%')
            //     ->orWhere('ParentName', 'like', '%' . $this->search . '%')
            //     ->orderBy('CustomerCode')
            //     ->paginate($this->pagination);
        }

        return view('livewire.crm.customer.customer-ax-lists', compact('customers'));

        // return view('livewire.crm.customer.customer-ax-lists', [
        //     'customers' => $customers
        // ]);
    }

    #[On('save-customer-ax')]
    public function saveCustomerAx($id)
    {
        // $customer_ax = DB::connection('sqlsrv2')
        //     ->table('SCC_CRM_CUSTOMERS')
        //     ->Where('CustomerCode', $id)
        //     ->first();

        $customer_ax = SrvCustomer::where('CustomerCode', $id)
            ->first();

        // dd($customer_ax);

        // ตรวจสอบรหัสลูกค้าว่ามีใน Database ไหม
        $customer = Customer::where('code', $id)
            ->first();

        // dd($customer);

        // ถ้าไม่มีรหัสลูกค้าใน Database ให้เพิ่มข้อมูล
        if (is_null($customer)) {
            // dd("Insert");
            // Insert to database
            $customer = Customer::create([
                'code' => $customer_ax->CustomerCode,
                'name_english' => Str::upper($customer_ax->CustomerNameEng),
                'name_thai' => $customer_ax->CustomerNameThi,
                'parent_code' => $customer_ax->ParentCode,
                'parent_name' => Str::upper($customer_ax->ParentName),
                'source' => $this->source,
                'created_user_id' => Auth::user()->id,
                'updated_user_id' => Auth::user()->id,
            ]);

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Created Successfully !!",
                text: (!empty($customer->name_english)) ? "Customer : " . $customer->name_english : "Customer : " . $customer->name_thai,
                // text: (!empty($customer->name_english)) ? "Customer Id : " . $customer->code . ", Name : " . $customer->name_english : "Customer Id : " . $customer->code . ", Name : " . $customer->name_thai,
                icon: "success",
                timer: 3000,
            );
        } else {
            // dd("Update");
            // Update to database
            $customer->update([
                'code' => $customer_ax->CustomerCode,
                'name_english' => Str::upper($customer_ax->CustomerNameEng),
                'name_thai' => $customer_ax->CustomerNameThi,
                'parent_code' => $customer_ax->ParentCode,
                'parent_name' => Str::upper($customer_ax->ParentName),
                'source' => $this->source,
                'updated_user_id' => Auth::user()->id,
            ]);
            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Updated Successfully !!",
                text: (!empty($customer->name_english)) ? "Customer : " . $customer->name_english : "Customer : " . $customer->name_thai,
                // text: (!empty($customer->name_english)) ? "Customer Id : " . $customer->code . ", Name : " . $customer->name_english : "Customer Id : " . $customer->code . ", Name : " . $customer->name_thai,
                icon: "success",
                timer: 3000,
            );
        }

        $this->dispatch('close-modal-customer');
    }
}
