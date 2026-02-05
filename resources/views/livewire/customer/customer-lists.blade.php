<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customers</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <!-- Add Customer Modal -->
            <div class="row mb-4">
                <div class="col-7">
                    <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                        placeholder="Search customer code or customer name">
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
                        <button wire:click="$dispatch('add-customer')" type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#modal-add-customer">
                            <i class="fas fa-plus"></i> Customer
                        </button>
                        <button wire:click="$dispatch('refresh-customer')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>

                        @livewire('customer.customer-create')
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="search" class="spinner-border text-primary" role="status">
                        </div>
                        <div wire:loading wire:target="pagination" class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Add Customer Modal -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col" style="width: 35px"></th>
                        <th scope="col">Code</th>
                        <th scope="col">Name English</th>
                        <th scope="col">Name Thai</th>
                        <th scope="col">Parent</th>
                        <th scope="col" style="width: 100px">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($customers as $item)
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
                                <td>
                                    <div>
                                        <small class="badge badge-light">{{ $item->userUpdated->name }}</small>
                                    </div>
                                    <div>
                                        <small class="badge badge-light">
                                            {{ $item->updated_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <div>
                                        <small class="badge badge-light">
                                            <i class="far fa-clock"></i>
                                            {{ $item->updated_at->format('H:i') }},
                                            {{ $item->updated_at->diffForHumans() }}
                                        </small>
                                    </div>

                                </td>
                                <td>
                                    @if ($item->source === '0')
                                        <span class="badge badge-pill badge-info">
                                            AX
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-success">
                                            Excel
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name_english }}</td>
                                <td>{{ $item->name_thai }}</td>
                                <td>{{ $item->parent_code }}</td>
                                <td>
                                    @if ($item->source === '1')
                                        <button
                                            wire:click.prevent="$dispatch('edit-customer',{id:{{ $item->id }}})"
                                            type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal-edit-customer">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            wire:click.prevent="deleteCustomer({{ $item->id }},{{ "'" . str_replace("'", '', $item->name_english) . "'" }})"
                                            {{-- wire:click.prevent="deleteCustomer({{ $item->id }},{{ "'" . $item->name_english . "'" }})" --}} class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @livewire('customer.customer-edit')
                        {{-- <livewire:customer.customer-edit /> --}}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <div class="col-12">
                {{ $customers->links() }}
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
                position: "center",
                title: "Are you sure delete ?",
                text: `Customer : ${event.name}`,
                // text: `Customer Id : ${event.id}, Name : ${event.name}`,
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
