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
        Schema::create('crm_details', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('CRM Detail ID');
            $table->unsignedMediumInteger('crm_id')->comment('CRM Header ID');
            // $table->foreign('crm_id')->references('id')->on('crm_headers')->onDelete('cascade')->comment('CRM Header ID');
            $table->foreign('crm_id')->references('id')->on('crm_headers')->cascadeOnDelete()->comment('CRM Header ID');
            $table->unsignedSmallInteger('product_id')->comment('Product ID');
            $table->foreign('product_id')->references('id')->on('products');
            $table->date('update_visit')->comment('Update Visit');
            $table->string('application_id')->nullable()->comment('Application');
            $table->unsignedTinyInteger('sales_state_id')->comment('Sales State');
            $table->unsignedTinyInteger('probability_id')->comment('Probability');
            $table->integer('quantity')->comment('Quantity');
            $table->decimal('unit_price')->comment('Unit Price');
            $table->decimal('total_price')->comment('Total Price');
            $table->unsignedTinyInteger('packing_unit_id')->nullable()->comment('Packing Unit');
            $table->integer('volumn_qty')->nullable()->comment('Volumn Quantity');
            $table->unsignedTinyInteger('volumn_unit_id')->nullable()->comment('Volumn Unit');
            $table->string('additional')->nullable()->comment('Additional');
            $table->string('competitor')->nullable()->comment('Competitor');
            $table->unsignedTinyInteger('created_user_id')->nullable()->comment('Created User');
            $table->unsignedTinyInteger('updated_user_id')->nullable()->comment('Updated User');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm_details');

        Schema::table('crm_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
