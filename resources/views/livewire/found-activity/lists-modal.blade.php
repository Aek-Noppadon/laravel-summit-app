<div wire:ignore.self class="modal fade" id="found-activity-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Found During Activity Lists</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-7 col-12">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search found during activity">
                    </div>
                    <div class="col-md-2 col-12">
                        <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-12 d-flex justify-content-center">
                        <div class="btn-group w-100" role="group">

                            {{-- @can('foundActivity.create-modal') --}}
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#found-activity-add-modal">

                                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Add">
                                    <i class="fas fa-plus"></i>
                                </span>

                            </button>
                            {{-- @endcan --}}

                            <button wire:click="$dispatch('refresh-found-activity')" type="button"
                                class="btn btn-success btn-sm">

                                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh">
                                    <i class="fas fa-sync-alt"></i>
                                </span>

                            </button>

                            <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">

                                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Close">
                                    <i class="fas fa-times-circle"></i>
                                </span>

                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            <div wire:loading wire:target="search" class="spinner-border text-primary" role="status">
                            </div>
                            <div wire:loading wire:target="pagination" class="spinner-border text-primary"
                                role="status">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="table-info">
                            <th scope="col">#</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Id</th>
                            <th scope="col">Found During Activity Name</th>
                            <th scope="col" colspan="3" class="text-center">Action</th>
                            {{-- @can('foundActivity.edit-modal')
                                <th scope="col" colspan="2">Action</th>
                            @elsecan('foundActivity.delete')
                                <th scope="col" colspan="2">Action</th>
                            @endcan --}}
                        </thead>

                        <tbody>
                            @foreach ($foundActivities as $item)
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
                                    <td style="width: 40px" class="p-1 text-center">
                                        <button
                                            wire:click.prevent="$dispatch('select-found-activity',{id:{{ $item->id }}})"
                                            class="btn btn-success btn-sm">

                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Select">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </button>
                                    </td>
                                    {{-- @can('foundActivity.edit-modal') --}}
                                    <td style="width: 40px" class="p-1 text-center">
                                        <button
                                            wire:click.prevent="$dispatch('edit-found-activity',{id:{{ $item->id }}})"
                                            type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#found-activity-add-modal">

                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </button>
                                    </td>
                                    {{-- @endcan --}}

                                    {{-- @can('foundActivity.delete') --}}
                                    <td style="width: 40px" class="p-1 text-center">
                                        <button
                                            wire:click.prevent="deleteConfirm({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }})"
                                            class="btn btn-sm btn-danger">

                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </td>
                                    {{-- @endcan --}}
                                </tr>
                            @endforeach

                            {{-- @livewire('found-activity.edit-modal') --}}

                        </tbody>
                    </table>

                    @livewire('found-activity.create-modal')

                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $foundActivities->links() }}
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
        $wire.on("confirm", (event) => {
            Swal.fire({
                title: "Are you sure delete ?",
                text: `Found During Activity : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroyFoundActivity", {
                        id: event.id,
                        name: event.name,
                    })
                }
            });
        });
    </script>
@endscript
