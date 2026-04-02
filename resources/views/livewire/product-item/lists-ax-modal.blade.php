<div wire:ignore.self class="modal fade" id="modal-product-ax" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Product Items AX</h4>
                <button wire:click="$dispatch('close-modal')" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-7">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search item code, name and brand name">
                    </div>
                    <div class="col-3">
                        <select wire:model.live="pagination" class="form-control">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <div class="btn-group d-flex justify-content-center w-100" role="group">

                            <button wire:click="$dispatch('refresh-data')" type="button" class="btn btn-success w-100">
                                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh">
                                    <i class="fas fa-sync-alt"></i>
                                </span>
                            </button>

                            <button wire:click="$dispatch('close-modal')" type="button" class="btn btn-warning w-100">
                                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Close">
                                    <i class="fas fa-times-circle"></i>
                                </span>
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
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Supplier Rep.</th>
                            <th scope="col">Principal</th>
                            @can('product.create')
                                <th scope="col" class="text-center">Action</th>
                            @endcan
                        </thead>

                        <tbody>
                            @foreach ($productItems as $product)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $product->ITEMID }}</td>
                                    <td>{{ $product->ITEMNAME }}</td>
                                    <td>{{ $product->BRANDDESC }}</td>
                                    <td>{{ $product->SCC_SUPPLIERSALESREPNAME }}</td>
                                    <td>{{ $product->PRINCIPALNAME }}</td>
                                    @can('product.create')
                                        <td style="width: 40px" class="p-1 text-center">
                                            {{-- <button wire:click.prevent="$dispatch('save-product-ax')" --}}
                                            <button
                                                wire:click.prevent="$dispatch('save-product-ax',{item_code:{{ "'" . $product->ITEMID . "'" }}
                                            })"
                                                class="btn btn-success btn-sm">
                                                <span data-toggle="tooltip" data-placement="bottom"
                                                    data-original-title="Save">
                                                    <i class="fas fa-save"></i>
                                                </span>
                                            </button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $productItems->links() }}
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
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-product', (event) => {
                setTimeout(() => {
                    @this.dispatch('refresh-data')
                    $('#modal-product-ax').modal('hide')
                }, 3000);
            })

            @this.on('close-modal', (event) => {
                $('#modal-product-ax').modal('hide')
            })
        })
    </script>
@endscript
