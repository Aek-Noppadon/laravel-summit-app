@section('title', 'Event')

<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Event Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Events</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <!-- Add Event Modal -->
            <div class="row mb-4">
                <div class="col-7">
                    <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                        placeholder="Search event">
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

                        @can('event.create')
                            <button wire:click="$dispatch('add-event')" type="button" class="btn btn-primary"
                                data-toggle="modal" data-target="#modal-add-event">
                                <i class="fas fa-plus"></i> Event
                            </button>
                        @endcan

                        <button wire:click="$dispatch('refresh-event')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
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
            <!-- ./Add event Modal -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-bordered">
                    <thead class="table-info">
                        <th scope="col">#</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th scope="col">Id</th>
                        <th scope="col">Event Name</th>

                        @can('event.edit')
                            <th scope="col" colspan="2">Action</th>
                        @elsecan('event.delete')
                            <th scope="col" colspan="2">Action</th>
                        @endcan

                    </thead>

                    <tbody>
                        @foreach ($events as $item)
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
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>

                                @can('event.edit')
                                    <td style="width: 45px" class="p-1 text-center">
                                        <button wire:click.prevent="$dispatch('edit-event',{id:{{ $item->id }}})"
                                            type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal-edit-event">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                @endcan

                                @can('event.delete')
                                    <td style="width: 45px" class="p-1 text-center">
                                        <button
                                            wire:click.prevent="deleteEvent({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }})"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @livewire('event.event-create')

                @livewire('event.event-edit')

            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <div class="col-12">
                {{ $events->links() }}
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
                text: `Event : ${event.name}`,
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
