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
    public $product_id, $productName, $productBrand, $supplierRep, $principal;
    public $inputs = [], $checkProduct = [];
    public $source = '0';
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

            // dd($crmHeader);

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
                        'application' => $value->application_id,
                        'salesStage' => $value->sales_stage_id,
                        'probability' => $value->probability_id,
                        'quantity' => $value->quantity,
                        'unitPrice' => $value->unit_price,
                        'totalPrice' => number_format($value->total_price, 2),
                        'packingUnit' => $value->packing_unit_id,
                        'volumnQty' => $value->volumn_qty,
                        'volumeUnit' => $value->volume_unit_id,
                        'additional' => $value->additional,
                        'competitor' => $value->competitor,
                        'created_at' => $value->created_at,
                        'updated_at' => $value->updated_at,
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
            $this->startVisit = Carbon::now()->toDateString();
            $this->estimateDate = Carbon::now()->toDateString();

            $event = Event::where(function ($query) {
                $query->where('name', 'No Event')
                    ->whereHas('userCreated.department', function ($query) {
                        $query
                            ->where('id', $this->departmentId);
                    });
            })->first();

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

        if ($product->source == 0) {
            if (empty($product->code)) {

                // dd("No have product code");

                // $product_ax = DB::connection('sqlsrv2')
                //     ->table('SCC_CRM_PRODUCTS_NEW')
                //     ->where('ProductName', $product->product_name)
                //     ->first();

                $product_ax = SrvProduct::where('ProductName', $product->product_name)
                    ->first();

                // dd($product_ax);

                if ($product_ax) {
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
            } else {

                // dd("Have product code");

                // $product_ax = DB::connection('sqlsrv2')
                //     ->table('SCC_CRM_PRODUCTS_NEW')
                //     ->where('ProductCode', $product->code)
                //     ->first();

                $product_ax = SrvProduct::where('ProductCode', $product->code)
                    ->first();

                // dd($product_ax);

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
                // url: route('crm.list'),
            );

            return;
        }

        $this->inputs[] = [
            'crmDetail_id' => $this->crmDetail_id,
            'productName' => $this->productName,
            'productBrand' => $this->productBrand,
            'supplierRep' => $this->supplierRep,
            'principal' => $this->principal,
            'updateVisit' => $this->startVisit,
            // 'updateVisit' => Carbon::now()->toDateString(),
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
        if (($this->inputs[$index]['quantity'] != null) && ($this->inputs[$index]['unitPrice'] != null)) {
            $this->inputs[$index]['totalPrice'] = number_format((float)$this->inputs[$index]['quantity'] * (float)$this->inputs[$index]['unitPrice'], 2);
        } else {
            $this->inputs[$index]['totalPrice'] = null;
        }

        // if (($this->inputs[$index]['quantity'] != null) && ($this->inputs[$index]['unitPrice'] != null)) {
        //     $this->inputs[$index]['totalPrice'] = number_format((int)$this->inputs[$index]['quantity'] * (float)$this->inputs[$index]['unitPrice'], 2);
        // } else {
        //     $this->inputs[$index]['totalPrice'] = null;
        // }
    }

    public function save()
    {

        // $this->crmCreateForm->validate();

        // dd($this->inputs);

        // dd('Id : ' . $this->event_id . ", " . $this->event_name);

        $this->validate(
            [
                // Validate CRM Headers.                
                'customerNameEng' => 'required',
                'startVisit' => 'required',
                'estimateDate' => 'required',
                'customerType' => 'required',
                'contact' => 'required',
                'purpose' => 'required',

                // Validate CRM Details
                'inputs.*.productName' => 'required',
                'inputs.*.productBrand' => 'required',
                'inputs.*.updateVisit' => 'required',
                'inputs.*.salesStage' => 'required',
                'inputs.*.probability' => 'required',
            ],
            [
                // Validate message CRM Headers.               
                'customerNameEng' => 'Customer name Eng. field is required.',
                'startVisit' => 'Start visit date field is required.',
                'estimateDate' => 'Estimate date field is required.',
                'customerType' => 'Customer type field is required.',
                'contact' => 'Contact person field is required.',
                'purpose' => 'Purpose field is required.',

                // Validate CRM Details message.
                'inputs.*.productName.required' => 'Product name field is required.',
                'inputs.*.productBrand.required' => 'Brand name field is required.',
                'inputs.*.updateVisit.required' => 'Update visit date field is required.',
                'inputs.*.salesStage.required' => 'Sales stage field is required.',
                'inputs.*.probability.required' => 'Probability field is required.',
            ]
        );

        // crm_headers remove input space
        $this->contact = trim($this->contact);
        $this->purpose = trim($this->purpose);
        $this->detail = trim($this->detail);

        if ($this->inputs) {


            // dd($this->event_id . ' - ' . $this->event_name);

            try {
                DB::beginTransaction();

                $crm_header = CrmHeader::updateOrCreate(
                    [
                        'id' => $this->crmHeader_id
                    ],
                    [
                        'customer_id' => $this->customer_id,
                        'started_visit_date' => $this->startVisit,
                        'estimate_date' => $this->estimateDate,
                        'original_estimate_date' => (is_null($this->originalEstimateDate)) ? $this->estimateDate : $this->originalEstimateDate,
                        'customer_type_id' => $this->customerType,
                        'customer_group_id' => $this->customerGroup,
                        'event_id' => $this->event_id,
                        'contact' => $this->contact,
                        'purpose' => $this->purpose,
                        'detail' => $this->detail,
                        'created_user_id' => auth()->user()->id,
                        'updated_user_id' => auth()->user()->id,
                    ]
                );

                foreach ($this->inputs as $value) {

                    $product = Product::where('product_name', $value['productName'])->first();

                    $this->product_id = $product->id;

                    // crm_headers remove input space
                    $value['additional'] = trim($value['additional']);
                    $value['competitor'] = trim($value['competitor']);

                    $crm_detail = CrmDetail::where('crm_id', $this->crmHeader_id)
                        ->where('id', $value['crmDetail_id'])
                        ->first();

                    if (empty($crm_detail)) {
                        // CRM data insert to database
                        $crm_detail = CrmDetail::create([
                            'crm_id' => $crm_header->id,
                            'product_id' => $this->product_id,
                            'updated_visit_date' => $value['updateVisit'],
                            'application_id' => $value['application'],
                            'sales_stage_id' => $value['salesStage'],
                            'probability_id' => $value['probability'],
                            'quantity' => ($value['quantity'] != null) ? $value['quantity'] : 0,
                            'unit_price' => ($value['unitPrice'] != null) ? $value['unitPrice'] : 0,
                            'total_price' => ($value['totalPrice'] != null) ? str_replace(',', '', $value['totalPrice']) : 0,
                            'packing_unit_id' => $value['packingUnit'],
                            'volumn_qty' => $value['volumnQty'],
                            'volume_unit_id' => $value['volumeUnit'],
                            'additional' => $value['additional'],
                            'competitor' => $value['competitor'],
                            'created_user_id' => auth()->user()->id,
                            'updated_user_id' => auth()->user()->id,
                        ]);

                        $this->dispatch(
                            "sweet.success",
                            position: "center",
                            title: "Created Successfully !!",
                            text: (!empty($this->customerCode)) ? "CRM : " . $this->customerNameEng : "CRM " . $this->customerNameEng,
                            icon: "success",
                            timer: 3000,
                            url: route('crm.list'),
                        );
                    } else {
                        // CRM data update to database
                        dd(Carbon::now()->toDateString());

                        $crm_detail->update([
                            // 'crm_id' => $crm_header->id,
                            'product_id' => $this->product_id,
                            'updated_visit_date' => Carbon::now()->toDateString(),
                            // 'updated_visit_date' => $value['updateVisit'],
                            'application_id' => $value['application'],
                            'sales_stage_id' => $value['salesStage'],
                            'probability_id' => $value['probability'],
                            'quantity' => ($value['quantity'] != null) ? $value['quantity'] : 0,
                            'unit_price' => ($value['unitPrice'] != null) ? $value['unitPrice'] : 0,
                            'total_price' => ($value['totalPrice'] != null) ? str_replace(',', '', $value['totalPrice']) : 0,
                            'packing_unit_id' => $value['packingUnit'],
                            'volumn_qty' => $value['volumnQty'],
                            'volume_unit_id' => $value['volumeUnit'],
                            'additional' => $value['additional'],
                            'competitor' => $value['competitor'],
                            'updated_user_id' => auth()->user()->id,
                        ]);
                        $this->dispatch(
                            "sweet.success",
                            position: "center",
                            title: "Updated Successfully !!",
                            text: (!empty($this->customerCode)) ? $this->crmHeader_number . ", " . $this->customerNameEng : $this->crmHeader_number . ", Customer : " . $this->customerNameEng,
                            icon: "success",
                            timer: 3000,
                            url: route('crm.update', $this->crmHeader_id),
                        );
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                // return $e->getMessage();

                $this->dispatch(
                    "sweet.error",
                    position: "center",
                    title: "Cannot add CRM data !!",
                    text: $e->getMessage(),
                    icon: "error",
                    // timer: 3000,
                );
            }
        } else {
            // Error no add item
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Please Add Product Item !!",
                text: (!empty($this->customerCode)) ? "Customer : " . $this->customerCode . " - " . $this->customerNameEng : "Customer : " . $this->customerNameEng,
                icon: "error",
                timer: 3000,
            );
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
            text: $document_no . ", Product : " . $product_name,
            icon: "success",
            timer: 3000,
            url: route('crm.update', $this->crmHeader_id),
        );

        // return $this->redirect('/crms/update/' . $this->crmNumber);
    }
}
