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
            $table->foreign('crm_id')->references('id')->on('crm_headers')->cascadeOnDelete()->comment('CRM Header ID');
            $table->unsignedSmallInteger('product_id')->comment('Product ID');
            $table->foreign('product_id')->references('id')->on('products');
            $table->date('update_visit')->comment('Update Visit');
            $table->unsignedTinyInteger('application_id')->nullable()->comment('Application');
            $table->foreign('application_id')->references('id')->on('applications');
            $table->unsignedTinyInteger('sales_stage_id')->comment('Sales Stages');
            $table->foreign('sales_stage_id')->references('id')->on('sales_stages');
            $table->unsignedTinyInteger('probability_id')->comment('Probability');
            $table->foreign('probability_id')->references('id')->on('probabilities');
            $table->integer('quantity')->comment('Quantity');
            $table->decimal('unit_price')->comment('Unit Price');
            $table->decimal('total_price')->comment('Total Price');
            $table->unsignedTinyInteger('packing_unit_id')->nullable()->comment('Packing Unit');
            $table->foreign('packing_unit_id')->references('id')->on('packing_units');
            $table->integer('volume_qty')->nullable()->comment('Volume Quantity');
            $table->unsignedTinyInteger('volume_unit_id')->nullable()->comment('Volume Unit');
            $table->foreign('volume_unit_id')->references('id')->on('volume_units');
            $table->string('additional')->nullable()->comment('Additional');
            $table->string('competitor')->nullable()->comment('Competitor');
            $table->unsignedTinyInteger('created_user_id')->nullable()->comment('Created User');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('updated_user_id')->nullable()->comment('Updated User');
            $table->foreign('updated_user_id')->references('id')->on('users');
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

        // Schema::table('crm_details', function (Blueprint $table) {
        //     $table->dropSoftDeletes();
        // });
    }
};
