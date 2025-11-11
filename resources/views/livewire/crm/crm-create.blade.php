<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Add CRM</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">CRM</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- card -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">CRM Form</h3>
            </div>
            <!-- /.card-header -->

            {{-- <form wire:submit.prevent="save"> --}}
            <form>

                <!-- Customer Header -->
                <div class="card-body">

                    {{-- @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif --}}

                    <!-- CRM Header ID, Created Date, Updated Date -->
                    @isset($crmHeader_id)
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="mb-2 font-weight-bold">CRM ID</div>
                                    <div class="form-control bg-light">
                                        {{ $crmHeader_id }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <div class="mb-2 font-weight-bold">Created</div>
                                    <div class="form-control bg-light">
                                        {{ Carbon\Carbon::parse($crmHeader_created_at)->format('d/m/Y') }},
                                        {{ Carbon\Carbon::parse($crmHeader_created_at)->format('H:i:s') }},
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($crmHeader_created_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <div class="mb-2 font-weight-bold">Updated</div>
                                    <div class="form-control bg-light">
                                        {{ Carbon\Carbon::parse($crmHeader_updated_at)->format('d/m/Y') }},
                                        {{ Carbon\Carbon::parse($crmHeader_updated_at)->format('H:i:s') }},
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($crmHeader_updated_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                    <!-- ./CRM Header ID, Created Date, Updated Date -->

                    <!-- Customer Code, Customer Name Eng, Customer Name Thi -->
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="customerCode" class="form-label">Customer Code</label>
                                <input id="customerCode" wire:model="crmCreateForm.customerCode" type="text"
                                    class="form-control" disabled readonly>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="customerNameEng" class="form-label">Customer Name ENG.</label>
                                <span class="text-danger font-weight-bold">*</span>
                                <input id="customerNameEng" wire:model="crmCreateForm.customerNameEng" type="text"
                                    class="form-control @error('crmCreateForm.customerNameEng') is-invalid @enderror"
                                    disabled readonly>
                                @error('crmCreateForm.customerNameEng')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label for="customerNameThi" class="form-label">Customer Name THI.</label>
                                <input id="customerNameThi" wire:model='crmCreateForm.customerNameThi' type="text"
                                    class="form-control" disabled readonly>
                            </div>
                        </div>
                    </div>
                    <!-- ./Customer Code, Customer Name Eng, Customer Name Thi -->

                    <!-- Start Visit, Month Estimate, Customer Type, Customer Group -->
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="startVisit" class="form-label">Start Visit</label>
                                <span class="text-danger font-weight-bold">*</span>
                                <input id="startVisit" wire:model="crmCreateForm.startVisit" type="date"
                                    class="form-control @error('crmCreateForm.startVisit') is-invalid @enderror">
                                @error('crmCreateForm.startVisit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="monthEstimate" class="form-label">Month Estimate</label>
                                <span class="text-danger font-weight-bold">*</span>
                                <input id="monthEstimate" wire:model="crmCreateForm.monthEstimate" type="date"
                                    class="form-control @error('crmCreateForm.monthEstimate') is-invalid @enderror">
                                @error('crmCreateForm.monthEstimate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="customerType" class="form-label">Customer Type</label>
                                <span class="text-danger font-weight-bold">*</span>

                                <!-- Modal Customer Type List -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#modal-customer-type">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <!-- ./Modal Customer Type List -->

                                <div wire:loading wire:target="selectedCustomerType" class="spinner-border text-primary"
                                    style="width: 1.2rem;height:1.2rem" role="status">
                                </div>
                                <select id="customerType" wire:model="crmCreateForm.customerType"
                                    wire:focus.debounce.1000ms="selectedCustomerType"
                                    class="form-control @error('crmCreateForm.customerType') is-invalid @enderror">
                                    <option value="">-- Select --</option>
                                    @foreach ($customerTypes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('crmCreateForm.customerType')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="customerGroup" class="form-label">Customer Group</label>

                                <!-- Modal Customer Group List -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#modal-customer-group">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <!-- ./Modal Customer Group List -->

                                <div wire:loading wire:target="selectedCustomerGroup"
                                    class="spinner-border text-primary" style="width: 1.2rem;height:1.2rem"
                                    role="status">
                                </div>
                                <select id="customerGroup" wire:model="crmCreateForm.customerGroup"
                                    wire:focus.debounce.1000ms="selectedCustomerGroup" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach ($customerGroups as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- ./Start Visit, Month Estimate, Customer Type, Customer Group -->

                    <!-- Contact Person -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="contact" class="form-label">Contact Person</label>
                                <span class="text-danger font-weight-bold">*</span>
                                <input id="contact" wire:model="crmCreateForm.contact" type="text"
                                    class="form-control @error('crmCreateForm.contact') is-invalid @enderror">
                                @error('crmCreateForm.contact')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- ./Contact Person -->

                    <!-- Purpose, Detail -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="purpose" class="form-label">Purpose</label>
                                <span class="text-danger font-weight-bold">*</span>
                                <textarea id="purpose" wire:model="crmCreateForm.purpose"
                                    class="form-control @error('crmCreateForm.purpose') is-invalid @enderror" cols="30" rows="5"></textarea>
                                @error('crmCreateForm.purpose')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="detail" class="form-label">Detail</label>
                                <textarea id="detail" wire:model="crmCreateForm.detail" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- ./Purpose, Detail -->
                </div>

                <!-- Customer Modal, Produc Modal, Save -->
                <div class="card-footer">
                    <div class="row">

                        <!-- Customer Modal -->
                        <div class="col-5">
                            <!-- Search Customer Modal -->
                            <div class="btn-group w-100" role="group">
                                <button wire:click="$dispatch('refresh-customer')" type="button"
                                    class="btn btn-primary" data-toggle="modal" data-target="#modal-customer">
                                    <i class="fas fa-search"></i> Customers
                                </button>

                                @livewire('crm.customer.customer-lists')

                                {{-- @livewire('crm.select-customer') --}}

                                <!-- ./Customer Modal -->

                                <!-- Search Customer AX Modal -->
                                <button wire:click="$dispatch('refresh-customer-ax')" type="button"
                                    class="btn btn-secondary" data-toggle="modal" data-target="#modal-customer-ax">
                                    <i class="fas fa-plus"></i> Customers AX
                                </button>

                                @livewire('crm.customer.customer-ax-lists')
                                {{-- @livewire('crm.select-customer-ax') --}}
                                <!-- ./Customer Modal AX -->

                                <!-- Add Customer Modal -->
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#modal-add-customer">
                                    <i class="fas fa-plus"></i> Customer
                                </button>

                                @livewire('crm.customer.customer-create')
                                {{-- @livewire('crm.customer-create') --}}
                                <!-- ./Add Customer Modal -->
                            </div>
                        </div>
                        <!-- ./Customer Modal -->

                        <!-- Product Modal -->
                        <div class="col-5">
                            <div class="btn-group w-100" role="group">
                                <button wire:click="$dispatch('refresh-product')" type="button"
                                    class="btn btn-primary w-100" data-toggle="modal" data-target="#modal-product">
                                    <i class="fas fa-search"></i> Products
                                </button>

                                @livewire('crm.product.product-lists')

                                {{-- @livewire('crm.select-product') --}}

                                <button wire:click="$dispatch('refresh-product-ax')" type="button"
                                    class="btn btn-secondary w-100" data-toggle="modal"
                                    data-target="#modal-product-ax">
                                    <i class="fas fa-plus"></i> Products AX
                                </button>

                                @livewire('crm.product.product-ax-lists')

                                {{-- @livewire('crm.select-product-ax') --}}

                                <button type="button" class="btn btn-info w-100" data-toggle="modal"
                                    data-target="#modal-add-product">
                                    <i class="fas fa-plus"></i> Product
                                </button>

                                @livewire('crm.product.product-create')

                                {{-- @livewire('crm.product-create') --}}

                            </div>
                        </div>
                        <!-- ./Product Modal -->

                        <!-- Save CRM -->
                        <div class="col-2">
                            {{-- <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-save"></i> Save
                            </button> --}}
                            <button wire:click.prevent="save" class="btn btn-success w-100">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </div>
                <!-- ./Customer Moal -->

                <!-- CRM Details -->
                @foreach ($inputs as $key => $item)
                    @php
                        $crm_detail_id = $item['crmDetail_id'];
                        $product_name = $item['productName'];
                    @endphp

                    <div class="card-body">

                        <!-- CRM Detail ID, Created Date, Updated Date -->
                        @isset($crm_detail_id)
                            <div class="row">
                                <div class="col-2">
                                    <div class="form-group">
                                        <div class="mb-2 font-weight-bold">Item ID</div>
                                        <div class="form-control bg-light">
                                            {{ $crm_detail_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <div class="mb-2 font-weight-bold">Created</div>
                                        <div class="form-control bg-light">
                                            {{ Carbon\Carbon::parse($item['created_at'])->format('d/m/Y') }},
                                            {{ Carbon\Carbon::parse($item['created_at'])->format('H:i:s') }},
                                            <i class="far fa-clock"></i>
                                            {{ Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <div class="mb-2 font-weight-bold">updated</div>
                                        <div class="form-control bg-light">
                                            {{ Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y') }},
                                            {{ Carbon\Carbon::parse($item['updated_at'])->format('H:i:s') }},
                                            <i class="far fa-clock"></i>
                                            {{ Carbon\Carbon::parse($item['updated_at'])->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endisset
                        <!-- ./CRM Header ID, Created Date, Updated Date -->

                        <!-- Product Name -->
                        <div class="row">
                            {{-- <div class="col-1">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.crmDetail_id" class="form-label">
                                        Item ID
                                    </label>
                                    <input id="inputs.{{ $key }}.crmDetail_id"
                                        wire:model="inputs.{{ $key }}.crmDetail_id" type="text"
                                        class="form-control" disabled readonly>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.productName" class="form-label">Product
                                        Name</label>
                                    <span class="text-danger font-weight-bold">*</span>
                                    <input id="inputs.{{ $key }}.productName"
                                        wire:model="inputs.{{ $key }}.productName" type="text"
                                        class="form-control @error('inputs.' . $key . '.productName') is-invalid @enderror"
                                        disabled readonly>
                                    @error('inputs.' . $key . '.productName')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- ./Product Name -->

                        <!-- Product Brand, Supplier Rep, Principle -->
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.productBrand" class="form-label">Brand
                                        Name</label>
                                    <span class="text-danger font-weight-bold">*</span>
                                    <input id="inputs.{{ $key }}.productBrand"
                                        wire:model="inputs.{{ $key }}.productBrand" type="text"
                                        class="form-control @error('inputs.' . $key . '.productBrand') is-invalid @enderror"
                                        disabled readonly>
                                    @error('inputs.' . $key . '.productBrand')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.supplierRep" class="form-label">Supplier
                                        Rep.</label>
                                    <input id="inputs.{{ $key }}.supplierRep"
                                        wire:model="inputs.{{ $key }}.supplierRep" type="text"
                                        class="form-control" disabled readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.principal"
                                        class="form-label">Principle</label>
                                    <input id="inputs.{{ $key }}.principal"
                                        wire:model="inputs.{{ $key }}.principal" type="text"
                                        class="form-control" disabled readonly>
                                </div>
                            </div>
                        </div>
                        <!-- ./Product Brand, Supplier Rep, Principle -->

                        <!-- Update Visit, Application, Sales Stage, Probablility -->
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.updateVisit" class="form-label">Update
                                        Visit</label>
                                    <span class="text-danger font-weight-bold">*</span>
                                    <input id="inputs.{{ $key }}.updateVisit"
                                        wire:model="inputs.{{ $key }}.updateVisit" type="date"
                                        class="form-control @error('inputs.' . $key . '.updateVisit') is-invalid @enderror">
                                    @error('inputs.' . $key . '.updateVisit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.application" class="form-label">
                                        Application
                                    </label>

                                    <!-- Modal Application List -->
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#modal-application">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <!-- ./Modal Application List -->

                                    <div wire:loading wire:target="selectedApplication"
                                        class="spinner-border text-primary" style="width: 1.2rem;height:1.2rem"
                                        role="status">
                                    </div>
                                    <select id="inputs.{{ $key }}.application"
                                        wire:model="inputs.{{ $key }}.application"
                                        wire:focus.debounce.1000ms="selectedApplication" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach ($applications as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.salesStage" class="form-label">
                                        Sales Stage
                                    </label>
                                    <span class="text-danger font-weight-bold">*</span>
                                    <div wire:loading wire:target="selectedSalesStage"
                                        class="spinner-border text-primary" style="width: 1.2rem;height:1.2rem"
                                        role="status">
                                    </div>
                                    <select id="inputs.{{ $key }}.salesStage"
                                        wire:model="inputs.{{ $key }}.salesStage"
                                        wire:focus.debounce.1000ms="selectedSalesStage"
                                        class="form-control @error('inputs.' . $key . '.salesStage') is-invalid @enderror">
                                        <option value="">-- Select --</option>
                                        @foreach ($salesStages as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('inputs.' . $key . '.salesStage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.probability" class="form-label">
                                        Probability
                                    </label>
                                    <span class="text-danger font-weight-bold">*</span>

                                    <!-- Modal Probability List -->
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#modal-probability">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <!-- ./Modal Probability List -->

                                    <div wire:loading wire:target="selectedProbability"
                                        class="spinner-border text-primary" style="width: 1.2rem;height:1.2rem"
                                        role="status">
                                    </div>
                                    <select id="inputs.{{ $key }}.probability"
                                        wire:model="inputs.{{ $key }}.probability"
                                        wire:focus.debounce.1000ms="selectedProbability"
                                        class="form-control @error('inputs.' . $key . '.probability') is-invalid @enderror">
                                        <option value="">-- Select --</option>
                                        @foreach ($probabilities as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('inputs.' . $key . '.probability')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- ./Update Visit, Application, Sales Stage, Probablility -->

                        <!-- Quantity, Unit Price, Total Price -->
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.quantity"
                                        class="form-label">Quantity</label>
                                    <input id="inputs.{{ $key }}.quantity"
                                        wire:model="inputs.{{ $key }}.quantity" step="any"
                                        wire:keyup.debounce.1000ms="sumRow({{ $key }})"
                                        wire:change="sumRow({{ $key }})" type="number"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.unitPrice" class="form-label">Unit
                                        Price</label>
                                    <input id="inputs.{{ $key }}.unitPrice"
                                        wire:model="inputs.{{ $key }}.unitPrice" step="any"
                                        wire:keyup.debounce.1000ms="sumRow({{ $key }})"
                                        wire:change="sumRow({{ $key }})" type="number"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.totalPrice" class="form-label">Total
                                        Price</label>
                                    <input id="inputs.{{ $key }}.totalPrice"
                                        wire:model="inputs.{{ $key }}.totalPrice" type="text"
                                        class="form-control" disabled readonly>
                                </div>
                            </div>
                        </div>
                        <!-- ./Quantity, Unit Price, Total Price -->

                        <!--Packing Unit, Volumn Qty, Volumn Unit -->
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.packingUnit" class="form-label">Packing
                                        Unit</label>
                                    <div wire:loading wire:target="selectedPackingUnit"
                                        class="spinner-border text-primary" style="width: 1.2rem;height:1.2rem"
                                        role="status">
                                    </div>
                                    <select id="inputs.{{ $key }}.packingUnit"
                                        wire:model="inputs.{{ $key }}.packingUnit"
                                        wire:focus.debounce.1000ms="selectedPackingUnit" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach ($packingUnits as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.volumnQty" class="form-label">Volumn
                                        QTY.</label>
                                    <input id="inputs.{{ $key }}.volumnQty" type="number"
                                        class="form-control" step="any"
                                        wire:model="inputs.{{ $key }}.volumnQty">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.volumnUnit" class="form-label">Volumn
                                        Unit</label>
                                    <div wire:loading wire:target="selectedVolumnUnit"
                                        class="spinner-border text-primary" style="width: 1.2rem;height:1.2rem"
                                        role="status">
                                    </div>
                                    <select id="inputs.{{ $key }}.volumnUnit"
                                        wire:model="inputs.{{ $key }}.volumnUnit" step="any"
                                        wire:focus.debounce.1000ms="selectedVolumnUnit" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach ($volumnUnits as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- ./Packing Unit, Volumn Qty, Volumn Unit -->

                        <!-- Additional Information, Competitor Situation -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.additional" class="form-label">Additional
                                        Information</label>
                                    {{-- <span class="text-danger">*</span> --}}
                                    <textarea id="inputs.{{ $key }}.additional" wire:model="inputs.{{ $key }}.additional"
                                        class="form-control @error('inputs.' . $key . '.additional') is-invalid @enderror" cols="30"
                                        rows="5"></textarea>
                                    {{-- @error('inputs.' . $key . '.additional')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inputs.{{ $key }}.competitor" class="form-label">Competitor
                                        Situation</label>
                                    <textarea id="inputs.{{ $key }}.competitor" wire:model="inputs.{{ $key }}.competitor"
                                        class="form-control" cols="30" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--./ Aditional Information, Competitor Situation -->
                    </div>

                    <!-- Product Modal, Product Remove -->
                    <div class="card-footer">
                        <div class="row">
                            @if ($crm_detail_id)
                                <div class="col-6">
                                    <!-- Button Product Modal, Button Save -->
                                    <button wire:click="$dispatch('refresh-product')" type="button"
                                        class="btn btn-primary w-100" data-toggle="modal"
                                        data-target="#modal-product">
                                        <i class="fas fa-search"></i> Products
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button
                                        wire:click.prevent="deleteItem({{ $crm_detail_id }},{{ "'" . str_replace("'", '', $product_name) . "'" }})"
                                        {{-- wire:click.prevent="deleteItem({{ $crm_detail_id }},{{ "'" . $product_name . "'" }})" --}} {{-- wire:confirm="Are you sure want to delete item"  --}} class="btn btn-danger w-100">
                                        <i class="fas fa-trash"></i> Delete Item from Database
                                    </button>
                                </div>
                            @else
                                <div class="col-6">
                                    <!-- Button Product Modal, Button Save -->
                                    <button wire:click="$dispatch('refresh-product')" type="button"
                                        class="btn btn-primary w-100" data-toggle="modal"
                                        data-target="#modal-product">
                                        <i class="fas fa-search"></i> Products
                                    </button>
                                </div>
                                <div class="col-6">
                                    {{-- <button wire:click.prevent="deleteRow({{ $key }})" --}}
                                    <button
                                        wire:click.prevent="removeItem({{ $key }},{{ "'" . str_replace("'", '', $product_name) . "'" }})"
                                        {{-- wire:click.prevent="removeItem({{ $key }},{{ "'" . $product_name . "'" }})" --}} class="btn btn-info w-100">
                                        <i class="fas fa-minus"></i> Remove Item
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- ./Product Modal, Product Remove -->
                @endforeach

                <!-- ./CRM Details -->

                <!-- Customer Type List Component -->
                @livewire('crm.customer-type.customer-type-lists')
                <!-- ./Customer Type List Component -->

                <!-- Customer Group List Component -->
                @livewire('crm.customer-group.customer-group-lists')
                <!-- ./Customer Group List Component -->

                <!-- Application List Component -->
                @livewire('crm.application.application-lists')
                <!-- ./Application List Component -->

                <!-- Probability List Component -->
                @livewire('crm.probability.probability-lists')
                <!-- ./Probability List Component -->

            </form>

        </div>
        <!-- /.card -->

    </div>
</section>

@script
    <!-- Sweet Alert -->
    <script>
        $wire.on("confirm", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                text: `Item id : ${event.id}, Product : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy", {
                        id: event.id,
                        name: event.name,
                    })

                }
            });
        });
    </script>
    <!-- ./Sweet Alert -->
@endscript
