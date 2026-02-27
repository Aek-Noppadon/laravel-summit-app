<div wire:ignore.self class="modal fade" id="modal-product-ax" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Products AX Lists</h4>
                <button wire:click="$dispatch('close-modal')" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-9">
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
                    <div class="col-1 d-flex justify-content-center">
                        <div class="btn-group d-flex justify-content-center" role="group">
                            <button wire:click="$dispatch('refresh-product-ax')" type="button" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button wire:click="$dispatch('close-modal')" type="button" class="btn btn-warning">
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
                            <th scope="col">Code</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Supplier Rep.</th>
                            <th scope="col">Principal</th>
                            @can('product.create')
                                <th scope="col" class="text-center">Action</th>
                            @endcan
                        </thead>

                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $product->ProductCode }}</td>
                                    <td>{{ $product->ProductName }}</td>
                                    <td>{{ $product->ProductBrand }}</td>
                                    <td>{{ $product->SupplierRep }}</td>
                                    <td>{{ $product->Principal }}</td>
                                    @can('product.create')
                                        <td style="width: 40px" class="p-1 text-center">
                                            <button
                                                wire:click.prevent="$dispatch('save-product-ax'
                                            ,{product_code:{{ "'" . $product->ProductCode . "'" }}
                                            ,product_name:{{ "'" . $product->ProductName . "'" }}
                                            ,product_brand:{{ "'" . $product->ProductBrand . "'" }}
                                            ,supplier_rep:{{ "'" . $product->SupplierRep . "'" }}
                                            ,principal:{{ "'" . $product->Principal . "'" }}
                                            })"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-save"></i>
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
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-product', (event) => {
                setTimeout(() => {
                    @this.dispatch('refresh-product')
                    $('#modal-product-ax').modal('hide')
                }, 3000);
            })

            @this.on('close-modal', (event) => {
                $('#modal-product-ax').modal('hide')
            })
        })
    </script>
@endscript
