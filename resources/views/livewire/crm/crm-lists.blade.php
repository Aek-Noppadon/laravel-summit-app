<section class="content">

    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>CRM Lists</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">CRM</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>

    <!-- card -->
    <div class="card">
        <div class="card-header">
            <a href="{{ route('crm.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add CRM
            </a>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 165px">Created</th>
                        <th scope="col" style="width: 165px">updated</th>
                        <th style="width: 5%" scope="col">ID</th>
                        <th scope="col" style="width: 135px">Customer Code</th>
                        <th scope="col">Customer Name Eng.</th>
                        {{-- <th scope="col">Customer Name Thi.</th> --}}
                        <th scope="col" style="width: 135px">Start Visit</th>
                        <th scope="col" style="width: 135px">Month Estimate</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Items</th>
                        <th style="width: 8%" scope="col">Action</th>
                    </thead>

                    <tbody>
                        @foreach ($crms as $item)
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
                                <td>{{ $item->customer->code }}</td>
                                <td>{{ $item->customer->name_english }}</td>
                                {{-- <td>{{ $item->customer_thi }}</td> --}}
                                <td>
                                    {{ Carbon\Carbon::parse($item->started_visit_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($item->month_estimate_date)->format('d/m/Y') }}
                                </td>
                                <td>{{ $item->contact }}</td>
                                <td>
                                    <h5>
                                        <span class="badge badge-dark">{{ $item->crm_items_count }}</span>
                                    </h5>
                                </td>
                                <td>
                                    <a href="{{ route('crm.update', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button
                                        wire:click.prevent="deleteCrm({{ $item->id }},{{ "'" . $item->name_english . "'" }})"
                                        class="btn btn-sm btn-danger">
                                        {{-- wire:confirm="Are you sure want to delete item" class="btn btn-sm btn-danger"> --}}
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <table class="table table-sm">
                                        <thead class="thead-dark">
                                            <th scope="col">#</th>
                                            <th scope="col">Id</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Brand</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->crm_items as $item)
                                                <tr>
                                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                                    <td>{{ $item->product_id }}</td>
                                                    <td>{{ $item->product->product_name }}</td>
                                                    <td>{{ $item->product->brand }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            {{-- @foreach ($item->crm_items as $item)
                                <tr>
                                    <td>{{ $item->product_id }}</td>
                                    <td>{{ $item->product->product_name }}</td>
                                    <td>{{ $item->product->brand }}</td>
                                </tr>
                            @endforeach --}}
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>

@script
    <script>
        $wire.on("confirm", (event) => {

            // alert(event.name);

            Swal.fire({
                title: "Are you sure delete ?",
                text: `CRM Id : ${event.id}, Customer : ${event.name}`,
                // text: `ID : ${event.id}, Customer : ${event.name}`,
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
