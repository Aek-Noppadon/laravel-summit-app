<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>Add Customer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Customer</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- card -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Customer Form</h3>
            </div>
            <!-- /.card-header -->

            <form wire:submit.prevent="save">

                <!-- Customer Header -->
                <div class="card-body">

                    <!-- CRM Header ID, Created Date, Updated Date -->
                    {{-- @isset($crmHeader_id)
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <div class="mb-2 font-weight-bold">CRM ID</div>
                                    <div class="form-control bg-light">
                                        {{ $crmHeader_id }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <div class="mb-2 font-weight-bold">Created</div>
                                    <div class="form-control bg-light">
                                        {{ Carbon\Carbon::parse($crmHeader_created_at)->format('d/m/Y') }},
                                        {{ Carbon\Carbon::parse($crmHeader_created_at)->format('H:i:s') }},
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($crmHeader_created_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <div class="mb-2 font-weight-bold">Updated</div>
                                    <div class="form-control bg-light">
                                        {{ Carbon\Carbon::parse($crmHeader_updated_at)->format('d/m/Y') }},
                                        {{ Carbon\Carbon::parse($crmHeader_updated_at)->format('H:i:s') }},
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($crmHeader_updated_at)->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset --}}
                    <!-- ./CRM Header ID, Created Date, Updated Date -->

                    <!-- Customer Name Eng, Customer Name Thi -->
                    <div class="row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="name_english" class="form-label">Customer Name ENG.</label>
                                <span class="text-danger font-weight-bold">*</span>
                                <input id="name_english" wire:model="name_english" type="text"
                                    class="form-control @error('name_english') is-invalid @enderror">
                                @error('name_english')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 ">
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

                <div class="card-footer">
                    <div class="row">
                        <div class="col-6 offset-3">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>

                </div>
                <!-- ./Customer Header -->
            </form>

        </div>
        <!-- /.card -->

    </div>
</section>

@script
    <!-- Sweet Alert -->
    <script>
        $wire.on("confirm", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete item ?",
                text: `Item id : ${event.id}, Product : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy", {
                        id: event.id,
                        name: event.name,
                    })

                }
            });
        });
    </script>
    <!-- ./Sweet Alert -->
@endscript
