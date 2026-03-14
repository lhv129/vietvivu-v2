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
        Schema::create('room_type_price_rules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_type_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('type', [
                'weekend',
                'holiday',
                'promotion',
                'override'
            ]);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->integer('amount');

            $table->enum('amount_type', [
                'fixed',
                'percent'
            ])->default('fixed');

            $table->json('days_of_week')->nullable();

            $table->boolean('is_active')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_type_price_rules');
    }
};
