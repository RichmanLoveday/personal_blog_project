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
        Schema::table('adverts', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->enum('status', ['active', 'in-active'])
                ->default('active')
                ->change();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adverts', function (Blueprint $table) {
            $table->string('image');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'in-active'])
                ->default(null)
                ->change();
        });
    }
};
