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
        Schema::create('found_activities', function (Blueprint $table) {
            $table->tinyIncrements('id')->comment('Found Id');
            $table->string('name')->comment('Found Activity Name');
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
        Schema::dropIfExists('found_activities');
    }
};
