<div wire:ignore.self class="modal fade" id="modal-customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Customers Master List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-8">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search customer code or customer name">
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
                            <button wire:click="$dispatch('refresh-customer-ax')" type="button"
                                class="btn btn-secondary" data-toggle="modal" data-target="#modal-customer-ax">
                                <i class="fas fa-plus"></i> AX
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                data-target="#modal-add-customer">
                                <i class="fas fa-plus"></i> Add
                            </button>
                            <button wire:click="$dispatch('refresh-customer')" type="button" class="btn btn-success">
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
                            <th scope="col" style="width: 35px"></th>
                            <th scope="col">Code</th>
                            <th scope="col">Name English</th>
                            <th scope="col">Name Thai</th>
                            <th scope="col">Parent</th>
                            <th scope="col" style="width: 115px">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>
                                        @if ($customer->source === '0')
                                            <span class="badge badge-pill badge-info">
                                                AX
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $customer->code }}</td>
                                    <td>{{ $customer->name_english }}</td>
                                    <td>{{ $customer->name_thai }}</td>
                                    <td>{{ $customer->parent_code }}</td>
                                    <td>
                                        <button
                                            wire:click.prevent="$dispatch('select-customer',
                                            {id:{{ $customer->id }}})"
                                            wire:click="$dispatch('refresh-customer')" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        @if ($customer->source === '1')
                                            <button
                                                wire:click.prevent="$dispatch('edit-customer',{id:{{ $customer->id }}})"
                                                type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                                data-target="#modal-edit-customer">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button
                                                wire:click.prevent="deleteCustomer({{ $customer->id }},{{ "'" . str_replace("'", '', $customer->name_english) . "'" }})"
                                                {{-- wire:click.prevent="deleteCustomer({{ $customer->id }},{{ "'" . $customer->name_english . "'" }})" --}} class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                            @livewire('crm.customer.customer-edit')

                            {{-- @livewire('crm.customer-edit') --}}

                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <div class="col-12">
                    {{ $customers->links() }}
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
        $wire.on("confirm-delete-customer", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                text: `Customer : ${event.name}`,
                // text: `Customer Id : ${event.id}, Name : ${event.name}`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("destroy-customer", {
                        id: event.id,
                        name: event.name,
                    })
                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-customer', (event) => {
                // alert('Close Modal')
                setTimeout(() => {
                    $('#modal-edit-customer').modal('hide')
                }, 3000);

            })
        })
    </script>
@endscript
