<!-- Modal -->
<div>
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">รายการสินค้า</h1>
                </div>
                <div class="modal-body">

                    <input type="text" class="form-control" placeholder="Search...">
                    <button wire:click="showProducts" class="btn btn-primary">Show Product</button>
                    <table class="table table-hover">
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
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>{{ $product->prod_name }}</td>
                                    <td>{{ $product->prod_unit }}</td>
                                    <td>{{ $product->prod_price }}</td>
                                    <td>
                                        {{-- ส่งค่าไป Component select-product --}}
                                        {{-- <button wire:click="selectedProduct({{ $product->id }})" class="btn btn-primary">
                                        Selected
                                    </button> --}}
                                        <button type="button"
                                            @click="$dispatch('selected-product',{id:{{ $product->id }}})"
                                            class="btn btn-primary">
                                            Selected
                                        </button>
                                        <button type="button"
                                            wire:click.prevent="$dispatch('selected-product',{id:{{ $product->id }}})"
                                            class="btn btn-primary">
                                            Selected
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
