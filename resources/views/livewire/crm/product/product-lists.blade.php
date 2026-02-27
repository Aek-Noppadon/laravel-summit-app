<div wire:ignore.self class="modal fade" id="modal-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Product Master Lists</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-7">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search product name or brand name">
                    </div>
                    <div class="col-2">
                        <select wire:model.live="pagination" class="form-control">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-3 d-flex justify-content-center">
                        <div class="btn-group w-100" role="group">

                            @can('product.create')
                                <button wire:click="$dispatch('refresh-product-ax')" type="button"
                                    class="btn btn-secondary" data-toggle="modal" data-target="#modal-product-ax">
                                    <i class="fas fa-plus"></i> AX
                                </button>

                                {{-- @livewire('crm.product.product-ax-lists') --}}

                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#modal-add-product">
                                    <i class="fas fa-plus"></i> Add
                                </button>

                                {{-- @livewire('crm.product.product-create') --}}
                            @endcan

                            <button wire:click="$dispatch('refresh-product')" type="button" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <div wire:loading wire:target="search" class="spinner-border text-primary" role="status">
                            </div>
                            <div wire:loading wire:target="pagination" class="spinner-border text-primary"
                                role="status">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="table-info">
                            <th scope="col">#</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col" style="width: 35px"></th>
                            <th scope="col">Id</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Principal</th>
                            @can('crm.create')
                                <th scope="col" colspan="3" class="text-center">Action</th>
                            @elsecan('product.edit')
                                <th scope="col" colspan="3" class="text-center">Action</th>
                            @elsecan('product.delete')
                                <th scope="col" colspan="3" class="text-center">Action</th>
                            @endcan
                        </thead>

                        <tbody>
                            @foreach ($products as $item)
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
                                    <td class="text-center">
                                        @if ($item->source === '0')
                                            <span class="badge badge-pill badge-primary">
                                                AX
                                            </span>
                                        @elseif ($item->source === '1')
                                            <span class="badge badge-pill badge-info">
                                                Web
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-success">
                                                Excel
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->brand }}</td>
                                    <td>{{ $item->supplier_rep }}</td>
                                    <td>{{ $item->principal }}</td>

                                    @if ($item->source === '1' || $item->source === '2')
                                        @can('crm.create')
                                            <td style="width: 40px" class="p-1 text-center">
                                                <button
                                                    wire:click.prevent="$dispatch('select-product',{id:{{ $item->id }}})"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        @endcan

                                        @can('product.edit')
                                            <td style="width: 40px" class="p-1 text-center">
                                                <button
                                                    wire:click.prevent="$dispatch('edit-product',{id:{{ $item->id }}})"
                                                    type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                    data-target="#modal-edit-product">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        @endcan

                                        @can('product.delete')
                                            <td style="width: 40px" class="p-1 text-center">
                                                <button
                                                    wire:click.prevent="deleteProduct({{ $item->id }},{{ "'" . str_replace("'", '', $item->product_name) . "'" }})"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        @endcan
                                    @else
                                        {{-- Data Source = 0 AX --}}
                                        @can('crm.create')
                                            <td colspan="3" style="width: 40px" class="p-1 text-center">
                                                <button
                                                    wire:click.prevent="$dispatch('select-product',
                                            {id:{{ $item->id }}})"
                                                    wire:click="$dispatch('refresh-product')"
                                                    class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </td>
                                        @elsecan('product.edit')
                                            <td colspan="3"></td>
                                        @elsecan('product.delete')
                                            <td></td>
                                        @endcan
                                    @endif
                                </tr>
                            @endforeach

                            @livewire('crm.product.product-edit')

                        </tbody>
                    </table>

                    @livewire('crm.product.product-ax-lists')

                    @livewire('crm.product.product-create')

                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@script
    <script>
        $wire.on("confirm-delete-product", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                text: `Product : ${event.name}`,
                // text: `ID : ${event.id}, Product : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy-product", {
                        id: event.id,
                        name: event.name,
                    })

                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-product', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    $('#modal-edit-product').modal('hide')
                }, 3000);

            })
        })
    </script>
@endscript
