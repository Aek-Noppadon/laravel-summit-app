<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CRM Lists</h1>
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
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">

            <div class="row mb-3">
                <div class="col-3">
                    <label for="startVisit" class="form-label">Start Visit</label>
                    <input id="startVisit" wire:model.live="search_start_visit" type="date" class="form-control">
                </div>
                <div class="col-3">
                    <label for="endVisit" class="form-label">End Visit</label>
                    <input id="endVisit" wire:model.live="search_end_visit" type="date" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-2">
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
                <div class="col-2">
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
                <div class="col-3">
                    <label for="product" class="form-label">Product</label>
                    <input wire:model.live.debounce.1000ms="search_product" type="search" id="product"
                        class="form-control" placeholder="Search product name or brand">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-1">
                    <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('crm.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add CRM
                        </a>
                        <button wire:click="$dispatch('refresh-customer')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
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
                        <div wire:loading wire:target="pagination" class="spinner-border text-primary"
                            role="status">
                        </div>
                    </div>
                </div>
            </div>

            {{-- <a href="{{ route('crm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add CRM
            </a> --}}
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 165px">Created</th>
                        <th scope="col" style="width: 165px">updated</th>
                        <th style="width: 5%" scope="col">ID</th>
                        <th scope="col" style="width: 135px">Customer Code</th>
                        <th scope="col">Customer Name Eng.</th>
                        {{-- <th scope="col">Customer Name Thi.</th> --}}
                        <th scope="col" style="width: 135px">Start Visit</th>
                        <th scope="col" style="width: 135px">Month Estimate</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Items</th>
                        <th scope="col" colspan="3" class="text-center">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($crms as $item)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td> {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light"><i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                </td>
                                <td> {{ Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->updated_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light"><i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</small>
                                </td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->customer->code }}</td>
                                <td>{{ $item->customer->name_english }}</td>
                                {{-- <td>{{ $item->customer_thi }}</td> --}}
                                <td>
                                    {{ Carbon\Carbon::parse($item->started_visit_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($item->month_estimate_date)->format('d/m/Y') }}
                                </td>
                                <td>{{ $item->contact }}</td>
                                <td>
                                    <h5>
                                        <span class="badge badge-dark">{{ $item->crm_items_count }}</span>
                                    </h5>
                                </td>
                                <td>
                                    <a href="{{ route('crm.update', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <button
                                        wire:click.prevent="deleteCrm({{ $item->id }},{{ "'" . $item->name_english . "'" }})"
                                        class="btn btn-sm btn-danger">
                                        {{-- wire:confirm="Are you sure want to delete item" class="btn btn-sm btn-danger"> --}}
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="toggle({{ $item->id }})">
                                        {{ $isOpenId === $item->id ? 'Close Product detail' : 'Product detail' }}
                                    </button>
                                </td>
                            </tr>

                            {{-- @if ($isOpenId == $item->id) --}}
                            <tr>
                                <td colspan="11">
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <th scope="col">#</th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Brand</th>
                                            <th scope="col">Principal</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->crm_items as $item)
                                                <tr>
                                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                                    <td>{{ $item->product_id }}</td>
                                                    <td>{{ $item->product->product_name }}</td>
                                                    <td>{{ $item->product->brand }}</td>
                                                    <td>{{ $item->product->principal }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            {{-- @endif --}}
                            {{-- @foreach ($item->crm_items as $item)
                                <tr>
                                    <td>{{ $item->product_id }}</td>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td>{{ $item->product->brand }}</td>
                                </tr>
                            @endforeach --}}
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>

@script
    <script>
        $wire.on("confirm", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                text: `CRM Id : ${event.id}, Customer : ${event.name}`,
                // text: `ID : ${event.id}, Customer : ${event.name}`,
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
@endscript
