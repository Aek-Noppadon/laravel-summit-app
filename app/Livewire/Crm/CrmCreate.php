<?php

namespace App\Livewire\Crm;

// use App\Livewire\Forms\CRMCreateForm;
use App\Models\Application;
use App\Models\CrmDetail;
use App\Models\CrmHeader;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomerType;
use App\Models\PackingUnit;
use App\Models\Probability;
use App\Models\Product;
use App\Models\SalesStage;
use App\Models\SrvCustomer;
use App\Models\SrvProduct;
use App\Models\VolumeUnit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CrmCreate extends Component
{
    // public CRMCreateForm $crmCreateForm;
    // Variables for fetching values ​​from the database
    public $customerTypes, $customerGroups, $salesStages, $probabilities, $applications, $packingUnits, $volumeUnits;
    // Variables for form inputs
    public $customer_id, $customerCode, $customerNameEng, $customerNameThi, $parentCode, $parentName, $startVisit, $monthEstimate,  $customerType, $customerGroup, $contact, $purpose, $detail;
    public $application, $salesStage, $probability, $packingUnit, $volumnQty, $volumeUnit, $additional, $competitor;
    public $quantity, $unitPrice, $totalPrice;
    public $crmHeader_id, $originalMonthEstimate, $crmHeader_created_at, $crmHeader_updated_at;
    public $crmDetail_id, $crmDetail_created_at, $crmDetail_updated_at;
    public $product_id, $productName, $productBrand, $supplierRep, $principal;
    public $inputs = [], $checkProduct = [];
    // public $source = '0';
    public $departmentId;

    public function mount($id = null)
    {
        // dd(Auth::user()->id);

        // Variable crmHeader_id ใช้สำหรับตอนลบ แล้วอ้างค่าตอนรีเฟรชเพจ
        $this->crmHeader_id = $id;

        // dd($this->crmHeader_id);

        if ($id) {
            // $crmHeader = CrmHeader::findOrFail($id);
            $crmHeader = CrmHeader::join('customers', 'crm_headers.customer_id', '=', 'customers.id')
                ->select('crm_headers.*', 'customers.code', 'customers.name_english', 'customers.name_thai')
                ->where('crm_headers.id', $id)
                ->first();

            // dd($crmHeader);

            $this->crmHeader_id = $crmHeader->id;
            $this->customerCode = $crmHeader->code;
            $this->customerNameEng = $crmHeader->name_english;
            $this->customerNameThi = $crmHeader->name_thai;
            $this->startVisit = $crmHeader->started_visit_date;
            $this->monthEstimate = $crmHeader->month_estimate_date;
            $this->originalMonthEstimate = $crmHeader->original_month_estimate_date;
            $this->customerType = $crmHeader->customer_type_id;
            $this->customerGroup = $crmHeader->customer_group_id;
            $this->contact = $crmHeader->contact;
            $this->purpose = $crmHeader->purpose;
            $this->detail = $crmHeader->detail;
            $this->crmHeader_created_at = $crmHeader->created_at;
            $this->crmHeader_updated_at = $crmHeader->updated_at;

            // $crmDetails = CrmHeader::findOrFail($id);

            $crmDetails = CrmDetail::join('products', 'crm_details.product_id', '=', 'products.id')
                ->join('crm_headers', 'crm_details.crm_id', '=', 'crm_headers.id')
                ->select('crm_headers.*', 'crm_details.*', 'products.product_name', 'products.brand', 'products.supplier_rep', 'products.principal')
                ->where('crm_headers.id', $id)
                ->get();

            // dd($crmDetails);

            // foreach ($crmDetails->items as $value) {
            foreach ($crmDetails as $value) {
                $this->inputs[] = [
                    'crmDetail_id' => $value->id,
                    'productName' => $value->product_name,
                    'productBrand' => $value->brand,
                    'supplierRep' => $value->supplier_rep,
                    'principal' => $value->principal,
                    'updateVisit' => $value->update_visit,
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
                    // 'created_at' => (is_null($value->created_at)) ? $this->crmDetail_created_at : $value->created_at,
                    // 'updated_at' => (is_null($value->updated_at)) ? $this->crmDetail_updated_at : $value->updated_at,
                ];

                // นำค่าตัวแปร product_nam ใส่ไว้ที่ Array chekProduct เพื่อไม่ให้เพิ่มสินค้าตัวเดิมซ้ำ
                array_push($this->checkProduct, $value->product_name);
                // array_push($this->checkProduct, $value->product_name);
            }

            // dd($this->inputs);
        } else {
            $this->startVisit = Carbon::now()->toDateString();
            $this->monthEstimate = Carbon::now()->toDateString();
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
        // dd(Auth::user()->id);

        return view('livewire.crm.crm-create');
    }

    #[On('select-customer')]
    public function selectCustomer($id)
    {
        $customer = Customer::findOrFail($id);

        // $customer_ax = DB::connection('sqlsrv2')
        //     ->table('SCC_CRM_CUSTOMERS')
        //     ->Where('CustomerCode', $customer->code)
        //     ->first();

        $customer_ax = SrvCustomer::where('CustomerCode', $customer->code)
            ->first();

        if ($customer_ax) {
            $customer->update([
                'name_english' => strtoupper($customer_ax->CustomerNameEng),
                'name_thai' => $customer_ax->CustomerNameThi,
                'parent_code' => $customer_ax->ParentCode,
                'parent_name' => strtoupper($customer_ax->ParentName),
                'updated_user_id' => Auth::user()->id,
            ]);
        }

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

    // ย้ายโค้ดไปที่ Component crm.customer.CustomerAxLists
    // #[On('save-customer-ax')]
    // public function saveCustomerAx($id)
    // {
    //     // $customer_ax = DB::connection('sqlsrv2')
    //     //     ->table('SCC_CRM_CUSTOMERS')
    //     //     ->Where('CustomerCode', $id)
    //     //     ->first();

    //     $customer_ax = SrvCustomer::where('CustomerCode', $id)
    //         ->first();

    //     // ตรวจสอบรหัสลูกค้าว่ามีใน Database ไหม
    //     $customer = Customer::where('code', $id)
    //         ->first();

    //     // ถ้าไม่มีรหัสลูกค้าใน Database ให้เพิ่มข้อมูล
    //     if (is_null($customer)) {
    //         // Insert to database
    //         $customer = Customer::create([
    //             'code' => $customer_ax->CustomerCode,
    //             'name_english' => Str::upper($customer_ax->CustomerNameEng),
    //             'name_thai' => $customer_ax->CustomerNameThi,
    //             'parent_code' => $customer_ax->ParentCode,
    //             'parent_name' => Str::upper($customer_ax->ParentName),
    //             'source' => $this->source,
    //             'created_user_id' => Auth::user()->id,
    //             'updated_user_id' => Auth::user()->id,
    //         ]);

    //         $this->dispatch(
    //             "sweet.success",
    //             position: "center",
    //             title: "Created Successfully !!",
    //             text: (!empty($customer->name_english)) ? "Customer : " . $customer->name_english : "Customer : " . $customer->name_thai,
    //             // text: (!empty($customer->name_english)) ? "Customer Id : " . $customer->code . ", Name : " . $customer->name_english : "Customer Id : " . $customer->code . ", Name : " . $customer->name_thai,
    //             icon: "success",
    //             timer: 3000,
    //         );
    //     } else {
    //         // Update to database
    //         $customer->update([
    //             'code' => $customer_ax->CustomerCode,
    //             'name_english' => Str::upper($customer_ax->CustomerNameEng),
    //             'name_thai' => $customer_ax->CustomerNameThi,
    //             'parent_code' => $customer_ax->ParentCode,
    //             'parent_name' => Str::upper($customer_ax->ParentName),
    //             'source' => $this->source,
    //             'updated_user_id' => Auth::user()->id,
    //         ]);
    //         $this->dispatch(
    //             "sweet.success",
    //             position: "center",
    //             title: "Updated Successfully !!",
    //             text: (!empty($customer->name_english)) ? "Customer : " . $customer->name_english : "Customer : " . $customer->name_thai,
    //             // text: (!empty($customer->name_english)) ? "Customer Id : " . $customer->code . ", Name : " . $customer->name_english : "Customer Id : " . $customer->code . ", Name : " . $customer->name_thai,
    //             icon: "success",
    //             timer: 3000,
    //         );
    //     }

    //     $this->dispatch('close-modal-customer-ax');
    // }

    #[On('select-product')]
    public function selectProduct($id)
    {
        $product = Product::findOrFail($id);

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
                    'updated_user_id' => Auth::user()->id,
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
                'updated_user_id' => Auth::user()->id,
            ]);
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

    #[On('save-product-ax')]
    public function saveProductAx($name)
    {
        // ทำมั้ยไม่ใช่ Proudct Code ?

        // $product_ax = DB::connection('sqlsrv2')
        //     ->table('SCC_CRM_PRODUCTS_NEW')
        //     ->where('ProductName', $name)
        //     ->first();

        $product_ax = SrvProduct::where('ProductName', $name)
            ->first();

        if (empty($product_ax->ProductName)) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "No have product list",
                text: "Please refresh product",
                // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                icon: "error",
                timer: 3000,
            );
        } else {
            if (empty($product_ax->ProductCode)) {

                // ตรวจสอบสินค้าว่ามีอยู่ใน Database ไหม, ถ้าไม่มีให้ Insert, ถ้ามีให้ Update
                $product = Product::where('product_name', $product_ax->ProductName)
                    ->first();

                if (empty($product)) {
                    Product::create([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'created_user_id' => Auth::user()->id,
                        'updated_user_id' => Auth::user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Created Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                        // url: route('crm.create'),
                    );
                } else {
                    $product->update([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'updated_user_id' => Auth::user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Updated Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                    );
                }
            } else {
                // ตรวจสอบสินค้าว่ามีอยู่ใน Database ไหม, ถ้าไม่มีให้ Insert, ถ้ามีให้ Update
                $product = Product::where('code', $product_ax->ProductCode)
                    ->first();

                if (empty($product)) {
                    Product::create([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'created_user_id' => Auth::user()->id,
                        'updated_user_id' => Auth::user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Created Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        // text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductCode . " - " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                        // url: route('crm.create'),
                    );
                } else {
                    $product->update([
                        'code' => $product_ax->ProductCode,
                        'product_name' => $product_ax->ProductName,
                        'brand' => $product_ax->ProductBrand,
                        'supplier_rep' => $product_ax->SupplierRep,
                        'principal' => $product_ax->Principal,
                        'status' => $product_ax->Status,
                        'source' => $this->source,
                        'updated_user_id' => Auth::user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Updated Successfully !!",
                        text: (!empty($product_ax->ProductCode)) ? "Product : " . $product_ax->ProductName : "Product : " . $product_ax->ProductName,
                        icon: "success",
                        timer: 3000,
                    );
                }
            }
        }
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
            $this->inputs[$index]['totalPrice'] = number_format((int)$this->inputs[$index]['quantity'] * (float)$this->inputs[$index]['unitPrice'], 2);
        } else {
            $this->inputs[$index]['totalPrice'] = null;
        }
    }

    public function save()
    {

        // $this->crmCreateForm->validate();

        $this->validate(
            [
                // Validate CRM Headers.                
                'customerNameEng' => 'required',
                'startVisit' => 'required',
                'monthEstimate' => 'required',
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
                'monthEstimate' => 'Month estimate field is required.',
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

        // dd($this->startVisit . " " . date('H:i:s'));

        // dd($this->inputs);

        // dd($this->monthEstimate, $this->originalMonthEstimate);

        // ตรวจสอบรหัสลูกค้าที่เลือกว่ามีข้อมูลใน Database ไหม ถ้ามีให้เก็บค่ารหัสลูกค้า เข้าตัวแปรเพื่อบันทึกข้อมูล
        $customer = Customer::where('code', $this->customerCode)->first();

        $this->customer_id = $customer->id;

        // dd($this->customer_id);

        if ($this->inputs) {

            // try {
            //     DB::beginTransaction();

            // info($this->customerCode);
            // info($this->customerNameEng);
            // info($this->customerNameThi);
            // info($this->startVisit);
            // info($this->monthEstimate);
            // info($this->originalMonthEstimate);
            // info($this->customerType);
            // info($this->customerGroup);
            // info($this->contact);
            // info($this->purpose);
            // info($this->detail);

            // info($this->inputs);

            // foreach ($this->inputs as $value) {
            //     info(($value['quantity'] != null) ? $value['quantity'] : 0);
            //     info(($value['unitPrice'] != null) ? $value['unitPrice'] : 0);
            //     info(($value['totalPrice'] != null) ? str_replace(',', '', $value['totalPrice']) : 0);
            // }


            $crm_header = CrmHeader::updateOrCreate(
                [
                    'id' => $this->crmHeader_id
                ],
                [
                    'customer_id' => $this->customer_id,
                    'started_visit_date' => $this->startVisit,
                    'month_estimate_date' => $this->monthEstimate,
                    'original_month_estimate_date' => (is_null($this->originalMonthEstimate)) ? $this->monthEstimate : $this->originalMonthEstimate,
                    'customer_type_id' => $this->customerType,
                    'customer_group_id' => $this->customerGroup,
                    'contact' => $this->contact,
                    'purpose' => $this->purpose,
                    'detail' => $this->detail,
                    'created_user_id' => Auth::user()->id,
                    'updated_user_id' => Auth::user()->id,
                ]
            );

            foreach ($this->inputs as $value) {

                $product = Product::where('product_name', $value['productName'])->first();

                $this->product_id = $product->id;

                // dd($this->product_id);

                $crm_detail = CrmDetail::where('crm_id', $this->crmHeader_id)
                    ->where('id', $value['crmDetail_id'])
                    ->first();

                if (is_null($crm_detail)) {

                    // Insert to database
                    $crm_detail = CrmDetail::create([
                        'crm_id' => $crm_header->id,
                        'product_id' => $this->product_id,
                        'update_visit' => $value['updateVisit'],
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
                        'created_user_id' => Auth::user()->id,
                        'updated_user_id' => Auth::user()->id,
                    ]);

                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Created Successfully !!",
                        text: (!empty($this->customerCode)) ? "CRM Customer : " . $this->customerCode . " - " . $this->customerNameEng : "CRM Customer : " . $this->customerNameEng,
                        icon: "success",
                        timer: 3000,
                        url: route('crm.list'),
                    );

                    // return $this->redirect(route('crm.list'));
                } else {
                    // Update to database
                    $crm_detail->update([
                        // 'crm_id' => $crm_header->id,
                        'product_id' => $this->product_id,
                        'update_visit' => $value['updateVisit'],
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
                        'updated_user_id' => Auth::user()->id,
                    ]);
                    $this->dispatch(
                        "sweet.success",
                        position: "center",
                        title: "Updated Successfully !!",
                        // text: "CRM Id : " . $this->crmHeader_id . ", Name : " . (!empty($this->customerCode)) ? "Customer : " . $this->customerCode . " - " . $this->customerNameEng : "Customer : " . $this->customerNameEng,
                        text: (!empty($this->customerCode)) ? "CRM Id : " . $this->crmHeader_id . ", Customer : " . $this->customerCode . " - " . $this->customerNameEng : "CRM Id : " . $this->crmHeader_id . ", Customer : " . $this->customerNameEng,
                        icon: "success",
                        timer: 3000,
                        url: route('crm.update', $this->crmHeader_id),
                    );
                }
            }



            //     DB::commit();
            // } catch (\Exception $e) {
            //     DB::rollBack();
            //     // dd($e);
            //     return $e->getMessage();
            // }
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

    public function deleteItem($id, $product_name)
    {
        $this->dispatch("confirm", id: $id, name: $product_name);

        // dd($id, $product_name);

        // CrmDetail::find($id)->delete();

        // $this->dispatch(
        //     "sweet.success",
        //     position: "center",
        //     title: "Delete Item successfully",
        //     text: $product_name,
        //     icon: "success",
        //     timer: 3000,
        // );

        // dd($crm_detail);
    }

    #[On('destroy')]
    public function destroy($id, $name)
    {
        // dd($id, $name);

        CrmDetail::find($id)->delete();

        $this->dispatch(
            "sweet.success",
            position: "center",
            title: "Item deleted successfully !!",
            text: "Product : " . $id . " - " . $name,
            icon: "success",
            timer: 3000,
            url: route('crm.update', $this->crmHeader_id),
        );

        // return $this->redirect('/crms/update/' . $this->crmNumber);
    }
}
