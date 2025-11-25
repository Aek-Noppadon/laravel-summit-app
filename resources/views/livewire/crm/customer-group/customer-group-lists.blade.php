<div wire:ignore.self class="modal fade" id="modal-customer-group" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Customer Group Lists</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-8">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search customer group name">
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
                            <button wire:click="$dispatch('add-customer-group')" type="button" class="btn btn-primary"
                                data-toggle="modal" data-target="#modal-add-customer-group">
                                <i class="fas fa-plus"></i>
                            </button>

                            <!-- Customer Group Add Component -->
                            @livewire('crm.customer-group.customer-group-create')
                            <!-- ./Customer Group Add Component -->

                            <button wire:click="$dispatch('refresh-customer-group')" type="button"
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
                            <th scope="col">Customer Group Name</th>
                            <th scope="col" style="width: 115px">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($customer_groups as $item)
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
                                            wire:click.prevent="$dispatch('edit-customer-group',{id:{{ $item->id }}})"
                                            type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                            data-target="#modal-edit-customer-group">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            wire:click.prevent="deleteCustomerGroup({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }})"
                                            class="btn btn-sm btn-danger">
                                            {{-- wire:click.prevent="deleteCustomerGroup({{ $item->id }},{{ "'" . $item->name . "'" }})"
                                            class="btn btn-sm btn-danger"> --}}
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Customer Group Edit Component -->
                            @livewire('crm.customer-group.customer-group-edit')
                            <!-- ./Customer Group Edit Component -->

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $customer_groups->links() }}
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
        $wire.on("confirm-delete-customer-group", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                text: `Customer group : ${event.name}`,
                // text: `Customer Group Id : ${event.id}, Name : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy-customer-group", {
                        id: event.id,
                        name: event.name,
                    })
                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-customer-group', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    $('#modal-edit-customer-group').modal('hide')
                }, 3000);

            })
        })
    </script>
@endscript
