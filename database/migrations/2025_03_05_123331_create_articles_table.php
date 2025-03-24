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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->string('image');
            $table->string('slug');
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_slider')->default(false);
            $table->boolean('is_banner_right_top')->default(false);
            $table->boolean('is_banner_right_bottom')->default(false);
            $table->enum('status', ['active', 'in-active'])->default('active');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};