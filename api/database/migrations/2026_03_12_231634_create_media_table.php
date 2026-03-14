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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            $table->morphs('mediable'); // mediable_id + mediable_type

            $table->enum('type', ['image', 'video', 'voice'])->default('image')->index();
            $table->string('path');
            

            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(1);

            $table->json('meta')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
