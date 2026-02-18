@section('title', 'User')

<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <!-- Add user Modal -->
            <div class="row mb-4">
                <div class="col-3">
                    <select id="department_id" wire:model="department_id"
                        wire:focus.debounce.1000ms="selectedDepartment" wire:model.live.debounce.1000ms="department_id"
                        class="form-control">
                        <option value="">-- Select Department --</option>
                        @foreach ($departments as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <input wire:model.live.debounce.1000ms="search" type="search" class="form-control"
                        placeholder="Search user sales id, fist name, last name">
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
                        <button wire:click="$dispatch('add-user')" type="button" class="btn btn-primary"
                            data-toggle="modal" data-target="#modal-add-user">
                            <i class="fas fa-plus"></i> User
                        </button>
                        <button wire:click="$dispatch('refresh-user')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>

                        @livewire('user.user-create')
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="search,department_id" class="spinner-border text-primary"
                            role="status">
                        </div>
                        <div wire:loading wire:target="pagination" class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Add user Modal -->
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Created</th>
                        <th scope="col">Updated</th>
                        <th colspan="col">Department</th>
                        <th scope="col">Id</th>
                        <th scope="col">Sales ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" style="width: 100px">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>

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
                                <td>{{ $item->department->name }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->sales_id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->last_name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <button wire:click.prevent="$dispatch('edit-user',{id:{{ $item->id }}})"
                                        type="button" class="btn btn-secondary btn-sm" data-toggle="modal"
                                        data-target="#modal-edit-user">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button
                                        wire:click.prevent="deleteUser({{ $item->id }},{{ "'" . str_replace("'", '', $item->name) . "'" }},{{ "'" . str_replace("'", '', $item->last_name) . "'" }})"
                                        class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        @livewire('user.user-edit')

                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <div class="col-12">
                {{ $users->links() }}
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
                text: `User : ${event.name} ${event.last_name}`,
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
