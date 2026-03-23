<div wire:ignore.self class="modal fade" id="modal-vendor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vendor Master Lists</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-7 col-12">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search vendor code or vendor name">
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

                            <button wire:click="$dispatch('refresh-vendor-ax')" type="button"
                                class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-vendor-ax">
                                <span data-toggle="tooltip" data-placement="bottom" title=""
                                    data-original-title="Add Vendor">
                                    <i class="fas fa-plus"></i> AX
                                </span>
                            </button>

                            <button wire:click="$dispatch('refresh-vendor')" type="button"
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
                            <th scope="col" style="width: 35px"></th>
                            <th scope="col">Id</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 40px" class="text-center">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($vendors as $item)
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
                                    <td class="text-center">
                                        @if ($item->source === '0')
                                            <span class="badge badge-pill badge-primary">
                                                AX
                                            </span>
                                        @elseif ($item->source === '1')
                                            <span class="badge badge-pill badge-info">
                                                Web
                                            </span>
                                        @else
                                            <span class="badge badge-pill badge-success">
                                                Excel
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name_english }}</td>
                                    <td class="p-1 text-center">
                                        <button
                                            wire:click.prevent="$dispatch('select-vendor',
                                            {id:{{ $item->id }}})"
                                            wire:click="$dispatch('refresh-vendor')" class="btn btn-success btn-sm">
                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Select">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    @livewire('vendor.vendor-ax-lists-modal')

                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $vendors->links() }}
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
        $wire.on("confirm-delete-vendor", (event) => {
            Swal.fire({
                title: "Are you sure delete ?",
                text: `Vendor : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy-vendor", {
                        id: event.id,
                        name: event.name,
                    })
                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-vendor', (event) => {
                setTimeout(() => {
                    $('#modal-edit-vendor').modal('hide')
                }, 3000);

            })
        })
    </script>
@endscript
