<div wire:ignore.self class="modal fade" id="modal-add-user" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Form</h3>
                    </div>
                    {{-- <form wire:submit.prevent="saveUser"> --}}
                    <form>
                        <div class="card-body">

                            {{-- First Name, Last Name --}}
                            <div class="row">
                                {{-- First Name --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">First Name</label>
                                        <span class="text-danger font-weight-bold">*</span>

                                        <input id="name" wire:model="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Last Name --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="last_name" wire:model="last_name" type="text"
                                            class="form-control @error('last_name') is-invalid @enderror">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- ./First Name, Last Name --}}

                            {{-- Email, Sales Id, Department --}}
                            <div class="row">
                                {{-- Email --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="email" wire:model="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Rep.Code --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sales_id" class="form-label">Sales Id</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="sales_id" wire:model="sales_id" type="number"
                                            class="form-control @error('sales_id') is-invalid @enderror">
                                        @error('sales_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="department_id" class="form-label">Department</label>
                                        <span class="text-danger font-weight-bold">*</span>

                                        <div wire:loading wire:target="selectedDepartment"
                                            class="spinner-border text-primary" style="width: 1.2rem;height:1.2rem"
                                            role="status">
                                        </div>

                                        <select id="department_id" wire:model="department_id"
                                            wire:focus.debounce.1000ms="selectedDepartment"
                                            class="form-control @error('department_id') is-invalid @enderror">
                                            <option value="">-- Select --</option>
                                            @foreach ($departments as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- ./Email, Sales Id, Department --}}

                            {{-- Password, Comfirm Password --}}
                            <div class="row">
                                {{-- Password --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="password" wire:model="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                {{-- Confirm Password --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="confirm_password" class="form-label">Confirm Password</label>
                                        <span class="text-danger font-weight-bold">*</span>
                                        <input id="confirm_password" wire:model="confirm_password" type="password"
                                            class="form-control @error('confirm_password') is-invalid @enderror">
                                        @error('confirm_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ./Password, Comfirm Password --}}

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
            @this.on('close-modal-user', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    @this.dispatch('refresh-user')
                    @this.dispatch('reset-modal')
                    $('#modal-add-user').modal('hide')
                }, 3000);
            })
        })
    </script>
@endscript
