@section('title', 'CRM')

<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CRM Delete Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">CRM Delete</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <div class="row mb-3">
                <div class="col-7">
                    <h4>Numbers</h4>
                </div>
                <div class="col-2">
                    <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="btn-group w-100" role="group">
                        <button wire:click="$dispatch('refresh-crm')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button wire:click="toggleSearch(true)" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>

            @if ($isOpenSearch == false)
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="startVisit" class="form-label">Start Visit</label>
                            <input id="startVisit" wire:model.live="search_start_visit" type="date"
                                class="form-control">
                        </div>
                        <div class="col-3">
                            <label for="endVisit" class="form-label">End Visit</label>
                            <input id="endVisit" wire:model.live="search_end_visit" type="date" class="form-control">
                        </div>
                        <div class="col-3">
                            <label for="startEstimateDate" class="form-label">Start Estimate Date</label>
                            <input id="startEstimateDate" wire:model.live="search_start_estimate_date" type="date"
                                class="form-control">
                        </div>
                        <div class="col-3">
                            <label for="endEstimateDate" class="form-label">End Estimate Date</label>
                            <input id="endEstimateDate" wire:model.live="search_end_estimate_date" type="date"
                                class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="customerType" class="form-label">Customer Type</label>
                            <div wire:loading wire:target="selectedCustomerType" class="spinner-border text-primary"
                                style="width: 1.2rem;height:1.2rem" role="status">
                            </div>
                            <select id="customerType" wire:model="search_customer_type"
                                wire:click.debounce.1000ms="selectedCustomerType" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach ($customerTypes as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="customerGroup" class="form-label">Customer Group</label>
                            <div wire:loading wire:target="selectedCustomerGroup" class="spinner-border text-primary"
                                style="width: 1.2rem;height:1.2rem" role="status">
                            </div>
                            <select id="customerGroup" wire:model="search_customer_group"
                                wire:click.debounce.1000ms="selectedCustomerGroup" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach ($customerGroups as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="customer" class="form-label">Customer</label>
                            <input wire:model.live.debounce.1000ms="search_customer" type="search" id="customer"
                                class="form-control" placeholder="Search customer code or customer name">
                        </div>
                        <div class="col-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input wire:model.live.debounce.1000ms="search_contact" type="search" id="contact"
                                class="form-control" placeholder="Search contact">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-3">
                            <label for="startUpdateVisit" class="form-label">Start Update Visit</label>
                            <input id="startUpdateVisit" wire:model.live="search_start_update_visit" type="date"
                                class="form-control">
                        </div>
                        <div class="col-3">
                            <label for="endUpdateVisit" class="form-label">End Update Visit</label>
                            <input id="endUpdateVisit" wire:model.live="search_end_update_visit" type="date"
                                class="form-control">
                        </div>
                        <div class="col-3">
                            <label for="salesStage" class="form-label">Sales Stage</label>
                            <div wire:loading wire:target="selectedsalesStage" class="spinner-border text-primary"
                                style="width: 1.2rem;height:1.2rem" role="status">
                            </div>
                            <select id="salesStage" wire:model="search_sales_stage"
                                wire:click.debounce.1000ms="selectedsalesStage" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach ($salesStages as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="product" class="form-label">Product</label>
                            <input wire:model.live.debounce.1000ms="search_product" type="search" id="product"
                                class="form-control" placeholder="Search product name or brand">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="search_customer_type" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="search_contact" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="search_customer" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="search_product" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="pagination" class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="table-info">
                        <th scope="col">#</th>
                        <th scope="col">Deleted</th>
                        <th scope="col">Created</th>
                        <th scope="col" style="width: 35px"></th>
                        <th scope="col">Number</th>
                        <th scope="col">Code</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Start Visit</th>
                        <th scope="col">Estimate</th>
                        <th scope="col">Contact</th>
                        <th scope="col" colspan="2">Items</th>
                        @can('crmDelete.restore')
                        <th scope="col" colspan="2">Action</th>
                        @elsecan('crmDelete.delete')
                        <th scope="col" colspan="2">Action</th>
                        @endcan
                    </thead>

                    <tbody>
                        @forelse ($crms as $item)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                <div>
                                    <small class="badge badge-light">
                                        {{ $item->deleted_at->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ $item->deleted_at->format('H:i') }},
                                        {{ $item->deleted_at->diffForHumans() }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small class="badge badge-light">{{ $item->userCreated->name }}</small>
                                </div>
                                <div>
                                    <small class="badge badge-light">
                                        {{ $item->created_at->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ $item->created_at->format('H:i') }},
                                        {{ $item->created_at->diffForHumans() }}
                                    </small>
                                </div>

                            </td>
                            <td class="text-center">
                                @if ($item->source === '0')
                                <span class="badge badge-pill badge-success">
                                    Excel
                                </span>
                                @else
                                <span class="badge badge-pill badge-info">
                                    Web
                                </span>
                                @endif
                            </td>
                            <td>{{ $item->document_no }}</td>
                            <td>{{ $item->customer->code }}</td>
                            <td>{{ $item->customer->name_english }}</td>
                            <td>{{ $item->customer_type->name }}</td>
                            <td>
                                {{ Carbon\Carbon::parse($item->started_visit_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($item->estimate_date)->format('d/m/Y') }}
                            </td>
                            <td>{{ $item->contact }}</td>
                            <td style="width: 40px" class="p-1 text-center">
                                <h5>
                                    <span class="badge badge-dark">{{ $item->crm_items_deleted_count }}</span>
                                </h5>
                            </td>
                            <td style="width: 40px" class="p-1 text-center">
                                <button class="btn btn-sm btn-primary" wire:click="toggle({{ $item->id }})">
                                    @if ($isOpenId == $item->id)
                                    <i class="fas fa-minus"></i>
                                    @else
                                    <i class="fas fa-plus"></i>
                                    @endif
                                </button>
                            </td>
                            @can('crmDelete.restore')
                            <td style="width: 40px" class="p-1 text-center">
                                <button
                                    wire:click.prevent="confirmRestoreCrm({{ $item->id }},{{ "'" . $item->document_no . "'" }},{{ "'" . $item->customer->name_english . "'" }})"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-trash-restore"></i>
                                </button>
                            </td>
                            @endcan

                            @can('crmDelete.delete')
                            <td style="width: 40px" class="p-1 text-center">
                                <button
                                    wire:click.prevent="confirmDeleteCrm({{ $item->id }},{{ "'" . $item->document_no . "'" }},{{ "'" . $item->customer->name_english . "'" }})"
                                    class="btn btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                            @endcan

                        </tr>

                        @if ($isOpenId == $item->id)
                        <tr>
                            <td colspan="15">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover table-bordered">
                                        <thead class="table-warning">
                                            <th scope="col">#</th>
                                            <th scope="col">Application</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Supplier Rep.</th>
                                            {{-- <th scope="col">Principal</th> --}}
                                            <th scope="col">Qty.</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Total Amt.</th>
                                            <th scope="col">Sales Stage</th>
                                            <th scope="col">Probability</th>
                                            <th scope="col">Update Visit</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->crm_items_deleted as $item)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>
                                                    @if ($item->application)
                                                    {{ $item->application->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $item->product->product_name }}</td>
                                                <td>{{ $item->product->brand }}</td>
                                                <td>{{ $item->product->supplier_rep }}</td>
                                                {{-- <td>{{ $item->product->principal }}</td> --}}
                                                <td>{{ number_format($item->quantity, 2) }}</td>
                                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                                <td>{{ number_format($item->total_price, 2) }}</td>
                                                <td>{{ $item->salesStage->name }}</td>
                                                <td>{{ $item->probability->name }}</td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($item->updated_visit)->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td colspan="14">
                                <span class="d-flex justify-content-center lead">No Data</span>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>

        <div class="modal-footer">
            <div class="col-12">
                {{ $crms->links() }}
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <div class="row mb-3">
                <div class="col-7">
                    <h4>Items</h4>
                </div>
                <div class="col-2 offset-3">
                    <select wire:model.live.debounce.1000ms="paginationItem" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="search_customer_type" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="search_contact" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="search_customer" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="search_product" class="spinner-border text-primary"
                            role="status"></div>
                        <div wire:loading wire:target="paginationItem" class="spinner-border text-primary"
                            role="status">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="table-warning">
                        <th scope="col">#</th>
                        <th scope="col">Deleted</th>
                        <th scope="col" style="width: 35px"></th>
                        <th scope="col">Number</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Qty.</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                        <th scope="col">Sales Stage</th>
                        <th scope="col">Probability</th>
                        <th scope="col" style="width: 100px">Update Visit</th>
                        @can('crmDelete.restore')
                        <th scope="col" colspan="2">Action</th>
                        @elsecan('crmDelete.delete')
                        <th scope="col" colspan="2">Action</th>
                        @endcan
                    </thead>
                    <tbody>

                        @forelse ($crmDetails as $item)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>
                                <div>
                                    <small class="badge badge-light">
                                        {{ $item->deleted_at->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ $item->deleted_at->format('H:i') }}
                                    </small>
                                </div>
                                <div>
                                    <small class="badge badge-light">
                                        {{ $item->deleted_at->diffForHumans() }}
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($item->source === '0')
                                <span class="badge badge-pill badge-success">
                                    Excel
                                </span>
                                @else
                                <span class="badge badge-pill badge-info">
                                    Web
                                </span>
                                @endif
                            </td>
                            <td>{{ $item->crmHeader->document_no }}</td>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->product->brand }}</td>
                            <td>{{ $item->product->supplier_rep }}</td>
                            <td>{{ number_format($item->quantity, 2) }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ number_format($item->total_price, 2) }}</td>

                            <td>{{ $item->salesStage->name }}</td>
                            <td>{{ $item->probability->name }}</td>
                            <td>
                                {{ Carbon\Carbon::parse($item->updated_visit)->format('d/m/Y') }}
                            </td>
                            @can('crmDelete.restore')
                            <td style="width: 40px" class="p-1 text-center">
                                <button
                                    wire:click.prevent="confirmRestoreCrmItem({{ $item->id }},{{ "'" . $item->crmHeader->document_no . "'" }},{{ "'" . $item->product->product_name . "'" }})"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-trash-restore"></i>
                                </button>
                            </td>
                            @endcan

                            @can('crmDelete.delete')
                            <td style="width: 40px" class="p-1 text-center">
                                <button
                                    wire:click.prevent="confirmDeleteCrmItem({{ $item->id }},{{ "'" . $item->crmHeader->document_no . "'" }},{{ "'" . $item->product->product_name . "'" }})"
                                    class="btn btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14">
                                <span class="d-flex justify-content-center lead">No Data</span>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <div class="col-12">
                {{ $crmDetails->links() }}
            </div>
        </div>
    </div>

</section>

@script
<script>
    $wire.on("confirmRestoreCrm", (event) => {

            // alert("Restore " + event.name_english);

            Swal.fire({
                title: "Are you sure restore ?",
                html: `${event.document_no}<br>${event.name_english}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Restore"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("restoreCrm", {
                        id: event.id,
                        document_no: event.document_no,
                        name_english: event.name_english,
                    })

                }
            });
        });

        $wire.on("confirmRestoreCrmItem", (event) => {
            Swal.fire({
                title: "Are you sure restore ?",
                html: `${event.document_no}<br>${event.product_name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Restore"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("restoreCrmItem", {
                        id: event.id,
                        document_no: event.document_no,
                        product_name: event.product_name,
                    })

                }
            });
        });

        $wire.on("confirmCrm", (event) => {

            // alert(event.name_english);

            Swal.fire({
                title: "Are you sure delete ?",
                html: `${event.document_no}<br>${event.name_english}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroyCrm", {
                        id: event.id,
                        document_no: event.document_no,
                        name_english: event.name_english,
                    })

                }
            });
        });

        $wire.on("confirmDeleteCrmItem", (event) => {

            // alert(event.product_name);

            Swal.fire({
                title: "Are you sure delete ?",
                html: `${event.document_no}<br>${event.product_name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroyCrmItem", {
                        id: event.id,
                        document_no: event.document_no,
                        product_name: event.product_name,
                    })

                }
            });
        });
</script>
@endscript