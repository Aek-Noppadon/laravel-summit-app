<div wire:ignore.self class="modal fade" id="modal-customer-ax" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Customer AX Lists</h4>

                <button wire:click="$dispatch('close-modal')" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">

                <div class="row mb-4">
                    <div class="col-md-7 col-12">
                        <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                            placeholder="Search customer code or customer name">
                    </div>
                    <div class="col-md-3 col-12">
                        <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-12 d-flex justify-content-center">
                        <div class="btn-group w-100" role="group">

                            <button wire:click="$dispatch('refresh-customer-ax')" type="button"
                                class="btn btn-success btn-sm">
                                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Refresh">
                                    <i class="fas fa-sync-alt"></i>
                                </span>
                            </button>

                            <button wire:click="$dispatch('close-modal')" type="button" class="btn btn-warning btn-sm">
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
                    <table class="table table-hover table-sm table-bordered">
                        <thead class="table-info">
                            <th scope="col">#</th>
                            <th scope="col">Code</th>
                            <th scope="col">Customer Name Eng.</th>
                            <th scope="col">Customer Name Thi.</th>
                            <th scope="col">Parent</th>
                            <th scope="col" class="text-center">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $customer->CustomerCode }}</td>
                                    <td>{{ $customer->CustomerNameEng }}</td>
                                    <td>{{ $customer->CustomerNameThi }}</td>
                                    <td>{{ $customer->ParentCode }}</td>
                                    <td style="width: 40px" class="p-1 text-center">
                                        <button
                                            wire:click.prevent="$dispatch('save-customer-ax',
                                            {id:{{ "'" . $customer->CustomerCode . "'" }}})"
                                            class="btn btn-success btn-sm">
                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Save">
                                                <i class="fas fa-save"></i>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
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
        document.addEventListener('livewire:initialized', () => {
            @this.on('close-modal-customer', (event) => {
                setTimeout(() => {
                    @this.dispatch('refresh-customer')
                    $('#modal-customer-ax').modal('hide')
                }, 3000);
            })

            @this.on('close-modal', (event) => {
                $('#modal-customer-ax').modal('hide')
            })
        })
    </script>
@endscript
