<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_me', function (Blueprint $table) {
            $table->id();
            $table->text('bio_id');
            $table->text('bio_en');
            $table->string('photo_path')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('job_title_id')->default('Fullstack Developer');
            $table->string('job_title_en')->default('Fullstack Developer');
            $table->json('highlights')->nullable(); // key facts array
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_me');
    }
};
