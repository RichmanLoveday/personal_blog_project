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
        Schema::create('advert_placements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advert_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string('page');
            $table->string('position');
            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_placements');
    }
};
