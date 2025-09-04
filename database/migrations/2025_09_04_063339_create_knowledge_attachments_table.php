<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('knowledge_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('knowledge_articles')->onDelete('cascade');
            $table->string('original_name');
            $table->string('path');
            $table->integer('size');
            $table->string('mime_type');
            $table->enum('type', ['pdf', 'image', 'document', 'other'])->default('other');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_attachments');
    }
};
