<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*        
	        Field SCC_DISCONTINUEDSTATUS = Status
	        0 = Active
	        1 = Discontinued by Supplier
	        2 = Discontinued by Sales
	        3 = Not Active

            Field source
            0 = AX
            1 = Add to Master
        */
        Schema::create('products', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('ID');
            $table->string('code', 10)->nullable()->comment('Code');
            $table->string('product_name')->nullable()->comment('Product Name');
            $table->string('brand', 100)->nullable()->comment('Brand');
            $table->string('supplier_rep', 100)->nullable()->comment('Supplier Rep.');
            $table->string('principal', 100)->nullable()->comment('Principal');
            $table->enum('status', ['0', '1', '2', '3', '4'])->nullable()->comment('Status 0 = Active, 1 = Discontinued by Supplier, 2 = Discontinued by Sales, 3 = Not Active ');
            $table->enum('source', ['0', '1'])->nullable()->comment('Data Source 0 = AX, 1 = Master');
            $table->unsignedTinyInteger('created_user_id')->nullable()->comment('Created User');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('updated_user_id')->nullable()->comment('Updated User');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
