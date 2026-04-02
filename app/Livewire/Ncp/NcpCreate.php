<?php

namespace App\Livewire\Ncp;

use App\Models\Customer;
use App\Models\FoundActivity;
use App\Models\PreventiveAction;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use function Laravel\Prompts\info;

class NcpCreate extends Component
{
    use WithFileUploads;

    public $customerId, $customerCode, $customerNameEng, $customerNameThi;
    public $foundActivityId, $foundActivityName, $problemDescription;
    public $preventiveActionId, $preventiveActionName, $correctiveActionName, $result;
    public $productId, $productCode, $productName, $productBrand, $batchNo, $quantity, $refDocumentNo, $refInvoiceNo, $remark;
    public $inputs = [];
    public $allDetails = [];
    public $imagePreviews = [];
    public $sourceType = 'customer';
    public $toWhNo = 13;

    public function updatedSourceType()
    {
        $this->customerCode = '';
        $this->customerNameEng = '';
        $this->customerNameThi = '';
    }

    #[On('select-customer')]
    public function selectCustomer($id)
    {
        $customer = Customer::findOrFail($id);

        $this->customerId = $customer->id;
        $this->customerCode = $customer->code;
        $this->customerNameEng = $customer->name_english;
        $this->customerNameThi = $customer->name_thai;

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 2000,
            title: "Add Customer Successfully",
            message: (!empty($customer->name_english)) ? $customer->name_english : $customer->name_thai,
        );

