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
        Schema::create('edu_details', function (Blueprint $table) {
            $table->unsignedBigInteger('education_id')->primary();
            $table->text('detail');
            $table->timestamps();
            $table->foreign('education_id')->references('id')->on('educations')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edu_details');
    }
};
