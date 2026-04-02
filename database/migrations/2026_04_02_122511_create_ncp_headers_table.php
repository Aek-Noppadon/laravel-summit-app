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
        Schema::create('ncp_headers', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('NCP Id');
            $table->string('ncp_number', 12)->unique()->comment('NCP Number');
            $table->string('source_type', 20)->comment('Customer, Vendor');
            $table->unsignedSmallInteger('customer_id')->nullable()->index();
            $table->unsignedTinyInteger('found_activity_id')->nullable()->index();
            $table->unsignedTinyInteger('preventive_action_id')->nullable()->index();

            $table->unsignedTinyInteger('report_user_id')->nullable()->index();
            $table->unsignedTinyInteger('to_user_id')->nullable()->index();
            $table->unsignedTinyInteger('authorize_user_id')->nullable()->index();
            $table->unsignedTinyInteger('execute_user_id')->nullable()->index();
            $table->unsignedTinyInteger('created_user_id')->nullable()->index();
            $table->unsignedTinyInteger('updated_user_id')->nullable()->index();

            $table->text('problem')->nullable()->comment('Problem');
            $table->text('corrective_action')->nullable()->comment('Corrective Action');
            $table->text('result')->nullable()->comment('Resule');

            $table->date('report_date')->nullable();
            $table->date('authorize_date')->nullable(); // เพิ่ม nullable
            $table->date('excute_date')->nullable();    // เพิ่ม nullable

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('found_activity_id')->references('id')->on('found_activities');
            $table->foreign('preventive_action_id')->references('id')->on('preventive_actions');

            // Note: บรรทัดล่างนี้อาจติด Error ถ้า Type ไม่ตรงกับตาราง users ของ CRM
            $table->foreign('report_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');
            $table->foreign('authorize_user_id')->references('id')->on('users');
            $table->foreign('execute_user_id')->references('id')->on('users');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ncp_headers');
    }
};
