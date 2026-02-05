<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Probability Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Probabilities</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <!-- Add Probability Modal -->
            <div class="row mb-4">
                <div class="col-7">
                    <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                        placeholder="Search Probability">
                </div>
                <div class="col-2">
                    <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-3 d-flex justify-content-center">
                    <div class="btn-group w-100" role="group">
                        <button wire:click="$dispatch('add-probability')" type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#modal-add-probability">
                            <i class="fas fa-plus"></i> Probability
                        </button>
                        <button wire:click="$dispatch('refresh-probability')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>

                        @livewire('probability.probability-create')
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
            <!-- ./Add Probability Modal -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col">Probability Name</th>
                        <th scope="col" style="width: 100px">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($probabilities as $item)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>
                                    <div>
                                        <small class="badge badge-light">{{ $item->userCreated->name }}</small>
                                    </div>
                                    <div>
                                        <small class="badge badge-light">
                                            {{ $item->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <div>
                                        <small class="badge badge-light">
                                            <i class="far fa-clock"></i>
                                            {{ $item->created_at->format('H:i') }},
                                            {{ $item->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                </td>
                                <td>
                                    <div>
                                        <small class="badge badge-light">{{ $item->userUpdated->name }}</small>
                                    </div>
                                    <div>
                                        <small class="badge badge-light">
                                            {{ $item->updated_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <div>
                                        <small class="badge badge-light">
                                            <i class="far fa-clock"></i>
                                            {{ $item->updated_at->format('H:i') }},
                                            {{ $item->updated_at->diffForHumans() }}
                                        </small>
                                    </div>

                                </td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <button wire:click.prevent="$dispatch('edit-probability',{id:{{ $item->id }}})"
                                        type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                        data-target="#modal-edit-probability">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        wire:click.prevent="deleteProbability({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }})"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        @livewire('probability.probability-edit')
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <div class="col-12">
                {{ $probabilities->links() }}
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
                text: `Probability : ${event.name}`,
                // text: `Probability Id : ${event.id}, Name : ${event.name}`,
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
