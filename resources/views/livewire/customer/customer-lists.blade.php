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
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                <div class="col-8">
                    <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                        placeholder="Search customer code or customer name">
                </div>
                <div class="col-1">
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
                        <th scope="col" style="width: 90px">#</th>
                        <th scope="col">Created</th>
                        <th scope="col">updated</th>
                        <th scope="col" style="width: 53px"></th>
                        <th scope="col" style="width: 90px">ID</th>
                        <th scope="col" style="width: 135px">Customer Code</th>
                        <th scope="col">Customer Name Eng.</th>
                        <th scope="col">Customer Name Thi.</th>
                        <th scope="col">Parent Code</th>
                        <th scope="col" style="width: 91px">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($customers as $item)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>
                                    {{ $item->created_at->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                        , {{ $item->userCreated->name }}
                                    </small>
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->updated_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light"><i class="far fa-clock"></i>
                                        {{ $item->updated_at->diffForHumans() }}
                                        , {{ $item->userUpdated->name }}
                                    </small>
                                </td>
                                <td>
                                    @if ($item->source === '0')
                                        <span class="badge badge-pill badge-info">
                                            AX
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $item->id }}</td>
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
