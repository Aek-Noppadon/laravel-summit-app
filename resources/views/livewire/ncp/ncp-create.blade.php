@section('title', 'NCP')

@push('styles')
    <style>
        /* Container หุ้มรูปและปุ่ม */
        .image-preview-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            height: 300px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
            margin-bottom: 10px;
        }

        /* ตัวรูปภาพ Preview */
        .image-preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* 👈 ตัวนี้อาจทำให้ภาพดูมัวถ้าสัดส่วนรูปต่างจากกรอบมาก */
            display: block;
            image-rendering: -webkit-optimize-contrast;
            /* 👈 เพิ่มบรรทัดนี้เพื่อช่วยให้ Browser เรนเดอร์ภาพคมขึ้น */
        }

        /* ปุ่มลบสีแดง (ทรงกลม) */
        .btn-remove-image {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 26px;
            height: 26px;
            padding: 0;
            border-radius: 50%;
            border: 2px solid #fff;
            background-color: #dc3545;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
            line-height: 1;
        }

        .btn-remove-image:hover {
            background-color: #bd2130;
            transform: scale(1.1);
            color: white;
        }

        /* Overlay ตอนกำลังลบ */
        .image-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }
    </style>
@endpush

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

        {{-- <form> --}}

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add Form</h3>
            </div>

            <div class="card-body">

                <!-- Customer -->
                <div class="row">
                    <div class="col-md-2 col-12">
                        <div class="form-group">
                            <div class="icheck-primary d-inline mr-3">
                                <input wire:model.live="sourceType" type="radio" id="customer" name="source_type"
                                    value="customer" checked>
                                <label for="customer">Customer</label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input wire:model.live="sourceType" type="radio" id="vendor" name="source_type"
                                    value="vendor">
                                <label for="vendor">Vendor</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label">
                                Customer Code
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <div class="input-group">
                                <input wire:model="customerCode" type="text"
                                    class="form-control @error('customerCode') is-invalid @enderror" disabled readonly>

                                <div class="input-group-append">
                                    <!-- Customer Search -->
                                    @if ($sourceType == 'customer')
                                        <button wire:click="$dispatch('refresh-customer')"
                                            class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#modal-customer">
                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Search">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </button>
                                    @elseif ($sourceType == 'vendor')
                                        <!-- Vendor Search -->
                                        <button wire:click="$dispatch('refresh-vendor')" class="btn btn-primary btn-sm"
                                            data-toggle="modal" data-target="#modal-vendor">

                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Search">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </button>
                                        <!-- ./Vendor Search -->
                                    @endif
                                    <!-- ./Customer Search -->
                                </div>
                            </div>

                            @error('customerCode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Customer Name ENG. / ลูกค้า
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <input wire:model="customerNameEng" type="text"
                                class="form-control @error('customerNameEng') is-invalid @enderror" disabled readonly>

                            @error('customerNameEng')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Customer Name THI. / ลูกค้า</label>
                            <input wire:model="customerNameThi" type="text" class="form-control" disabled readonly>
                        </div>
                    </div>
                </div>
                <!-- ./Customer -->

                <!-- Found during activity -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Found During Activity / ขณะที่พบ
                                <span class="text-danger text-bold">*</span>
                            </label>
                            <div class="input-group">
                                <input wire:model="foundActivityName" type="text"
                                    class="form-control @error('foundActivityName') is-invalid @enderror" disabled
                                    readonly>
                                <div class="input-group-append">
                                    <!-- Add Found During Activity -->
                                    <button wire:click="$dispatch('refresh-found-activity')" type="button"
                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#found-activity-modal">

                                        <span data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Search">
                                            <i class="fas fa-search"></i>
                                        </span>

                                    </button>
                                    <!-- ./Add Found During Activity -->
                                </div>
                            </div>

                            @error('foundActivityName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">
                                Problem Description / ปัญหาที่พบ
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea wire:model="problemDescription" class="form-control @error('problemDescription') is-invalid @enderror"
                                cols="30" rows="5"></textarea>

                            @error('problemDescription')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- ./Found during activity -->

                <!-- Corrective Action (CA) -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Preventive Action (PA) / การดำเนินการป้องกัน</label>
                            <div class="input-group">
                                <input wire:model="preventiveActionName" type="text"
                                    class="form-control @error('preventiveActionName') is-invalid @enderror" disabled
                                    readonly>
                                <div class="input-group-append">
                                    <!-- Preventive Action (PA) -->
                                    <button wire:click="$dispatch('refresh-preventive-action')" type="button"
                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#preventive-action-modal">

                                        <span data-toggle="tooltip" data-placement="bottom"
                                            data-original-title="Search">
                                            <i class="fas fa-search"></i>
                                        </span>

                                    </button>
                                    <!-- ./Preventive Action (PA) -->
                                </div>
                            </div>

                            @error('preventiveActionName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">
                                Corrective Action (CA) / การดำเนินการแก้ไข
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea wire:model="correctiveActionName" class="form-control @error('correctiveActionName') is-invalid @enderror"
                                cols="30" rows="5"></textarea>

                            @error('correctiveActionName')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- ./Corrective Action (CA) -->

                <!-- Result -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">
                                Result / ผลการดำเนินการ
                                <span class="text-danger text-blod">*</span>
                            </label>
                            <textarea wire:model="result" class="form-control @error('result') is-invalid @enderror" cols="30"
                                rows="5"></textarea>

                            @error('result')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <!-- ./Result -->

                <!-- Search Product Items -->
                <div class="row mb-3">
                    <div class="col-md-4 col-12 offset-4">
                        <div class="btn-group w-100" role="group">

                            <button wire:click="$dispatch('refresh-product')" type="button"
                                class="btn btn-primary w-100" data-toggle="modal" data-target="#modal-product">
                                <span data-toggle="tooltip" data-placement="bottom" data-original-title="Search">
                                    <i class="fas fa-search"></i> Products
                                </span>
                            </button>

                        </div>
                    </div>
                </div>
                <!-- ./Search Product Items -->

                <!-- Product Items -->
                @foreach ($inputs as $key => $item)
                    <div class="card card-primary card-outline">

                        <div class="card-header">
                            <h3 class="card-title">Item {{ $key + 1 }}</h3>
                        </div>

                        @php
                            $productName = $item['productName'];
                        @endphp

                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Product Id
                                        </label>
                                        <input id="inputs.{{ $key }}.productId"
                                            wire:model="inputs.{{ $key }}.productId" type="text"
                                            class="form-control" disabled readonly>
                                    </div>
                                </div> --}}

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label">Product Code</label>
                                        <span class="text-danger text-bold">*</span>

                                        <input id="inputs.{{ $key }}.productCode"
                                            wire:model="inputs.{{ $key }}.productCode" type="text"
                                            class="form-control @error('inputs.' . $key . '.productCode') is-invalid @enderror">

                                        @error('inputs.' . $key . '.productCode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="form-label">Product Name</label>
                                        <span class="text-danger text-bold">*</span>

                                        <input id="inputs.{{ $key }}.productName"
                                            wire:model="inputs.{{ $key }}.productName" type="text"
                                            class="form-control @error('inputs.' . $key . '.productName') is-invalid @enderror">

                                        @error('inputs.' . $key . '.productName')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Brand</label>
                                        <input id="inputs.{{ $key }}.productBrand"
                                            wire:model="inputs.{{ $key }}.productBrand" type="text"
                                            class="form-control" disabled readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>To WH</label>
                                        <span class="text-danger text-bold">*</span>

                                        <select id="inputs.{{ $key }}.whNo" class="form-control">
                                            <option selected value="13">13</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Batch Number</label>
                                        <span class="text-danger text-bold">*</span>

                                        <input id="inputs.{{ $key }}.batchNo"
                                            wire:model="inputs.{{ $key }}.batchNo" type="text"
                                            class="form-control @error('inputs.' . $key . '.batchNo') is-invalid @enderror">

                                        @error('inputs.' . $key . '.batchNo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <span class="text-danger text-bold">*</span>

                                        <input x-number.2 id="inputs.{{ $key }}.quantity"
                                            wire:model="inputs.{{ $key }}.quantity" type="text"
                                            class="form-control @error('inputs.' . $key . '.quantity') is-invalid @enderror">

                                        @error('inputs.' . $key . '.quantity')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ref.Invoice No.(SO)</label>
                                        <span class="text-danger text-bold">*</span>

                                        <input id="inputs.{{ $key }}.refInvoiceNo"
                                            wire:model="inputs.{{ $key }}.refInvoiceNo" type="text"
                                            class="form-control @error('inputs.' . $key . '.refInvoiceNo') is-invalid @enderror">

                                        @error('inputs.' . $key . '.refInvoiceNo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <span class="text-danger text-bold">*</span>

                                        <textarea wire:model="inputs.{{ $key }}.remark" id="inputs.{{ $key }}.remark"
                                            class="form-control @error('inputs.' . $key . '.remark') is-invalid @enderror" cols="30" rows="5"></textarea>

                                        @error('inputs.' . $key . '.remark')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <!-- Search Product Items -->
                            <div class="row">
                                <div class="col-md-4 offset-2">
                                    <div class="btn-group w-100" role="group">

                                        <button wire:click="$dispatch('refresh-product')" type="button"
                                            class="btn btn-primary w-100" data-toggle="modal"
                                            data-target="#modal-product">
                                            <span data-toggle="tooltip" data-placement="bottom"
                                                data-original-title="Search">
                                                <i class="fas fa-search"></i> Products
                                            </span>
                                        </button>

                                    </div>
                                </div>

                                <div class="col-md-4" offset-2>
                                    <button
                                        wire:click.prevent="removeItem({{ $key }},{{ "'" . str_replace("'", '', $productName) . "'" }})"
                                        class="btn btn-info w-100">
                                        <i class="fas fa-minus"></i> Remove Item
                                    </button>
                                </div>

                            </div>
                            <!-- ./Search Product Items -->
                        </div>

                    </div>
                @endforeach
                <!-- ./Product Items -->
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="imageInput">Upload Images / อัปโหลดรูป (สูงสุด 6 รูป)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input wire:ignore type="file" class="custom-file-input" id="imageInput" multiple
                                accept="image/*">
                            <label class="custom-file-label" for="imageInput">Choose file</label>
                        </div>
                    </div>
                    <span class="text-muted">รูปภาพจะถูกปรับขนาดอัตโนมัติก่อนแสดงผล</span>
                </div>

                <div class="row g-2 mb-3" id="previewContainer">
                    @foreach ($imagePreviews as $index => $preview)
                        <div class="col-4" wire:key="preview-{{ $index }}">
                            <div class="image-preview-wrapper">
                                <img src="{{ $preview }}" class="image-preview-img">

                                <button type="button" wire:click="removePreview({{ $index }})"
                                    class="btn-remove-image" title="ลบรูปภาพนี้">
                                    &times;
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('images')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div class="col-md-4 offset-4">
                    <button wire:click.prevent="save" wire:loading.attr='disabled' class="btn btn-success w-100">

                        <span data-toggle="tooltip" data-placement="bottom" data-original-title="Save">
                            <i class="fas fa-save"></i> Submit
                        </span>
                    </button>
                </div>
            </div>
        </div>

        {{-- </form> --}}

        @livewire('customer.customer-lists-modal')
        @livewire('vendor.vendor-lists-modal')
        @livewire('found-activity.lists-modal')
        @livewire('preventive-action.lists-modal')
        @livewire('product-item.lists-modal')
        {{-- @livewire('crm.product.product-lists') --}}

    </div>

    {{-- @once
        ใช้แบบนี้ก็ได้ถ้าไม่ @push ด้านบน
        <style>
            /* Container หุ้มรูปและปุ่ม */
            .image-preview-wrapper {
                position: relative;
                overflow: hidden;
                border-radius: 8px;
                height: 120px;
                border: 1px solid #dee2e6;
                background-color: #f8f9fa;
                margin-bottom: 10px;
            }

            /* ตัวรูปภาพ Preview */
            .image-preview-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            /* ปุ่มลบสีแดง (ทรงกลม) */
            .btn-remove-image {
                position: absolute;
                top: 6px;
                right: 6px;
                width: 26px;
                height: 26px;
                padding: 0;
                border-radius: 50%;
                border: 2px solid #fff;
                background-color: #dc3545;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                font-weight: bold;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                cursor: pointer;
                transition: all 0.2s;
                z-index: 10;
                line-height: 1;
            }

            .btn-remove-image:hover {
                background-color: #bd2130;
                transform: scale(1.1);
                color: white;
            }

            /* Overlay ตอนกำลังลบ */
            .image-loading-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.7);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 5;
            }
        </style>
    @endonce --}}

</section>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {

            // --- ส่วนที่ 1: จัดการ Modal Close Events ---
            const modals = [{
                    event: 'close-modal-customer-list',
                    id: '#modal-customer'
                },
                {
                    event: 'close-modal-vendor-list',
                    id: '#modal-vendor'
                },
                {
                    event: 'close-found-activity-modal',
                    id: '#found-activity-modal'
                },
                {
                    event: 'close-preventive-action-modal',
                    id: '#preventive-action-modal'
                }
            ];

            modals.forEach(m => {
                @this.on(m.event, () => {
                    setTimeout(() => {
                        $(m.id).modal('hide');
                    }, 1000);
                });
            });

            // --- ส่วนที่ 2: จัดการ Image Input (ย้ายมาไว้ข้างในนี้ได้เลย) ---
            const imageInput = document.getElementById('imageInput');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    const maxFiles = 6;
                    const maxWidth = 800; // ความกว้างสูงสุดที่ต้องการย่อ (pixels)

                    if (files.length > maxFiles) {
                        // 1. เรียกใช้ Method ในฝั่ง PHP เพื่อให้พ่น Toastr
                        @this.call('showMaxFileError', maxFiles);

                        // 2. ล้างค่า input
                        this.value = '';
                        return;
                    }

                    // วนลูปจัดการทีละไฟล์
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];

                        if (!file.type.startsWith('image/')) continue; // ข้ามถ้าไม่ใช่รูปภาพ

                        const reader = new FileReader();

                        reader.onload = function(event) {
                            const img = new Image();
                            img.src = event.target.result;

                            img.onload = function() {
                                // คำนวณขนาดใหม่โดยรักษา Aspect Ratio
                                let width = img.width;
                                let height = img.height;

                                if (width > maxWidth) {
                                    height = Math.round((height * maxWidth) / width);
                                    width = maxWidth;
                                }

                                // ใช้ Canvas ในการย่อขนาด
                                const canvas = document.createElement('canvas');
                                canvas.width = width;
                                canvas.height = height;
                                const ctx = canvas.getContext('2d');

                                // ⭐ เพิ่มบรรทัดนี้: กำหนดคุณภาพการ smoothing เป็น 'high'
                                // ค่าที่ตั้งได้คือ 'low' (เร็วสุด), 'medium', 'high' (คมชัดสุด)
                                ctx.imageSmoothingQuality = 'high';
                                ctx.imageSmoothingEnabled = true; // มั่นใจว่าเปิดใช้งาน smoothing

                                ctx.drawImage(img, 0, 0, width, height);

                                // แปลง Canvas เป็น Base64 String (JPEG เพื่อลดขนาดไฟล์)
                                const dataUrl = canvas.toDataURL('image/jpeg',
                                    0.85); // quality 0.85,0.9

                                // ส่งข้อมูล Base64 กลับไปให้ Livewire
                                @this.call('addPreview', dataUrl);
                            };
                        };

                        reader.readAsDataURL(file); // อ่านไฟล์เป็น Data URL (Base64)
                    }

                    // ล้างค่า input เพื่อให้เลือกไฟล์เดิมซ้ำได้ถ้าต้องการ
                    this.value = '';
                });
            }
        });
    </script>
@endpush
