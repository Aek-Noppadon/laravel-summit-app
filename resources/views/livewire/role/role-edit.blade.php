<div wire:ignore.self class="modal fade" id="modal-edit-role" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Role</h4>
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
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Role Name</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="name" wire:model="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="permissions" class="form-label">Permissions</label>
                                    <span class="text-danger font-weight-bold">*</span>
                                    @error('permissions')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group card">
                                        <div class="card-body py-2">
                                            @foreach ($allPermissions as $item)
                                                <div class="form-check">
                                                    <input wire:model="permissions"
                                                        class="form-check-input @error('permissions') is-invalid @enderror"
                                                        type="checkbox" value="{{ $item->id }}" id="permissions">
                                                    <label class="form-check-label" for="permissions">
                                                        {{ $item->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ./Role Name -->
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
            @this.on('close-modal-role', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    @this.dispatch('refresh-role')
                    $('#modal-edit-role').modal('hide')
                }, 3000);
            })
        })
    </script>
@endscript
