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
            $table->mediumIncrements('id')->comment('CRM Header ID');
            $table->string('document_no', '12')->comment('Document Number');
            $table->unsignedSmallInteger('customer_id')->comment('Customer ID');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->date('started_visit_date')->comment('Start Visit Date');
            $table->date('estimate_date')->comment('Estimate Date');
            $table->date('original_estimate_date')->comment('Original Estimate Date');
            $table->unsignedTinyInteger('customer_type_id')->comment('Customer Type');
            $table->foreign('customer_type_id')->references('id')->on('customer_types');
            $table->unsignedTinyInteger('customer_group_id')->nullable()->comment('Customer Group');
            $table->foreign('customer_group_id')->references('id')->on('customer_groups');
            $table->unsignedTinyInteger('event_id')->nullable()->comment('Event');
            $table->foreign('event_id')->references('id')->on('events');
            $table->string('contact')->comment('Customer Contact');
            $table->text('purpose')->comment('Purpose');
            $table->text('detail')->nullable()->comment('Detail');
            $table->text('opportunity')->nullable()->comment('Opportunity');
            $table->unsignedTinyInteger('source')->nullable()->comment('0 = Excel, NULL = Web');
            $table->unsignedTinyInteger('created_user_id')->nullable()->comment('Created User');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('updated_user_id')->nullable()->comment('Updated User');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->unsignedTinyInteger('original_user_id')->nullable()->comment('Original User');
            $table->foreign('original_user_id')->references('id')->on('users');
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
