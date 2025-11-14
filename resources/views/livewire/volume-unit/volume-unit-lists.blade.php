<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Volume Unit Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Volume Units</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <!-- Add Volume Unit Modal -->
            <div class="row mb-4">
                <div class="col-8">
                    <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                        placeholder="Search Volume Unit">
                </div>
                <div class="col-1">
                    <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="btn-group w-100" role="group">
                        <button wire:click="$dispatch('add-volume-unit')" type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#modal-add-volume-unit">
                            <i class="fas fa-plus"></i> Volume Unit
                        </button>
                        <button wire:click="$dispatch('refresh-volume-unit')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>

                        @livewire('volume-unit.volume-unit-create')
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="search" class="spinner-border text-primary" role="status">
                        </div>
                        <div wire:loading wire:target="pagination" class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Add Volume Unit Modal -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Created</th>
                        <th scope="col">updated</th>
                        <th scope="col">ID</th>
                        <th scope="col">Volume Unit Name</th>
                        <th scope="col">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($volume_units as $item)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td> {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                        , {{ $item->userCreated->name }}
                                    </small>
                                </td>
                                <td> {{ Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }},
                                    {{ Carbon\Carbon::parse($item->updated_at)->format('H:i:s') }}<br>
                                    <small class="badge badge-light">
                                        <i class="far fa-clock"></i>
                                        {{ Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
                                        , {{ $item->userUpdated->name }}
                                    </small>
                                </td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <button wire:click.prevent="$dispatch('edit-volume-unit',{id:{{ $item->id }}})"
                                        type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                        data-target="#modal-edit-volume-unit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        wire:click.prevent="deleteConfirm({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }})"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        @livewire('volume-unit.volume-unit-edit')
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <div class="col-12">
                {{ $volume_units->links() }}
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
                position: "center",
                title: "Are you sure delete ?",
                text: `Volume Unit : ${event.name}`,
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
@endscript
