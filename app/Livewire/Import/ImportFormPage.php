<?php

namespace App\Livewire\Import;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ImportFormPage extends Component
{
    public $inputs = [];
    public $checkProduct = [];
    public $total = 0;

    protected $rules = [
        'supplier_id' => 'required',
        'impo_process' => 'required'
    ];

    protected $messages = [
        'supplier_id.required' => 'กรุณาเลือกผู้ผลิต',
        'impo_process.required' => 'กรุณาเลือกสถานะ'
    ];

    public function save()
    {
        if (count($this->inputs)) {
            dd('Save');
            // try {

            //     DB::beginTransaction();

            //     DB::table('import_product_items')->where('import_id', $import->id)->delete();
            //     foreach ($this->inputs as $value) {
            //         $item = ImportProductItem::create([
            //             'import_id' => $import->id,
            //             'product_id' => $value['product_id'],
            //             'ipi_name' => $value['ipi_name'],
            //             'ipi_qty' => $value['ipi_qty'],
            //             'ipi_unit' => $value['ipi_unit'],
            //             'ipi_price' => $value['ipi_price'],
            //             'ipi_total' => $value['ipi_total'],
            //         ]);
            //     }
            // } catch (\Exception $e) {
            //     DB::rollBack();
            //     return $e;
            // }
        } else {
            dd('Unsave');
        }

        // dd(count($this->inputs));
    }

    #[On('selected-product')]
    public function selectedProduct($id)
    {
        // dd('ImportFormPage: ' . $id);

        $product = Product::findOrFail($id);

        if (!empty($this->checkProduct) && in_array($product->id, $this->checkProduct)) {
            return;
        }


        $this->inputs[] = [
            'product_id' => $product->id,
            'product_name' => $product->prod_name,
            'product_qty' => 0,
            'product_price' => $product->prod_price,
            'product_total' => 0 * $product->prod_price,
        ];

        array_push($this->checkProduct, $product->id);
    }

    public function sumRow($index)
    {
        $this->inputs[$index]['product_total'] = $this->inputs[$index]['product_qty'] * $this->inputs[$index]['product_price'];
        // $this->sumTotal();
    }


    public function deleteRow($index)
    {
        unset($this->inputs[$index]);
    }

    public function render()
    {
        return view('livewire.import.import-form-page');
    }
}
