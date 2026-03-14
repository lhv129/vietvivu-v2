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
        Schema::table('locations', function (Blueprint $table) {
            // drop unique cũ
            $table->dropUnique(['slug']);

            // nếu trước đó name cũng unique thì drop luôn
            $table->dropUnique(['name']);

            // tạo unique mới với deleted_at
            $table->unique(['name', 'deleted_at']);
            $table->unique(['slug', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            //
        });
    }
};
