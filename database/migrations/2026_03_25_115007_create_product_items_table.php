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
        Schema::create('product_items', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('Product Item Id');
            $table->string('code', 16)->nullable()->unique()->index()->comment('Item Code');
            $table->string('name', 255)->comment('Item Name');
            $table->string('brand_code', 2)->comment('Brand Code');
            $table->string('brand_name', 100)->comment('Brand Name');
            $table->string('group_code', 2)->comment('Group Code');
            $table->string('group_name', 100)->comment('Group Name');
            $table->string('subgroup_code', 2)->comment('SubGroup Code');
            $table->string('subgroup_name', 100)->comment('SubGroup Name');
            $table->string('supplier_rep', 100)->nullable()->comment('Supplier Rep.');
            $table->string('principal_code', 4)->nullable()->comment('Principal Code');
            $table->string('principal_name', 100)->nullable()->comment('Principal Name');
            $table->unsignedTinyInteger('status')->nullable()->comment('0 = Active, 1 = Discontinued by Supplier, 2 = Discontinued by Sales, 3 = Not Active ');
            $table->unsignedTinyInteger('source')->nullable()->comment('0 = AX, 1 = Web, 2 = Excel');
            $table->decimal('unit_price', 12, 2)->nullable()->comment('Unit Price');
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
        Schema::dropIfExists('product_items');
    }
};
