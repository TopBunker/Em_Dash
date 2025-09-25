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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->ulid('user_id')->unique();
            $table->string('tel')->nullable();
            $table->string('title');
            $table->text('summary');
            $table->string('status')->default('draft');
            $table->boolean('hasPort')->default(false);
            $table->boolean('hasRef')->default(false);
            $table->boolean('hasImage')->default(false);
            $table->string('file_location')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
