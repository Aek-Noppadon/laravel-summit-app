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
            $table->string('name_english', 150)->comment('Name English');
            $table->string('name_thai', 150)->nullable()->comment('Name Thai');
            $table->string('parent_code', 8)->nullable()->comment('Parent Code');
            $table->string('parent_name', 150)->nullable()->comment('Parent Name');
            $table->enum('source', ['0', '1'])->nullable()->comment('Data Source 0 = AX, 1 = Master');
            $table->string('created_user_id')->nullable()->comment('Created User');
            $table->string('updated_user_id')->nullable()->comment('Updated User');
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
