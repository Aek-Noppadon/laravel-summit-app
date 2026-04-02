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
use Illuminate\Validation\Rule;
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
    public $application, $salesStage, $probability, $volumeUnit, $additional, $competitor, $opportunity;
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
                ->where('original_user_id', auth()->user()->id)
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
                        'application' => $value->application_id,
                        'salesStage' => $value->sales_stage_id,
                        'probability' => $value->probability_id,
                        'quantity' => $value->quantity,
                        'unitPrice' => $value->unit_price,
                        'totalPrice' => $value->total_price,
                        'volumeUnit' => $value->volume_unit_id,
                        'additional' => $value->additional,
                        'competitor' => $value->competitor,
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
                    text: $th->getMessage(),
                    icon: "error",
                    url: route('crm.list'),
                );
            }
        } else {

            $this->startVisit = now()->toDateString();
            $this->estimateDate = now()->toDateString();

            $event = Event::where('id', 1)->first();

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

    public function rules()
    {
        return [
            // ใช้ Rule class จะช่วยลดโอกาสพิมพ์ผิดและอ่านง่ายกว่า
            'customerNameEng'   => [
                'required'
            ],
            'startVisit'        => [
                'required'
            ],
            'estimateDate'      => [
                'required'
            ],
            'customerType'      => [
                'required'
            ],
            'contact'           => [
                'required',
                'max:255'
            ],
            'purpose'           => [
                'required'
            ],
            'inputs.*.productName'  => [
                'required'
            ],
            'inputs.*.productBrand' => [
                'required'
            ],
            'inputs.*.updateVisit'  => [
                'required'
            ],
            'inputs.*.salesStage'   => [
                'required'
            ],
            'inputs.*.probability'  => [
                'required'
            ],


        ];
    }

    protected function messages()
    {
        return [
            "required" => "The :attribute field is required.",
            "max"      => "The :attribute field must not be greater than :max characters.",
        ];
    }

    protected function validationAttributes()
    {
        return [
            'customerNameEng' => 'Customer Name',
            'startVisit' => 'Start Visit Date',
            'estimateDate' => 'Estimate Close Date',
            'customerType' => 'Customer Type',
            'contact' => 'Contact',
            'purpose' => 'Purpose',
            'inputs.*.productName' => 'Product Name',
            'inputs.*.productBrand' => 'Product Brand',
            'inputs.*.updateVisit' => 'Update Visit Date',
            'inputs.*.salesStage' => 'Sales Stage',
            'inputs.*.probability' => 'Probability',
        ];
    }

    public function save()
    {
        $this->validate();

        $start_visit = Carbon::parse($this->startVisit);
        $estimate_date = Carbon::parse($this->estimateDate);

        if ($estimate_date->lt($start_visit)) {
            $this->dispatchSweetError("Estimate Close Date " . $estimate_date->format('d/m/Y'), "Must not be less than Start visit " . $start_visit->format('d/m/Y'));
            return;
        }

        if (empty($this->inputs)) {
            $this->dispatchSweetError("Please Add Product Item !!", "Customer : " . $this->customerNameEng);
            return;
        }

        try {
            DB::beginTransaction();
            $hasChanged = false;

            // 1. เช็คก่อนว่านี่คือการ Create หรือ Update ตั้งแต่ต้น
            $isNewRecord = empty($this->crmHeader_id);

            $crmHeader = CrmHeader::firstOrNew(['id' => $this->crmHeader_id]);

            $dataHeaders = [
                'customer_id'            => $this->customer_id,
                'started_visit_date'     => $this->startVisit,
                'estimate_date'          => $this->estimateDate,
                'original_estimate_date' => $this->originalEstimateDate ?? $this->estimateDate,
                'customer_type_id'       => $this->customerType,
                'customer_group_id'      => $this->customerGroup ?: null,
                'event_id'               => $this->event_id,
                'contact'                => trim($this->contact ?? ''),
                'purpose'                => trim($this->purpose ?? ''),
                'detail'                 => trim($this->detail ?? ''),
                'opportunity'            => trim($this->opportunity ?? ''),
            ];

            $crmHeader->fill($dataHeaders);

            $dirtyHeader = $crmHeader->getDirty();

            unset($dirtyHeader['created_user_id'], $dirtyHeader['original_user_id']);

            if (count($dirtyHeader) > 0 || !$crmHeader->exists) {

                if (!$crmHeader->exists) {
                    $crmHeader->created_user_id = auth()->id();
                    $crmHeader->original_user_id = auth()->id();
                }

                $crmHeader->updated_user_id = auth()->id();

                $crmHeader->save();

                $hasChanged = true;
            }

            foreach ($this->inputs as $item) {
                $crmDetail = CrmDetail::firstOrNew([
                    'id'     => $item['crmDetail_id'] ?? null,
                    'crm_id' => $crmHeader->id,
                ]);

                // ดึงค่าวันที่จากหน้าจอมาเตรียมไว้
                $targetVisitDate = $item['updateVisit'];

                // --- Logic: ถ้า Stage เปลี่ยน ให้ใช้วันที่ปัจจุบันทันที ---
                if ($crmDetail->exists) {
                    $isSalesStageChanged = (int)$item['salesStage'] !== (int)$crmDetail->sales_stage_id;

                    if ($isSalesStageChanged) {
                        $targetVisitDate = Carbon::now()->format('Y-m-d');
                    }
                }

                // --- การเช็ควันที่ (Validation) ---
                $update_visit = Carbon::parse($targetVisitDate);

                if ($update_visit->lt($start_visit)) {
                    $this->dispatchSweetError("Update Visit Date " . $update_visit->format('d/m/Y'), "Must not be less than Start visit " . $start_visit->format('d/m/Y'));
                    return;
                }

                // เช็ค gt(now) เฉพาะกรณีที่ Stage ไม่เปลี่ยน (เพราะถ้าเปลี่ยนเราแก้เป็น now ให้แล้ว)
                if ($update_visit->isFuture()) {
                    $this->dispatchSweetError("Update Visit Date " . $update_visit->format('d/m/Y'), "Must not be later than today " . Carbon::now()->format('d/m/Y'));
                    return;
                }

                $productId = Product::where('product_name', $item['productName'])->value('id');

                $quantity  = !empty($item['quantity']) ? str_replace(',', '', $item['quantity']) : 0;
                $unitPrice = !empty($item['unitPrice']) ? str_replace(',', '', $item['unitPrice']) : 0;
                $totalPrice = !empty($item['totalPrice']) ? str_replace(',', '', $item['totalPrice']) : 0;

                $dataDetails = [
                    'crm_id'             => $crmHeader->id,
                    'product_id'         => $productId,
                    'updated_visit_date' => $targetVisitDate,
                    'application_id'     => $item['application'] ?: null,
                    'sales_stage_id'     => $item['salesStage'],
                    'probability_id'     => $item['probability'],
                    'quantity'           => $quantity,
                    'unit_price'         => $unitPrice,
                    'total_price'        => $totalPrice,
                    'volume_unit_id'     => $item['volumeUnit'] ?: null,
                    'additional'         => trim($item['additional'] ?? ''),
                    'competitor'         => trim($item['competitor'] ?? ''),
                ];

                $crmDetail->fill($dataDetails);

                $dirtyDetail = $crmDetail->getDirty();

                unset($dirtyDetail['created_user_id']);

                if (count($dirtyDetail) > 0 || !$crmDetail->exists) {
                    if (!$crmDetail->exists) {
                        $crmDetail->created_user_id = auth()->id();
                    }
                    $crmDetail->updated_user_id = auth()->id();
                    $crmDetail->save();
                    $hasChanged = true;
                }
            }

            DB::commit();

            if ($hasChanged) {
                // 2. เลือก Message ตามสถานะการเซฟ
                $title = $isNewRecord ? "Created Successfully" : "Updated Successfully";

                $this->dispatch(
                    "sweet.success",
                    position: "center",
                    title: $title,
                    text: "Number: " . $crmHeader->document_no . " Saved to Database.",
                    icon: "success",
                    timer: 3000,
                    url: route('crm.edit', $crmHeader->id),
                );
            } else {
                $this->dispatchSweetError("No Changes Detected !!", "Number: " . $crmHeader->document_no . " Cannot Updated.");
                return;
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->dispatch("sweet.error", title: "Error", text: $e->getMessage(), icon: "error");
        }
    }

    // Helper function เล็กๆ เพื่อลดความซ้ำซ้อน
    private function dispatchSweetError($title, $text)
    {
        $this->dispatch("sweet.error", position: "center", title: $title, text: $text, icon: "warning");
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
                icon: "warning",
                // timer: 3000,
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
            'volumeUnit' => $this->volumeUnit,
            'additional' => $this->additional,
            'competitor' => $this->competitor,
        ];

        // นำค่าตัวแปร product_nam ใส่ไว้ที่ Array chekProduct เพื่อไม่ให้เพิ่มสินค้าตัวเดิมซ้ำ
        array_push($this->checkProduct, $this->productName);

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
            url: route('crm.edit', $this->crmHeader_id),
        );
    }
}
