<div wire:ignore.self class="modal fade" id="modal-probability" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Probability Lists</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-8">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search probability name">
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
                            <button wire:click="$dispatch('add-probability')" type="button" class="btn btn-primary"
                                data-toggle="modal" data-target="#modal-add-probability">
                                <i class="fas fa-plus"></i>
                            </button>

                            <!-- Probability Add Component -->
                            @livewire('crm.probability.probability-create')
                            <!-- ./Probability Add Component -->

                            <button wire:click="$dispatch('refresh-probability')" type="button"
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
                    <table class="table table-hover table-sm">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Created</th>
                            <th scope="col">updated</th>
                            <th scope="col">ID</th>
                            <th scope="col">Probability Name</th>
                            <th scope="col" style="width: 115px">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($probabilities as $item)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td> {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }},
                                        {{ Carbon\Carbon::parse($item->created_at)->format('H:i:s') }}<br>
                                        <small class="badge badge-light"><i class="far fa-clock"></i>
                                            {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</small>
                                    </td>
                                    <td> {{ Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }},
                                        {{ Carbon\Carbon::parse($item->updated_at)->format('H:i:s') }}<br>
                                        <small class="badge badge-light"><i class="far fa-clock"></i>
                                            {{ Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</small>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <button
                                            wire:click.prevent="$dispatch('edit-probability',{id:{{ $item->id }}})"
                                            type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal-edit-probability">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            wire:click.prevent="deleteConfirm({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }})"
                                            {{-- wire:click.prevent="deleteProbability({{ $item->id }},{{ "'" . $item->name . "'" }})" --}} class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Probability Edit Component -->
                            @livewire('crm.probability.probability-edit')
                            <!-- ./Probability Edit Component -->

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $probabilities->links() }}
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
        $wire.on("confirm-delete-probability", (event) => {

            // alert(event.name);

            Swal.fire({
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
                    $wire.dispatch("destroy-probability", {
                        id: event.id,
                        name: event.name,
                    })
                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-probability', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    $('#modal-edit-probability').modal('hide')
                }, 3000);

            })
        })
    </script>
@endscript
