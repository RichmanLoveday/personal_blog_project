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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable()->default(Null);
            $table->string('facebook_link')->nullable()->default(Null);
            $table->string('youtube_link')->nullable()->default(Null);
            $table->string('twitter_link')->nullable()->default(Null);
            $table->string('email_link')->nullable()->default(Null);
            $table->text('our_mission')->nullable()->default(Null);
            $table->text('our_vission')->nullable()->default(Null);
            $table->text('our_best_services')->nullable()->default(Null);
            $table->text('address')->nullable()->default(Null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
