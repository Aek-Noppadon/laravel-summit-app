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
        Schema::create('customers', function (Blueprint $table) {
            $table->smallIncrements('id')->comment('ID');
            $table->string('code', 8)->nullable()->comment('Code');
            $table->string('name_english')->comment('Name English');
            $table->string('name_thai')->nullable()->comment('Name Thai');
            $table->string('parent_code', 8)->nullable()->comment('Parent Code');
            $table->string('parent_name')->nullable()->comment('Parent Name');
            $table->unsignedTinyInteger('source')->nullable()->comment('0 = AX, 1 = Web');
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
        Schema::dropIfExists('customers');
    }
};
