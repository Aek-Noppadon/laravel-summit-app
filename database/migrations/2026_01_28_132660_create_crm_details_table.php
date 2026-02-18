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
            // $table->foreignId('crm_id')->constrained('crm_headers')->cascadeOnDelete();
            $table->unsignedMediumInteger('crm_id')->comment('CRM Header ID');
            $table->foreign('crm_id')->references('id')->on('crm_headers')->cascadeOnDelete()->comment('CRM Header ID');
            $table->unsignedSmallInteger('product_id')->comment('Product ID');
            $table->foreign('product_id')->references('id')->on('products');
            $table->date('updated_visit_date')->comment('Updated Visit');
            $table->unsignedTinyInteger('application_id')->nullable()->comment('Application');
            $table->foreign('application_id')->references('id')->on('applications');
            $table->unsignedTinyInteger('sales_stage_id')->comment('Sales Stages');
            $table->foreign('sales_stage_id')->references('id')->on('sales_stages');
            $table->unsignedTinyInteger('probability_id')->comment('Probability');
            $table->foreign('probability_id')->references('id')->on('probabilities');
            $table->decimal('quantity')->comment('Quantity');
            $table->decimal('unit_price')->comment('Unit Price');
            $table->decimal('total_price', 12, 2)->comment('Total Price');
            $table->unsignedTinyInteger('packing_unit_id')->nullable()->comment('Packing Unit');
            $table->foreign('packing_unit_id')->references('id')->on('packing_units');
            $table->integer('volume_qty')->nullable()->comment('Volume Quantity');
            $table->unsignedTinyInteger('volume_unit_id')->nullable()->comment('Volume Unit');
            $table->foreign('volume_unit_id')->references('id')->on('volume_units');
            $table->text('additional')->nullable()->comment('Additional');
            $table->text('competitor')->nullable()->comment('Competitor');
            $table->unsignedTinyInteger('source')->nullable()->comment('0 = Excel, NULL = Web');
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

        Schema::table('crm_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
