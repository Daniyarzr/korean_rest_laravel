<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // в новой миграции
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Переименуем address в delivery_address для согласованности
            $table->renameColumn('address', 'delivery_address');
            
            // Добавим недостающие поля
            $table->string('customer_name')->after('user_id');
            $table->string('payment_method')->after('total')->default('cash');
            $table->text('notes')->nullable()->after('payment_method');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('delivery_address', 'address');
            $table->dropColumn(['customer_name', 'payment_method', 'notes']);
        });
    }
};
