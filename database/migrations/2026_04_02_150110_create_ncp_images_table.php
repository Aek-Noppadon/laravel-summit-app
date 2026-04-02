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
        Schema::create('ncp_images', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('NCP Item Id');
            $table->unsignedMediumInteger('ncp_id')->nullable()->index()->comment('NCP Header Id');
            $table->string('name')->nullable()->comment('Image Name');
            $table->unsignedTinyInteger('created_user_id')->nullable()->index();
            $table->unsignedTinyInteger('updated_user_id')->nullable()->index();

            // Foreign Keys
            $table->foreign('ncp_id')->references('id')->on('ncp_headers')->cascadeOnDelete()->comment('NCP Header Id');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ncp_images');
    }
};
