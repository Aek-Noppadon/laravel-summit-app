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
        Schema::create('ncp_items', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('NCP Item Id');
            $table->unsignedMediumInteger('ncp_id')->nullable()->index()->comment('NCP Header Id');
            $table->unsignedMediumInteger('product_id')->comment('Product Id');
            $table->string('to_wh_no', 10)->nullable()->comment('To Warhouse');
            $table->string('batch_no', 20)->nullable()->comment('Batch Number');
            $table->decimal('quantity', 12, 2)->comment('Quantity');
            $table->string('ref_document_no', 30)->nullable()->comment('Reference Document Number');
            $table->string('ref_invoice_no', 30)->nullable()->comment('Reference Invoice Number');
            $table->text('remark')->nullable()->comment('Remark');
            $table->unsignedTinyInteger('created_user_id')->nullable()->index();
            $table->unsignedTinyInteger('updated_user_id')->nullable()->index();
            // Foreign Keys
            $table->foreign('ncp_id')->references('id')->on('ncp_headers')->cascadeOnDelete()->comment('NCP Header Id');
            $table->foreign('product_id')->references('id')->on('product_items');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ncp_items');
    }
};
