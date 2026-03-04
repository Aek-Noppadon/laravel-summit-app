@section('title', 'CRM')

<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CRM estimate backdate 2 years</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">CRM Lists</li>
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
                <div class="offset-8"></div>
                <div class="col-2">
                    <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <button wire:click="$dispatch('refresh-crm')" type="button" class="btn btn-success w-100">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
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
                        <th scope="col">Created</th>
                        <th scope="col" style="width: 35px"></th>
                        <th scope="col">Id</th>
                        <th scope="col">Number</th>
                        <th scope="col">Code</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Start Visit</th>
                        <th scope="col">Estimate</th>
                        <th scope="col">Contact</th>
                        <th scope="col" colspan="2" class="text-center">Items</th>
                        @can('crm.edit')
                        <th scope="col" colspan="2" class="text-center">Action</th>
                        @elsecan('crm.delete')
                        <th scope="col" colspan="2" class="text-center">Action</th>
                        @endcan
                    </thead>

                    <tbody>
                        @forelse ($crms as $item)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
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
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->document_no }}</td>
                            <td>{{ $item->customer->code }}</td>
                            <td>{{ $item->customer->name_english }}</td>
                            <td>{{ $item->customer_type->name }}</td>
                            <td>
                                {{ Carbon\Carbon::parse($item->started_visit_date)->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ Carbon\Carbon::parse($item->estimate_date)->format('d/m/Y') }}
                                <div>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{
                                        Carbon\Carbon::parse($item->estimate_date)->diffForHumans()
                                        }}
                                    </small>
                                </div>
                            </td>
                            <td>{{ $item->contact }}</td>
                            <td style="width: 40px" class="p-1 text-center">
                                <h5>
                                    <span class="badge badge-dark">{{ $item->crm_items_count }}</span>
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
                            @can('crm.edit')
                            <td style="width: 40px" class="p-1 text-center">
                                <a href="{{ route('crm.edit', $item->id) }}" class="btn btn-sm btn-primary"
                                    target="_blank">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            @endcan
                            @can('crm.delete')
                            <td style="width: 40px" class="p-1 text-center">
                                <button
                                    wire:click.prevent="crmDiscontinued({{ $item->id }},{{ "'" . $item->document_no . "'" }},{{ "'" . $item->customer->name_english . "'" }})"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-power-off"></i>
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
                                            <th scope="col">Qty.</th>
                                            <th scope="col">Unit Price</th>
                                            <th scope="col">Total Amt.</th>
                                            <th scope="col">Sales Stage</th>
                                            <th scope="col">Probability</th>
                                            <th scope="col">Update Visit</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->crm_items as $item)
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
                                                <td>{{ number_format($item->quantity, 2) }}</td>
                                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                                <td>{{ number_format($item->total_price, 2) }}</td>
                                                <td>{{ $item->salesStage->name }}</td>
                                                <td>{{ $item->probability->name }}</td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($item->updated_visit_date)->format('d/m/Y')
                                                    }}
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
        <!-- /.card-body -->

        <div class="modal-footer">
            <div class="col-12">
                {{ $crms->links() }}
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>

@script
<script>
    $wire.on("confirm", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure discontinued ?",
                html: `${event.document_no}<br>${event.name_english}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Discontinued"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("discontinued", {
                        id: event.id,
                        document_no: event.document_no,
                        name_english: event.name_english,
                    })

                }
            });
        });
</script>
@endscript