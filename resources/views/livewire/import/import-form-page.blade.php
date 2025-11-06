<div class="card col-10 offset-1 mt-5">
    <div class="card-header">
        <h3>แบบฟอร์มนำเข้าสินค้า</h3>
    </div>

    <div class="card-body">
        {{-- <form> --}}
        <div class="card-title">
            @livewire('import.select-product')
            {{-- <livewire:import.select-product /> --}}
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                Product
            </button>
            {{-- <button wire:click="showProducts" class="btn btn-primary">
                Show Product
            </button> --}}
        </div>

        <table class="table table-bordered">
            <thead>
                <th scope="col">ID</th>
                <th scope="col">ชื่อ</th>
                <th scope="col">จำนวน</th>
                <th scope="col">ราคาต่อหน่วย</th>
                <th scope="col">ยอดรวม</th>
                <th scope="col">ลบ</th>
            </thead>

            <tbody>
                @foreach ($inputs as $key => $item)
                    <tr>
                        <td>{{ $item['product_id'] }}</td>
                        <td>{{ $item['product_name'] }}</td>
                        <td>
                            <input type="number" min="0" name="product_qty[]" class="form-control"
                                wire:model="inputs.{{ $key }}.product_qty"
                                wire:keyup="sumRow({{ $key }})" wire:change="sumRow({{ $key }})">
                        </td>
                        <td>
                            <input type="number" name="product_price[]" class="form-control"
                                wire:model="inputs.{{ $key }}.product_price"
                                wire:keyup="sumRow({{ $key }})" wire:change="sumRow({{ $key }})">
                        </td>
                        <td>
                            <input type="number" name="product_total[]" class="form-control bg-light"
                                wire:model="inputs.{{ $key }}.product_total" readonly>
                        </td>

                        <td>
                            <button wire:click.prevent="deleteRow({{ $key }})"
                                class="btn btn-danger btn-sm">x</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button wire:click="save" class="btn btn-block btn-primary">
            บันทึกข้อมูล
        </button>


        {{-- </form> --}}

    </div>
</div>
