<?php

namespace App\Livewire\Ncp;

use App\Models\Customer;
use App\Models\FoundActivity;
use App\Models\PreventiveAction;
use App\Models\Product;
use App\Models\Vendor;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class NcpCreate extends Component
{
    use WithFileUploads;

    public $customerId, $customerCode, $customerNameEng, $customerNameThi;
    public $vendorId, $vendorCode, $vendorNameEng;
    public $foundActivityId, $foundActivityName;
    public $preventiveActionId, $preventiveActionName;
    public $productId, $productName, $productBrand, $whNo, $batchNo, $quantity, $refInvoiceNo, $refPurchaseNo;
    public $inputs = [];
    public $images = [];
    public $imagePreviews = [];

    public function updatedImages()
    {
        info("test");

        $this->imagePreviews = [];

        foreach ($this->images as $image) {
            $this->imagePreviews[] = $image->temporaryUrl();
        }
    }

    public function render()
    {
        return view('livewire.ncp.ncp-create');
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

        $this->vendorId = $vendor->id;
        $this->vendorCode = $vendor->code;
        $this->vendorNameEng = $vendor->name_english;

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
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->productName = $product->product_name;
        $this->productBrand = $product->brand;

        $this->inputs[] = [
            'productId' => $this->productId,
            'productName' => $this->productName,
            'productBrand' => $this->productBrand,
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
}
