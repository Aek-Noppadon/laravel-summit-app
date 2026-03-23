@section('title', 'NCP')
<section class="content">

    <div class="container-fluid">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>NC Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('crm.list') }}">NCP List</a></li>
                            <li class="breadcrumb-item active">NCP</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        {{-- <form> --}}

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Form</h3>
            </div>

            <div class="card-body">

                <!-- Customer -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Customer Code
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <div class="input-group">
                                <input wire:model="customerCode" type="text" class="form-control" disabled readonly>
                                <div class="input-group-append">
                                    <!-- Customer Search -->
                                    <button wire:click="$dispatch('refresh-customer')" class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#modal-customer">
                                        <span data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Search">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </button>
                                    <!-- ./Customer Search -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Customer Name ENG. / ลูกค้า
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <input wire:model="customerNameEng" type="text" class="form-control" disabled readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Customer Name THI. / ลูกค้า</label>
                            <input wire:model="customerNameThi" type="text" class="form-control" disabled readonly>
                        </div>
                    </div>
                </div>
                <!-- ./Customer -->

                <!-- Vendor -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Vendor Code</label>
                            <div class="input-group">
                                <input wire:model="vendorCode" type="text" class="form-control" disabled readonly>
                                <div class="input-group-append">
                                    <!-- Vendor Search -->
                                    <button wire:click="$dispatch('refresh-vendor')" class="btn btn-primary btn-sm"
                                        data-toggle="modal" data-target="#modal-vendor">

                                        <span data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Search">
                                            <i class="fas fa-search"></i>
                                        </span>

                                    </button>
                                    <!-- ./Vendor Search -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">
                            Vendor Name ENG. / ผู้จำหน่าย
                            <span class="text-danger text-bold">*</span>
                        </label>
                        <input wire:model="vendorNameEng" type="text" class="form-control" disabled readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Vendor Name THI. / ผู้จำหน่าย</label>
                        <input type="text" class="form-control" disabled readonly>
                    </div>
                </div>
                <!-- ./Vendor -->

                <!-- Found during activity -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Found During Activity / ขณะที่พบ
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <div class="input-group">
                                <input wire:model="foundActivityName" type="text" class="form-control" disabled
                                    readonly>
                                <div class="input-group-append">
                                    <!-- Add Found During Activity -->
                                    <button wire:click="$dispatch('refresh-found-activity')" type="button"
                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#found-activity-modal">

                                        <span data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Search">
                                            <i class="fas fa-search"></i>
                                        </span>

                                    </button>
                                    <!-- ./Add Found During Activity -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">
                                Problem Description / ปัญหาที่พบ
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <!-- ./Found during activity -->

                <!-- Corrective Action (CA) -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Preventive Action (PA) / การดำเนินการป้องกัน</label>
                            <div class="input-group">
                                <input wire:model="preventiveActionName" type="text" class="form-control" disabled
                                    readonly>
                                <div class="input-group-append">
                                    <!-- Preventive Action (PA) -->
                                    <button wire:click="$dispatch('refresh-preventive-action')" type="button"
                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#preventive-action-modal">

                                        <span data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Search">
                                            <i class="fas fa-search"></i>
                                        </span>

                                    </button>
                                    <!-- ./Preventive Action (PA) -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">
                                Corrective Action (CA) / การดำเนินการแก้ไข
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <!-- ./Corrective Action (CA) -->

                <!-- Result -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">
                                Result / ผลการดำเนินการ
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <!-- ./Result -->

                <!-- Product Images -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>File input</label>
                            {{-- <div class="input-group"> --}}
                            <input wire:model="images" type="file" multiple class="form-control">
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="p-5">
                            @if (!empty($imagePreviews))
                                @foreach ($imagePreviews as $value)
                                    <img src="{{ $value }}" class="img-fluid"
                                        style="width: 300px>
@endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- ./Product Images -->

                <!-- Search Product Items & Submit -->
                <div class="row
                                        mb-3">

                                    <div class="col-6">
                                        <div class="btn-group w-100" role="group">
                                            <button wire:click="$dispatch('refresh-product')" type="button"
                                                class="btn btn-primary w-100" data-toggle="modal"
                                                data-target="#modal-product">
                                                <i class="fas fa-search"></i> Products
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <button wire:click.prevent="save" class="btn btn-success w-100">
                                            <i class="fas fa-save"></i> Submit
                                        </button>
                                    </div>
                        </div>
                        <!-- ./Search Product Items & Submit -->

                        <!-- Product Items -->
                        @foreach ($inputs as $key => $item)
                            <div class="card card-primary card-outline">

                                <div class="card-header">
                                    <h3 class="card-title">Item</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Product Code
                                                </label>
                                                <input id="inputs.{{ $key }}.productId"
                                                    wire:model="inputs.{{ $key }}.productId" type="text"
                                                    class="form-control" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Product Name
                                                </label>
                                                <input id="inputs.{{ $key }}.productName"
                                                    wire:model="inputs.{{ $key }}.productName" type="text"
                                                    class="form-control" disabled readonly>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="form-label">Brand</label>
                                                <input id="inputs.{{ $key }}.productBrand"
                                                    wire:model="inputs.{{ $key }}.productBrand"
                                                    type="text" class="form-control" disabled readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>To WH</label>
                                                <select id="inputs.{{ $key }}.whNo" class="form-control">
                                                    <option selected value="13">13</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Batch Number</label>
                                                <input id="inputs.{{ $key }}.batchNo"
                                                    wire:model="inputs.{{ $key }}.batchNo" type="text"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Quantity</label>
                                                <input x-number.2 id="inputs.{{ $key }}.quantity"
                                                    wire:model="inputs.{{ $key }}.quantity" type="text"
                                                    class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ref.Invoice</label>
                                                <input id="inputs.{{ $key }}.refInvoiceNo"
                                                    wire:model="inputs.{{ $key }}.refInvoiceNo"
                                                    type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ref.Purchase No.</label>
                                                <input id="inputs.{{ $key }}.refPurchaseNo"
                                                    wire:model="inputs.{{ $key }}.refPurchaseNo"
                                                    type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                        <!-- ./Product Items -->
                    </div>
                </div>

                {{-- </form> --}}

                @livewire('customer.customer-lists-modal')
                @livewire('vendor.vendor-lists-modal')
                @livewire('found-activity.lists-modal')
                @livewire('preventive-action.lists-modal')
                @livewire('crm.product.product-lists')

            </div>

</section>

<script>
    document.addEventListener('livewire:initialized', () => {
        // alert('Alert')
        @this.on('close-modal-customer-list', (event) => {
            setTimeout(() => {
                $('#modal-customer').modal('hide')
            }, 1000);
        })
        @this.on('close-modal-vendor-list', (event) => {
            setTimeout(() => {
                $('#modal-vendor').modal('hide')
            }, 1000);
        })
        @this.on('close-found-activity-modal', (event) => {
            setTimeout(() => {
                $('#found-activity-modal').modal('hide')
            }, 1000);
        })
        @this.on('close-preventive-action-modal', (event) => {
            setTimeout(() => {
                $('#preventive-action-modal').modal('hide')
            }, 1000);
        })
    })
</script>
