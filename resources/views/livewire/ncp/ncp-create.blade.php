@section('title', 'NCP')
<section class="content">

    <div class="container-fluid">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1>NC Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('crm.list') }}">NCP List</a></li>
                            <li class="breadcrumb-item active">NCP</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Form</h3>
            </div>

            <div class="card-body">

                <!-- Customer -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="customerCode" class="form-label">Customer Code</label>
                            <!-- Customer Search -->
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                            <!-- ./Customer Search -->
                            <input type="text" class="form-control" disabled readonly>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="customerNameEng">
                            Customer Name ENG. / ลูกค้า
                            <span class="text-danger text-bold">*</span>
                        </label>
                        <input type="text" class="form-control" disabled readonly>
                    </div>
                    <div class="col-md-5">
                        <label for="customerNameThi">Customer Name THI. / ลูกค้า</label>
                        <input type="text" class="form-control" disabled readonly>
                    </div>
                </div>
                <!-- ./Customer -->

                <!-- Vendor -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="vendorCode" class="form-label">Vendor Code</label>
                            <!-- Customer Search -->
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-search"></i>
                            </button>
                            <!-- ./Customer Search -->
                            <input type="text" class="form-control" disabled readonly>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label for="">
                            Vendor Name ENG. / ผู้จำหน่าย
                            <span class="text-danger text-bold">*</span>
                        </label>
                        <input type="text" class="form-control" disabled readonly>
                    </div>
                    <div class="col-md-5">
                        <label for="vendorNameThai">Vendor Name THI. / ผู้จำหน่าย</label>
                        <input type="text" class="form-control" disabled readonly>
                    </div>
                </div>
                <!-- ./Vendor -->

                <!-- Found during activity -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="foundDuring" class="form-label">Found during activity /ขณะที่พบ : *</label>
                            <select name="" id="foundDuring" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="1">Receiving</option>
                                <option value="2">Picking</option>
                                <option value="3">Other</option>
                                <option value="4">Repacking</option>
                                <option value="5">Keeping</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="problemDescription">
                                Problem Description / ปัญหาที่พบ
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea name="" id="problemDescription" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="problemDescription">
                                Corrective & Preventive Action Detail (CAPA) /
                                รายละเอียดการดำเนินการแก้ไขและป้องกัน
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea name="" id="" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="problemDescription">
                                Result / ผลการดำเนินการ
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea name="" id="" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="problemDescription">
                                Images / รูปถ่ายสินค้าที่มีปัญหา
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea name="" id="" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col-6">
                        <div class="btn-group w-100" role="group">


                            <button wire:click="" type="button" class="btn btn-primary w-100" data-toggle="modal"
                                data-target="#modal-product">
                                <i class="fas fa-search"></i> Products
                            </button>


                        </div>
                    </div>

                    <div class="col-6">
                        <button wire:click.prevent="save" class="btn btn-success w-100">
                            <i class="fas fa-save"></i> Save
                        </button>
                    </div>
                </div>


            </div>
        </div>

    </div>

</section>
