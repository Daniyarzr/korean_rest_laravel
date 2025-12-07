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
            // Добавляем поле phone после email
            $table->string('phone')
                  ->nullable()          // Может быть пустым
                  ->after('email');     // Размещаем после поля email
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // При откате миграции удаляем поле
            $table->dropColumn('phone');
        });
    }
};
