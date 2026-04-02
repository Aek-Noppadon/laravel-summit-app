@section('title', 'User Online')

<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Online</h1>
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
            <div class="row mb-4 d-flex justify-content-end">
                <div class="col-2">
                    <select wire:model.live.debounce.1000ms="pagination" class="form-control">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-3">
                    <div class="btn-group w-100" role="group">

                        <button wire:click="$dispatch('refresh-data')" type="button" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>

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
            <div class="table-responsive table-bordered">
                <table class="table table-sm table-hover">
                    <thead class="table-info">
                        <th scope="col">#</th>
                        <th colspan="col">Department</th>
                        <th scope="col">Id</th>
                        <th scope="col">Sales ID</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Status</th>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $user->department->name }}</td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->sales_id }}</td>
                                <td>{{ $user->name }} {{ $user->last_name }}</td>
                                <td>
                                    @if ($user->roles)
                                        @foreach ($user->roles as $role)
                                            <span class="badge badge-light">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-success badge-pill">Online</span>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            {{--
        </div> --}}
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
