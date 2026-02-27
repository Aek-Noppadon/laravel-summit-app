<div wire:ignore.self class="modal fade" id="modal-volume-unit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Volume Unit Lists</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-7">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search volume unit name">
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

                            @can('volumeUnit.create')
                                <button wire:click="$dispatch('add-volume-unit')" type="button" class="btn btn-primary"
                                    data-toggle="modal" data-target="#modal-add-volume-unit">
                                    <i class="fas fa-plus"></i>
                                </button>
                            @endcan

                            <button wire:click="$dispatch('refresh-volume-unit')" type="button"
                                class="btn btn-success">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <i class="fas fa-times-circle"></i>
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
                            <th scope="col">Volume Unit Name</th>
                            @can('volumeUnit.edit')
                                <th scope="col" colspan="2">Action</th>
                            @elsecan('volumeUnit.delete')
                                <th scope="col" colspan="2">Action</th>
                            @endcan
                        </thead>

                        <tbody>
                            @foreach ($volume_units as $item)
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
                                    @can('volumeUnit.edit')
                                        <td style="width: 40px" class="p-1 text-center">
                                            <button
                                                wire:click.prevent="$dispatch('edit-volume-unit',{id:{{ $item->id }}})"
                                                type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#modal-edit-volume-unit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    @endcan

                                    @can('volumeUnit.delete')
                                        <td style="width: 40px" class="p-1 text-center">
                                            <button
                                                wire:click.prevent="deleteConfirm({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }})"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach

                            @livewire('crm.volume-unit.volume-unit-edit')

                        </tbody>
                    </table>

                    @livewire('crm.volume-unit.volume-unit-create')

                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $volume_units->links() }}
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
        $wire.on("confirm-delete-volume-unit", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                text: `Volume Unit : ${event.name}`,
                // text: `Volume Unit Id : ${event.id}, Name : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy-volume-unit", {
                        id: event.id,
                        name: event.name,
                    })
                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-volume-unit', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    $('#modal-edit-volume-unit').modal('hide')
                }, 3000);
            })
        })
    </script>
@endscript
