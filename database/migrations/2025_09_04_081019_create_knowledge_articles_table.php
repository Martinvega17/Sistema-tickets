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
        Schema::create('knowledge_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->foreignId('category_id')->constrained('knowledge_categories')->onDelete('cascade');

            $table->string('author')->nullable(); // aquí
            $table->integer('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            $table->index('category_id');
            $table->index('user_id');
            $table->index('views');
            $table->index('rating');
        });

        Schema::table('knowledge_categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_articles');
    }
};
