<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->


    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form</h3>
        </div>

        <form>
            <div class="card-body">

                <!-- First Name, Last Name -->
                <div class="row">
                    <div class="col-6">
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
                    <div class="col-6">
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
                <!-- ./First Name, Last Name -->

                <!-- Email, Sales Id, Department -->
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <span class="text-danger font-weight-bold">*</span>
                            <input id="email" wire:model='email' type="text"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="sales_id" class="form-label">Sales Id</label>
                            <span class="text-danger font-weight-bold">*</span>
                            <input id="sales_id" wire:model='sales_id' type="number"
                                class="form-control @error('sales_id') is-invalid @enderror">
                            @error('sales_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="department_id" class="form-label">Department</label>
                            <span class="text-danger font-weight-bold">*</span>

                            <div wire:loading wire:target="selectedDepartment" class="spinner-border text-primary"
                                style="width: 1.2rem;height:1.2rem" role="status">
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
                <!-- ./Email, Sales Id, Department -->
            </div>
        </form>

    </div>

    <div class="modal-footer">
        <div class="col-12 d-flex justify-content-end">
            <div class="btn-group d-flex justify-content-center" role="group">
                <button wire:click.prevent="save" class="btn btn-success">
                    <i class="fas fa-save"></i> Save
                </button>

            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
