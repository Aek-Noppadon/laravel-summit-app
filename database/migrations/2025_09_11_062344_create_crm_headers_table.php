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
        Schema::create('crm_headers', function (Blueprint $table) {
            // $table->id()->comment('CRM Header ID');
            // $table->string('idwithformat')->primary()->comment('CRM Header ID');

            $table->mediumIncrements('id')->comment('CRM Header ID');
            // $table->string('customer_code')->comment('Customer Code');
            // $table->string('customer_eng')->comment('Customer Name Eng');
            // $table->string('customer_thi')->comment('Customer Name Thi');
            $table->unsignedSmallInteger('customer_id')->comment('Customer ID');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->date('started_visit_date')->comment('Start Visit Date');
            $table->date('month_estimate_date')->comment('Month Estimate Date');
            $table->date('original_month_estimate_date')->comment('Original Month Estimate Date');
            $table->unsignedTinyInteger('customer_type_id')->comment('Customer Type');
            $table->unsignedTinyInteger('customer_group_id')->nullable()->comment('Customer Group');
            $table->string('contact')->comment('Customer Contact');
            $table->text('purpose')->comment('Purpose');
            $table->text('detail')->nullable()->comment('Detail');
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
        Schema::dropIfExists('crm_headers');

        Schema::table('crm_headers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