        $this->dispatch('close-modal-customer-list');
    }

    #[On('select-vendor')]
    public function selectVendor($id)
    {

        $vendor = Vendor::findOrFail($id);

        $this->customerId = $vendor->id;
        $this->customerCode = $vendor->code;
        $this->customerNameEng = $vendor->name_english;

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left",
            progress: true,
            timeout: 2000,
            title: "Add Vendor Successfully",
            message: $vendor->name_english,
        );

        $this->dispatch('close-modal-vendor-list');
    }

    #[On('select-found-activity')]
    public function selectFoundActivity($id)
    {
        $foundActivity = FoundActivity::findOrFail($id);

        $this->foundActivityId = $foundActivity->id;
        $this->foundActivityName = $foundActivity->name;

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left",
            progress: true,
            timeout: 2000,
            title: "Add Found Activity Successfully",
            message: $foundActivity->name,
        );

        $this->dispatch('close-found-activity-modal');
    }

    #[On('select-preventive-action')]
    public function selectPreventiveAction($id)
    {
        $preventiveAction = PreventiveAction::findOrFail($id);

        $this->preventiveActionId = $preventiveAction->id;
        $this->preventiveActionName = $preventiveAction->name;

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left",
            progress: true,
            timeout: 2000,
            title: "Add Found Activity Successfully",
            message: $preventiveAction->name,
        );

        $this->dispatch('close-preventive-action-modal');
    }

    #[On('select-product')]
    public function selectProduct($id)
    {
        $productItem = ProductItem::findOrFail($id);

        $this->inputs[] = [
            'productId'    => $productItem->id, // ดึงจาก Model โดยตรง
            'productCode'  => $productItem->code,
            'productName'  => $productItem->name,
            'productBrand' => $productItem->brand_name,
            'toWhNo'         => $this->toWhNo, // ใช้ค่า Default 13
        ];

        $this->dispatch(
            "toastr.success",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 2000,
            title: "Add Item Successfully",
            message: $this->productName,
        );
    }

    public function removeItem($key, $productName)
    {
        unset($this->inputs[$key]);

        $this->inputs = array_values($this->inputs); // รีเซ็ต Index ให้กลับมาเป็น 0, 1, 2 ใหม่

        // เคลียร์ Error Message ของทั้ง Form เพื่อป้องกัน Error ค้างข้ามแถว
        $this->resetErrorBag();

        $this->dispatch(
            "toastr.info",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 3000,
            title: "Remove Item Successfully !!",
            message: $productName,
        );
    }

    // Method สำหรับรับข้อมูล Base64 จาก JavaScript
    public function addPreview($base64Image)
    {
        $max = count($this->imagePreviews);

        if ($max < 6) {
            $this->imagePreviews[] = $base64Image;
        } else {
            $this->dispatch(
                "toastr.error",
                position: "toast-top-left", //toast-botton-left
                progressbar: true,
                timeout: 3000,
                title: "ไม่สามารถอัปโหลดรูปได้ !!!",
                message: 'อัปโหลดได้สูงสุด ' . $max . ' รูป',
            );
        }
    }

    // Method สำหรับแสดง Error อัปโหลดรูปเกินจำนวนที่ตั้งไว้สูงสุด 6 รูป
    public function showMaxFileError($max)
    {
        // ส่ง Dispatch ไปหา Listener "toastr.error" ที่อยู่ใน app.blade.php
        $this->dispatch(
            "toastr.error",
            position: "toast-top-left", //toast-botton-left
            progressbar: true,
            timeout: 3000,
            title: "ไม่สามารถอัปโหลดรูปได้ !!!",
            message: 'อัปโหลดได้สูงสุด ' . $max . ' รูป',
        );

        // แถม: สั่งให้แสดง Error ตัวอักษรแดงใต้ช่อง Input ด้วย (ถ้าต้องการ)
        $this->addError('images', 'จำกัดจำนวนอัปโหลดสูงสุดที่ ' . $max . ' รูป');
    }

    // Method สำหรับลบรูป Preview
    public function removePreview($index)
    {
        if (isset($this->imagePreviews[$index])) {
            unset($this->imagePreviews[$index]);
            $this->imagePreviews = array_values($this->imagePreviews); // จัดเรียง index ใหม่
        }
    }

    // Method อัปโหลดรูปภาพไปไว้ที่ Storage path
    private function uploadImages()
    {
        if (empty($this->imagePreviews)) {
            return;
        }

        $folderPath = storage_path('app/public/products');

        // เช็คและสร้าง Folder
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        // 1. สร้าง Array เปล่าไว้เก็บชื่อไฟล์ข้างนอก Loop
        $allImages = [];

        foreach ($this->imagePreviews as $base64) {
            // จัดการข้อมูล Base64
            @list($type, $imageData) = explode(';', $base64);
            @list(, $imageData) = explode(',', $imageData);

            $extension = explode('/', $type)[1];
            if ($extension == 'jpeg') $extension = 'jpg';

            // --- ส่วนที่แก้ไข: ตั้งชื่อไฟล์ตามวันเวลา ---
            // Y = ปี (2024), m = เดือน (05), d = วัน (20)
            // H = ชม. (24 ชม.), i = นาที, s = วินาที
            // เพิ่ม rand() เล็กน้อยกันกรณีที่มีการอัปโหลดหลายรูปในวินาทีเดียวกัน
            $fileName = date('Ymd_His') . '_' . rand(100, 999) . '.' . $extension;

            $decodedImage = base64_decode($imageData);

            // บันทึกไฟล์
            $fullPath = $folderPath . DIRECTORY_SEPARATOR . $fileName;
            file_put_contents($fullPath, $decodedImage);

            // 2. เก็บชื่อไฟล์ลง Array (แก้ไข Syntax ให้ถูกต้อง)
            $allImages[] = [
                'imageName' => $fileName,
            ];

            // --- เพิ่มโค้ดบันทึกลง Database ตรงนี้ ---
            // ตัวอย่าง:
            // NcpImage::create([
            //     'ncp_id' => $ncpId, 
            //     'file_name' => $fileName
            // ]);
        }

        // 3. ย้าย dd มาไว้ตรงนี้ เพื่อดูชื่อรูปทั้งหมดที่ถูกจัดการเสร็จแล้ว
        dd($allImages);
    }

    public function rules()
    {
        return [
            // ใช้ Rule class จะช่วยลดโอกาสพิมพ์ผิดและอ่านง่ายกว่า
            'customerCode'          => ['required'],
            'customerNameEng'       => ['required'],
            'foundActivityName'     => ['required'],
            'problemDescription'    => ['required'],
            'preventiveActionName'  => ['required'],
            'correctiveActionName'  => ['required'],
            'result'                => ['required'],
            'inputs.*.productCode'      => ['required'],
            'inputs.*.productName'      => ['required'],
            'inputs.*.batchNo'          => ['required', 'max:20'],
            'inputs.*.quantity'         => ['required'],
            'inputs.*.refInvoiceNo'     => ['required', 'max:20'],
            'inputs.*.remark'    => ['required'],
        ];
    }

    protected function messages()
    {
        return [
            "required" => ":attribute field is required.",
            "max"      => ":attribute field must not be greater than :max characters.",
        ];
    }

    protected function validationAttributes()
    {
        return [
            'customerCode'              => 'Customer Code',
            'customerNameEng'           => 'Customer Name',
            'foundActivityName'         => 'Found During Activity',
            'problemDescription'        => 'Problem Description',
            'preventiveActionName'      => 'Preventive Action',
            'correctiveActionName'      => 'Corrective Action',
            'result'                    => 'Result',
            'inputs.*.productCode'      => 'Product Code',
            'inputs.*.productName'      => 'Product Name',
            'inputs.*.batchNo'          => 'Batch No',
            'inputs.*.quantity'         => 'Quantity',
            'inputs.*.refInvoiceNo'     => 'Ref.Invoice No.',
            'inputs.*.remark'           => 'Remark',
            // 'inputs.*.salesStage' => 'Sales Stage',
            // 'inputs.*.probability' => 'Probability',
        ];
    }

    // Helper function เล็กๆ เพื่อลดความซ้ำซ้อน
    private function dispatchSweetError($title, $text)
    {
        $this->dispatch("sweet.error", position: "center", title: $title, text: $text, icon: "warning");
    }

    public function save()
    {
        // $this->validate();

        // if (empty($this->inputs)) {
        //     $this->dispatchSweetError(
        //         "Please Add Product Item !!",
        //         ($this->sourceType == 'customer' ? "Customer: " : "Vendor: ") . $this->customerNameEng
        //     );
        //     return;
        // }

        try {
            DB::transaction(function () {

                // Data Headers
                $dataHeaders = [
                    'customerId'            => $this->customerId,    // Function select-customer,select-vendor เก็บค่า CusotmerId เข้าตัวแปรแล้ว
                    'foundActivityId'       => $this->foundActivityId,
                    'problemDescription'    => trim($this->problemDescription),
                    'preventiveActionId'    => $this->preventiveActionId,
                    'correctiveActionName'  => trim($this->correctiveActionName),
                    'result'                => trim($this->result),

                ];

                // dd($dataHeaders);

                // ./Data Header

                // Data Details
                foreach ($this->inputs as $key => $item) {
                    $allDetails[] = [
                        // ดึงค่าจาก $item ซึ่งเก็บข้อมูลของแต่ละ index ไว้
                        'productId'  => $item['productId'] ?? null,
                        'toWhNo'       => $item['toWhNo'] ?? null,
                        'batchNo'    => strtoupper(trim($item['batchNo'] ?? '')),
                        'quantity'   => $item['quantity'] ?? 0,
                        'refInvoice' => strtoupper(trim($item['refInvoiceNo'] ?? '')),
                        'remark'     => trim($item['remark'] ?? ''),
                    ];
                }

                // dd($allDetails); // ลองดูค่าที่ออกมาจะเป็น Array ของทุก Item

                // dd($dataDetails);

                // .Data Detail

                // 1. Validation (เปิดใช้งานเมื่อพร้อม)
                // $this->validate([...]);

                // 1. บันทึกตารางหลักก่อน
                // $ncp = \App\Models\Ncp::create([
                //     'title' => $this->title,
                //     // ... fields อื่นๆ ...
                // ]);

                // 2. บันทึกข้อมูลหลัก (NCP) ลงฐานข้อมูลก่อน เพื่อเอา ID มาผูกกับรูป
                // $ncp = Ncp::create([...]);

                // 3. เรียกใช้ฟังก์ชันอัปโหลดรูป (ส่ง ID ของ record หลักไปด้วยถ้าจำเป็น)
                // $this->uploadImages($ncp->id);
                $this->uploadImages();

                // 4. ล้างค่าและแจ้งเตือน
                $this->reset(['imagePreviews']);

                $this->dispatch(
                    "toastr.success",
                    position: "toast-top-left", //toast-botton-left
                    progressbar: true,
                    timeout: 3000,
                    title: "สถานะการทำงาน",
                    message: 'บันทึกข้อมูล และอัปโหลดรูปเรียบร้อย',
                );
            });
        } catch (\Throwable $e) {
            $this->dispatch('toastr.error', title: 'เกิดข้อผิดพลาด', message: 'ไม่สามารถบันทึกได้: ' . $e->getMessage());
        }
    }

    // public function save()
    // {
    //     $this->validate();

    //     if (empty($this->inputs)) {
    //         $this->dispatchSweetError(
    //             "Please Add Product Item !!",
    //             ($this->sourceType == 'customer' ? "Customer: " : "Vendor: ") . $this->customerNameEng
    //         );
    //         return;
    //     }

    //     try {
    //         DB::transaction(function () {

    //             // 1. Validation (เปิดใช้งานเมื่อพร้อม)
    //             // $this->validate([...]);

    //             // 1. บันทึกตารางหลักก่อน
    //             // $ncp = \App\Models\Ncp::create([
    //             //     'title' => $this->title,
    //             //     // ... fields อื่นๆ ...
    //             // ]);

    //             // 2. บันทึกข้อมูลหลัก (NCP) ลงฐานข้อมูลก่อน เพื่อเอา ID มาผูกกับรูป
    //             // $ncp = Ncp::create([...]);

    //             // 3. เรียกใช้ฟังก์ชันอัปโหลดรูป (ส่ง ID ของ record หลักไปด้วยถ้าจำเป็น)
    //             // $this->uploadImages($ncp->id);
    //             $this->uploadImages();

    //             // 4. ล้างค่าและแจ้งเตือน
    //             $this->reset(['imagePreviews']);

    //             $this->dispatch(
    //                 "toastr.success",
    //                 position: "toast-top-left", //toast-botton-left
    //                 progressbar: true,
    //                 timeout: 3000,
    //                 title: "สถานะการทำงาน",
    //                 message: 'บันทึกข้อมูล และอัปโหลดรูปเรียบร้อย',
    //             );
    //         });
    //     } catch (\Throwable $e) {
    //         $this->dispatch('toastr.error', title: 'เกิดข้อผิดพลาด', message: 'ไม่สามารถบันทึกได้: ' . $e->getMessage());
    //     }
    // }

    public function render()
    {
        return view('livewire.ncp.ncp-create');
    }
}
