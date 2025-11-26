<div wire:ignore.self class="modal fade" id="modal-edit-customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Customer</h4>
                <button wire:click="$dispatch('close-modal')" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Customer Form</h3>
                    </div>
                    {{-- <form wire:submit.prevent="saveCustomer"> --}}
                    <form>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name_english" class="form-label">Customer Name ENG.</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="name_english" wire:model="name_english" type="text"
                                            class="form-control @error('name_english') is-invalid @enderror">
                                        @error('name_english')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name_thai" class="form-label">Customer Name THI.</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="name_thai" wire:model='name_thai' type="text"
                                            class="form-control @error('name_thai') is-invalid @enderror">
                                        @error('name_thai')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!-- ./Customer Name Eng, Customer Name Thi -->
                        </div>
                    </form>

                </div>
            </div>

            <div class="modal-footer">
                <div class="col-12 d-flex justify-content-end">
                    <div class="btn-group" role="group">
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
            @this.on('close-modal-customer', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    @this.dispatch('refresh-customer')
                    $('#modal-edit-customer').modal('hide')
                }, 3000);

            })

            @this.on('close-modal', (event) => {
                // alert()
                $('#modal-edit-customer').modal('hide')
            })
        })
    </script>
@endscript
