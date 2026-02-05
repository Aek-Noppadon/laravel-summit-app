<div wire:ignore.self class="modal fade" id="modal-edit-application" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Application</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Form</h3>
                    </div>
                    <form>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Application Name</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="name" wire:model="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- ./Application Name -->
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
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
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
            @this.on('close-modal-application', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    @this.dispatch('refresh-application')
                    $('#modal-edit-application').modal('hide')
                }, 3000);
            })
        })
    </script>
@endscript
