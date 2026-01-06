<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <!-- Add Product Modal -->
            <div class="row mb-4">
                <div class="col-8">
                    <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                        placeholder="Search product or brand">
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
                        <button wire:click="$dispatch('add-product')" type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#modal-add-product">
                            <i class="fas fa-plus"></i> Product
                        </button>
                        <button wire:click="$dispatch('refresh-product')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>

                        @livewire('product.product-create')
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
            <!-- ./Add Product Modal -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        {{-- <th scope="col" style="width: 90px">#</th> --}}
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col"></th>
                        {{-- <th scope="col" style="width: 53px"></th> --}}
                        <th scope="col">Code</th>
                        {{-- <th scope="col" style="width: 135px">Product Code</th> --}}
                        <th scope="col">Name</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Supplier Rep.</th>
                        <th scope="col">Principal</th>
                        <th scope="col" style="width: 100px">Action</th>
                        {{-- <th scope="col" style="width: 91px">Action</th> --}}
                    </thead>

                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td> {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                        , {{ $item->userCreated->name }}
                                    </small>
                                </td>
                                <td> {{ Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->updated_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
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
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->brand }}</td>
                                <td>{{ $item->supplier_rep }}</td>
                                <td>{{ $item->principal }}</td>
                                <td>
                                    @if ($item->source === '1')
                                        <button wire:click.prevent="$dispatch('edit-product',{id:{{ $item->id }}})"
                                            type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal-edit-product">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            wire:click.prevent="deleteProduct({{ $item->id }},{{ "'" . str_replace("'", '', $item->product_name) . "'" }})"
                                            {{-- wire:click.prevent="deleteitem({{ $item->id }},{{ "'" . $item->product_name . "'" }})" --}} class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        @livewire('product.product-edit')
                        {{-- <livewire:product.product-edit /> --}}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <div class="col-12">
                {{ $products->links() }}
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
                text: `Product : ${event.name}`,
                // text: `Product Id : ${event.id}, Name : ${event.name}`,
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
