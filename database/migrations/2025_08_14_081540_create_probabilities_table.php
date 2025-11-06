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
        Schema::create('probabilities', function (Blueprint $table) {
            $table->tinyIncrements('id')->comment('Probability ID');
            $table->string('name', '50')->nullable()->comment('Probability Name');
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
        Schema::dropIfExists('probabilities');
    }
};
