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
        Schema::table('reservations', function (Blueprint $table) {
            // جعل الحقل 'image' قابلاً للقيم الفارغة
            $table->text('image')->nullable()->change();

            // إضافة 3 حقول جديدة لليوم والتاريخ والسنة
            $table->string('day')->nullable();
            $table->string('date')->nullable();
            $table->string('year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // تغيير الحقل 'image' ليكون غير قابل للقيم الفارغة
            $table->text('image')->nullable(false)->change();

            // إزالة الحقول الجديدة
            $table->dropColumn('day');
            $table->dropColumn('date');
            $table->dropColumn('year');
        });
    }
};
