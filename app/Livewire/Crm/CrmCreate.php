<?php

namespace App\Livewire\Crm;

// use App\Livewire\Forms\CRMCreateForm;
use App\Models\Application;
use App\Models\CrmDetail;
use App\Models\CrmHeader;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomerType;
use App\Models\Event;
use App\Models\PackingUnit;
use App\Models\Probability;
use App\Models\Product;
use App\Models\SalesStage;
use App\Models\SrvCustomer;
use App\Models\SrvProduct;
use App\Models\VolumeUnit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CrmCreate extends Component
{
    // public CRMCreateForm $crmCreateForm;
    // Variables for fetching values ​​from the database
    public $customerTypes, $customerGroups, $salesStages, $probabilities, $applications, $packingUnits, $volumeUnits;
    // Variables for form inputs
    public $customer_id, $customerCode, $customerNameEng, $customerNameThi, $parentCode, $parentName, $startVisit, $estimateDate, $customerType, $customerGroup, $contact, $purpose, $detail;
    public $event_id, $event_name; // Event variable
    public $application, $salesStage, $probability, $packingUnit, $volumnQty, $volumeUnit, $additional, $competitor, $opportunity;
    public $quantity, $unitPrice, $totalPrice;
    public $crmHeader_number, $crmHeader_id, $originalEstimateDate, $crmHeader_created_at, $crmHeader_updated_at;
    public $crmDetail_id, $crmDetail_created_at, $crmDetail_updated_at;
    public $productId, $productName, $productBrand, $supplierRep, $principal;
    public $inputs = [], $checkProduct = [];
    public $departmentId;

    public function mount($id = null)
    {
        $this->departmentId = auth()->user()->department_id;

        // Variable crmHeader_id ใช้สำหรับตอนลบ แล้วอ้างค่าตอนรีเฟรชเพจ
        $this->crmHeader_id = $id;

        if ($id) {

            $crmHeader = CrmHeader::where('id', $id)
                ->where('created_user_id', auth()->user()->id)
                ->first();

            try {
                $this->customer_id = $crmHeader->customer_id; // Add code 09/12/2025
                $this->crmHeader_number = $crmHeader->document_no;
                $this->customerCode = $crmHeader->customer->code;
                $this->customerNameEng = $crmHeader->customer->name_english;
                $this->customerNameThi = $crmHeader->customer->name_thai;
                $this->startVisit = $crmHeader->started_visit_date;
                $this->estimateDate = $crmHeader->estimate_date;
                $this->originalEstimateDate = $crmHeader->original_estimate_date;
                $this->customerType = $crmHeader->customer_type_id;
                $this->customerGroup = $crmHeader->customer_group_id;
                $this->event_id = $crmHeader->event_id;
                $this->event_name = $crmHeader->event->name;
                $this->contact = $crmHeader->contact;
                $this->purpose = $crmHeader->purpose;
                $this->detail = $crmHeader->detail;
                $this->opportunity = $crmHeader->opportunity;
                $this->crmHeader_created_at = $crmHeader->created_at;
                $this->crmHeader_updated_at = $crmHeader->updated_at;

                $crmDetails = CrmDetail::where('crm_id', $id)->get();

                foreach ($crmDetails as $value) {

                    $this->inputs[] = [
                        'crmDetail_id' => $value->id,
                        'productName' => $value->product->product_name,
                        'productBrand' => $value->product->brand,
                        'supplierRep' => $value->product->supplier_rep,
                        'principal' => $value->product->principal,
                        'updateVisit' => $value->updated_visit_date,
                        // 'updateVisit' => $value->updated_at->format('Y-m-d'),
                        'application' => $value->application_id,
                        'salesStage' => $value->sales_stage_id,
                        'probability' => $value->probability_id,
                        'quantity' => $value->quantity,
                        'unitPrice' => $value->unit_price,
                        'totalPrice' => $value->total_price,
                        // 'totalPrice' => number_format($value->total_price, 4),
                        'packingUnit' => $value->packing_unit_id,
                        'volumnQty' => $value->volumn_qty,
                        'volumeUnit' => $value->volume_unit_id,
                        'additional' => $value->additional,
                        'competitor' => $value->competitor,
                        // 'created_at' => $value->created_at,
                        // 'updated_at' => $value->updated_at,
                        'crmDetail_created_at' => $value->created_at,
                        'crmDetail_updated_at' => $value->updated_at,
                    ];

                    // นำค่าตัวแปร product_nam ใส่ไว้ที่ Array chekProduct เพื่อไม่ให้เพิ่มสินค้าตัวเดิมซ้ำ
                    array_push($this->checkProduct, $value->product->product_name);
                }
            } catch (\Throwable $th) {
                $this->dispatch(
                    "sweet.error",
                    position: "center",
                    title: "Cannot find CRM number !!",
                    // text: "Customer : " . $this->customerNameEng,
                    text: $th->getMessage(),
                    icon: "error",
                    // timer: 3000,
                    url: route('crm.list'),
                );
            }
        } else {

            $this->startVisit = now()->toDateString();
            $this->estimateDate = now()->toDateString();

            // $this->startVisit = Carbon::now()->toDateString();
            // $this->estimateDate = Carbon::now()->toDateString();

            $event = Event::where('id', 1)->first();

            // dd($event);

            if ($event) {
                $this->event_id = $event->id;
                $this->event_name = $event->name;
            }
        }

        $this->salesStages = SalesStage::all();
        $this->packingUnits = PackingUnit::all();

        /*
        =======================================================
        Created : Aek Noppadon
        Date    : 12/11/2025
        =======================================================
        Description :                    
        Show data by user & department 
        =======================================================
        */

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

        $this->applications = Application::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })
            ->orderBy('name')
            ->get();

        $this->probabilities = Probability::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })->get();

        $this->volumeUnits = VolumeUnit::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })->get();

        // ====================================================
    }

    public function save()
    {
        $this->validate(
            [
                'customerNameEng'           => 'required',
                'startVisit'                => 'required',
                'estimateDate'              => 'required',
                'customerType'              => 'required',
                'contact'                   => 'required',
                'purpose'                   => 'required',
                'inputs.*.productName'      => 'required',
                'inputs.*.productBrand'     => 'required',
                'inputs.*.updateVisit'      => 'required',
                'inputs.*.salesStage'       => 'required',
                'inputs.*.probability'      => 'required',
            ],
            [
                'customerNameEng' => 'Customer name Eng. field is required.',
                'startVisit'      => 'Start visit date field is required.',
                'estimateDate'    => 'Estimate date field is required.',
                'customerType'    => 'Customer type field is required.',
                'contact'         => 'Contact person field is required.',
                'purpose'         => 'Purpose field is required.',
                'inputs.*.productName.required'  => 'Product name field is required.',
                'inputs.*.productBrand.required' => 'Brand name field is required.',
                'inputs.*.updateVisit.required'  => 'Update visit date field is required.',
                'inputs.*.salesStage.required'   => 'Sales stage field is required.',
                'inputs.*.probability.required'  => 'Probability field is required.',
            ]
        );

        if (empty($this->inputs)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Please Add Product Item !!",
                text: "Customer : " . $this->customerNameEng,
                icon: "error",
                timer: 3000,
            );
            return;
        }

        try {
            DB::beginTransaction();

            $hasChanged = false;

            $dataHeaders = [
                'customer_id'            => $this->customer_id,
                'started_visit_date'     => $this->startVisit,
                'estimate_date'          => $this->estimateDate,
                'original_estimate_date' => $this->originalEstimateDate ?? $this->estimateDate,
                'customer_type_id'       => $this->customerType,
                'customer_group_id'      => empty($this->customerGroup) ? null : $this->customerGroup,
                'event_id'               => $this->event_id,
                'contact'                => trim($this->contact ?? ''),
                'purpose'                => trim($this->purpose ?? ''),
                'detail'                 => trim($this->detail ?? ''),
                'opportunity'            => trim($this->opportunity ?? ''),
                'created_user_id'        => auth()->id(),
                'updated_user_id'        => auth()->id(),
                'original_user_id'        => auth()->id(),
            ];

            // dd($dataHeaders);

            $crmHeader = CrmHeader::firstOrNew([
                'id' => $this->crmHeader_id
            ]);

            $crmHeader->fill($dataHeaders);

            if ($crmHeader->isDirty()) {
                $hasChanged = true;
                $crmHeader->save();
            }

            foreach ($this->inputs as $item) {

                $productId = Product::where('product_name', $item['productName'])->value('id');

                $item['quantity'] = !empty($item['quantity']) ? str_replace(',', '', $item['quantity']) : 0;
                $item['unitPrice'] = !empty($item['unitPrice']) ? str_replace(',', '', $item['unitPrice']) : 0;
                $item['totalPrice'] = !empty($item['totalPrice']) ? str_replace(',', '', $item['totalPrice']) : 0;

                $dataDetails = [
                    'crm_id'             => $crmHeader->id,
                    'product_id'         => $productId,
                    'updated_visit_date' => $item['updateVisit'],
                    'application_id'     => empty($item['application']) ? null : $item['application'],
                    'sales_stage_id'     => $item['salesStage'],
                    'probability_id'     => $item['probability'],
                    'quantity'           => $item['quantity'],
                    'unit_price'         => $item['unitPrice'],
                    'total_price'         => $item['totalPrice'],
                    'volumn_qty'         => $item['volumnQty'],
                    'volume_unit_id'     => $item['volumeUnit'],
                    'volume_unit_id'     => empty($item['volumeUnit']) ? null : $item['volumeUnit'],
                    'additional'         => trim($item['additional'] ?? ''),
                    'competitor'         => trim($item['competitor'] ?? ''),
                    'created_user_id'    => auth()->id(),
                    'updated_user_id'    => auth()->id(),
                ];

                // dd($dataDetails);

                $crmDetail = CrmDetail::firstOrNew([
                    'id'     => $item['crmDetail_id'] ?? null,
                    'crm_id' => $crmHeader->id,
                ]);

                $crmDetail->fill($dataDetails);

                if ($crmDetail->isDirty()) {
                    $hasChanged = true;

                    // $crmDetail->updated_visit_date = $crmDetail->exists ? now() : $item['updateVisit'];

                    $crmDetail->save();
                }
            }

            DB::commit();

            if ($hasChanged) {
                $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: "Saved Successfully !!",
                    text: "CRM : " . $this->customerNameEng,
                    icon: "success",
                    timer: 3000,
                    url: route('crm.update', $crmHeader->id),
                );
            }
        } catch (\Throwable $e) {
            DB::rollBack();

            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Cannot save CRM data !!",
                text: $e->getMessage(),
                icon: "error",
            );
        }
    }

    public function render()
    {
        return view('livewire.crm.crm-create');
    }

    #[On('select-event')]
    public function selectEvent($id)
    {
        $event = Event::findOrFail($id);

        $this->event_id = $event->id;
        $this->event_name = $event->name;

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 3000,
            title: "Add Event Successfully",
            message: $event->name,
        );
    }

    #[On('select-customer')]
    public function selectCustomer($id)
    {
        $customer = Customer::findOrFail($id);

        $customer_ax = SrvCustomer::where('CustomerCode', $customer->code)
            ->first();

        if ($customer_ax) {
            $customer->update([
                'name_english' => strtoupper($customer_ax->CustomerNameEng),
                'name_thai' => $customer_ax->CustomerNameThi,
                'parent_code' => $customer_ax->ParentCode,
                'parent_name' => strtoupper($customer_ax->ParentName),
                'updated_user_id' => auth()->user()->id,
            ]);
        }
        $this->customer_id = $customer->id; // Add code 09/12/2025
        $this->customerCode = $customer->code;
        $this->customerNameEng = $customer->name_english;
        $this->customerNameThi = $customer->name_thai;

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 3000,
            title: "Add Customer Successfully",
            message: (!empty($customer->name_english)) ? $customer->name_english : $customer->name_thai,
        );
    }

    #[On('select-product')]
    public function selectProduct($id)
    {
        $product = Product::findOrFail($id);

        // dd($product);

        // IF select source = Product AX
        if ($product->source == 0) {

            if (empty($product->code)) {

                // dd('Product Code Empty');

                $product_ax = SrvProduct::where('ProductName', $product->product_name)
                    ->where('ProductBrand', $product->brand)
                    ->where('SupplierRep', $product->supplier_rep)
                    ->where('Principal', $product->principal)
                    ->first();

                // dd($product_ax);

                if ($product_ax) {
                    // dd("Update product code empty");

                    $product->update([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'updated_user_id' => auth()->user()->id,
                    ]);
                }
            }

            if (!empty($product->code)) {

                // dd('Product Code Not Empty');

                $product_ax = SrvProduct::where('ProductCode', $product->code)
                    ->first();

                // dd($product_ax);

                if ($product_ax) {
                    // dd('Update');
                    $product->update([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'updated_user_id' => auth()->user()->id,
                    ]);
                }
            }
        }

        $this->productId = $product->id;
        $this->productName = $product->product_name;
        $this->productBrand = $product->brand;
        $this->supplierRep = $product->supplier_rep;
        $this->principal = $product->principal;

        if (!empty($this->checkProduct) && in_array($this->productName, $this->checkProduct)) {
            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "This item has already selected !!",
                text: "Product : " . $this->productName,
                icon: "error",
                timer: 3000,
            );

            return;
        }

        $this->inputs[] = [
            'crmDetail_id' => $this->crmDetail_id,
            'productId' => $this->productId,
            'productName' => $this->productName,
            'productBrand' => $this->productBrand,
            'supplierRep' => $this->supplierRep,
            'principal' => $this->principal,
            'updateVisit' => $this->startVisit,
            'application' => $this->application,
            'salesStage' => $this->salesStage,
            'probability' => $this->probability,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unitPrice,
            'totalPrice' => $this->totalPrice,
            'packingUnit' => $this->packingUnit,
            'volumnQty' => $this->volumnQty,
            'volumeUnit' => $this->volumeUnit,
            'additional' => $this->additional,
            'competitor' => $this->competitor,
        ];

        // นำค่าตัวแปร product_nam ใส่ไว้ที่ Array chekProduct เพื่อไม่ให้เพิ่มสินค้าตัวเดิมซ้ำ
        array_push($this->checkProduct, $this->productName);

        // $this->dispatch("toastr.info", message: $product->productName . " : Product Added Success");

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 3000,
            title: "Add Item Successfully",
            message: $this->productName,
        );
    }

    public function selectedCustomerType()
    {
        $this->customerTypes = CustomerType::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })
            ->orderBy('name')
            ->get();

        // $this->customerTypes = CustomerType::all();
    }

    public function selectedCustomerGroup()
    {
        $this->customerGroups = CustomerGroup::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })
            ->orderBy('name')
            ->get();

        // $this->customerGroups = CustomerGroup::all();
    }

    public function selectedSalesStage()
    {
        $this->salesStages = SalesStage::all();

        // $this->salesStages = SalesStage::orderBy('id')->get();
    }

    public function selectedProbability()
    {
        $this->probabilities = Probability::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })->get();

        // $this->probabilities  = Probability::all();
    }

    public function selectedPackingUnit()
    {
        $this->packingUnits = PackingUnit::all();
    }

    public function selectedVolumeUnit()
    {
        $this->volumeUnits = VolumeUnit::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })->get();
    }

    public function selectedApplication()
    {
        $this->applications = Application::whereHas('userCreated.department', function ($query) {
            $query->where('department_id', $this->departmentId);
        })->orderBy('name')->get();
    }

    public function sumRow($index)
    {
        // ($value['totalPrice'] != null) ? str_replace(',', '', $value['totalPrice']) : 0,

        $this->inputs[$index]['quantity'] = str_replace(',', '', $this->inputs[$index]['quantity']);
        $this->inputs[$index]['unitPrice'] = str_replace(',', '', $this->inputs[$index]['unitPrice']);

        if (($this->inputs[$index]['quantity'] != null) && ($this->inputs[$index]['unitPrice'] != null)) {
            $this->inputs[$index]['totalPrice'] = round($this->inputs[$index]['quantity'] * $this->inputs[$index]['unitPrice'], 2);
        } else {
            $this->inputs[$index]['totalPrice'] = null;
        }
    }

    public function removeItem($index, $name)
    {
        // dd($index, $name);

        unset($this->inputs[$index]);
        unset($this->checkProduct[$index]);

        // $this->dispatch("toastr.warning", message: $name . " Product Removed Success");

        $this->dispatch(
            "toastr.error",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 3000,
            title: "Remove Item Successfully !!",
            message: $name,
        );
    }

    public function deleteItem($id, $document_no, $product_name)
    {
        $this->dispatch("confirm", id: $id, document_no: $document_no, product_name: $product_name);
    }

    #[On('destroy')]
    public function destroy($id, $document_no, $product_name)
    {
        CrmDetail::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Item deleted successfully !!",
            text: $document_no . " : " . $product_name,
            icon: "success",
            timer: 3000,
            url: route('crm.update', $this->crmHeader_id),
        );

        // return $this->redirect('/crms/update/' . $this->crmNumber);
    }
}
