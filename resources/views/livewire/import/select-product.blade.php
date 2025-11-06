<div wire:ignore.self class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายการสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table class="table">
                    <thead>
                        <th scope="col">ID</th>
                        <th scope="col">ชื่อ</th>
                        <th scope="col">หน่วย</th>
                        <th scope="col">ราคา</th>
                        <th scope="col">#</th>
                    </thead>

                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->prod_name }}</td>
                                <td>{{ $product->prod_unit }}</td>
                                <td>{{ $product->prod_price }}</td>
                                <td>
                                    <button wire:click.prevent="$dispatch('selected-product',{id:{{ $product->id }}})"
                                        class="btn btn-success btn-sm">Select</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
