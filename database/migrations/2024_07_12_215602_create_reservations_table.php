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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();  // ID
            $table->datetime('reserved_datetime');  // 予約日時
            $table->integer('number_of_people');  // 予約人数
            $table->foreignId('restaurant_id')->constrained()->cascadeOnDelete();  // 店舗のID
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();  // 会員のID
            $table->timestamps();  // 作成日時と更新日時
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
