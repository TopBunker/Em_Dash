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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->char('country_code',2);
            $table->string('zip',20)->nullable();
            $table->timestamps();

            $table->foreign('country_code')->references('code')->on('countries')->cascadeOnUpdate()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
