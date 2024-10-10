<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->foreignId('blogger_id')->constrained('bloggers');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
