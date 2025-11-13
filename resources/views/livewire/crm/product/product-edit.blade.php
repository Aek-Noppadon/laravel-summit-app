<div wire:ignore.self class="modal fade" id="modal-edit-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Product</h4>
                <button wire:click="$dispatch('close-modal')" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>

            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Product Form</h3>
                    </div>
                    {{-- <form wire:submit.prevent="saveProduct"> --}}
                    <form>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="product_name" wire:model="product_name" type="text"
                                            class="form-control @error('product_name') is-invalid @enderror">
                                        @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                            </div>
                            <!-- ./Product Name -->

                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="brand" class="form-label">Product Brand</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="brand" wire:model='brand' type="text"
                                            class="form-control @error('brand') is-invalid @enderror">
                                        @error('brand')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="supplier_rep" class="form-label">Supplier Rep.</label>
                                        <input id="supplier_rep" wire:model='supplier_rep' type="text"
                                            class="form-control @error('supplier_rep') is-invalid @enderror">
                                        {{-- @error('supplier_rep')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror --}}
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="principal" class="form-label">Principal</label>
                                        <input id="principal" wire:model='principal' type="text"
                                            class="form-control @error('principal') is-invalid @enderror">
                                        {{-- @error('principal')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="modal-footer">
                <div class="col-12 d-flex justify-content-end">
                    <div class="btn-group d-flex justify-content-center" role="group">
                        <button wire:click.prevent="save" class="btn btn-success">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <button wire:click="$dispatch('close-modal')" type="button" class="btn btn-warning">
                            <i class="fas fa-times-circle"></i> Close
                        </button>
                    </div>
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
                // alert('Close Modal')
                setTimeout(() => {
                    @this.dispatch('refresh-product')
                    $('#modal-edit-product').modal('hide')
                }, 3000);

            })

            @this.on('close-modal', (event) => {
                // alert()
                $('#modal-edit-product').modal('hide')
            })
        })
    </script>
@endscript
