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
        Schema::create('car_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('car_user', function (Blueprint $table) {
        $table->dropForeign(['user_id', 'car_id']);
      });
      Schema::dropIfExists('car_user');
    }
};
