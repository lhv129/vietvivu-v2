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
        Schema::table('users', function (Blueprint $table) {
            // đổi name -> first_name
            $table->renameColumn('name', 'first_name');

            // thêm các cột mới
            $table->string('last_name')->after('first_name');
            $table->string('display_name')->after('last_name');

            $table->string('job_name')->nullable()->after('display_name');

            $table->enum('gender', ['Nam', 'Nữ', 'Khác'])
                ->nullable()
                ->after('job_name');

            $table->string('avatar')->nullable()->after('email');
            $table->string('bgImage')->nullable()->after('avatar');

            $table->integer('count')->default(0)->after('bgImage');

            $table->text('description')->nullable()->after('count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
