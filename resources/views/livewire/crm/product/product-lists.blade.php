<div wire:ignore.self class="modal fade" id="modal-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Products Master Lists</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-8">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search product name or brand name">
                    </div>
                    <div class="col-1">
                        <select wire:model.live="pagination" class="form-control">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-3 d-flex justify-content-center">
                        <div class="btn-group w-100" role="group">
                            <button wire:click="$dispatch('refresh-product-ax')" type="button"
                                class="btn btn-secondary" data-toggle="modal" data-target="#modal-product-ax">
                                <i class="fas fa-plus"></i> AX
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#modal-add-product">
                                <i class="fas fa-plus"></i> Add
                            </button>
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
                    <table class="table table-hover table-sm">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col" style="width: 35px"></th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Supplier Rep.</th>
                            <th scope="col">Principal</th>
                            <th scope="col" style="width: 115px">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>
                                        @if ($product->source === '0')
                                            <span class="badge badge-pill badge-info">
                                                AX
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>{{ $product->supplier_rep }}</td>
                                    <td>{{ $product->principal }}</td>
                                    <td>
                                        <button
                                            wire:click.prevent="$dispatch('select-product',{id:{{ $product->id }}})"
                                            wire:click="$dispatch('refresh-product')" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        @if ($product->source === '1')
                                            <button
                                                wire:click.prevent="$dispatch('edit-product',{id:{{ $product->id }}})"
                                                type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#modal-edit-product">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                wire:click.prevent="deleteProduct({{ $product->id }},{{ "'" . str_replace("'", '', $product->product_name) . "'" }})"
                                                {{-- wire:click.prevent="deleteProduct({{ $product->id }},{{ "'" . $product->product_name . "'" }})" --}} class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @livewire('crm.product.product-edit')

                            {{-- @livewire('crm.product-edit') --}}

                        </tbody>
                    </table>
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
