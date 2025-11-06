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
        Schema::create('applications', function (Blueprint $table) {
            $table->tinyIncrements('id')->comment('Application ID');
            $table->string('name', 50)->comment('Application Name');
            $table->unsignedTinyInteger('created_user_id')->nullable()->comment('Created User');
            $table->unsignedTinyInteger('updated_user_id')->nullable()->comment('Updated User');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
