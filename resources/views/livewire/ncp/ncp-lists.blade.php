@section('title', 'NCP')

<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>NCP Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">NCP Lists</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">

        <div class="card-header">
            <div class="row mb-3">
                <div class="offset-7"></div>
                <div class="col-2">
                    <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="btn-group w-100" role="group">

                        {{-- @can('ncp.create') --}}
                        <a href="{{ route('ncp.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add NCP
                        </a>
                        {{-- @endcan --}}

                        <button wire:click="$dispatch('refresh-ncp')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button wire:click="toggleSearch(true)" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- /.card -->
</section>

@script
    <script>
        $wire.on("confirm", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                html: `${event.document_no}<br>${event.name_english}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy", {
                        id: event.id,
                        document_no: event.document_no,
                        name_english: event.name_english,
                    })

                }
            });
        });
    </script>
@endscript
