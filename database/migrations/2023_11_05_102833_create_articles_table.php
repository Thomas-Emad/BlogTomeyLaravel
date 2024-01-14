<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('articles', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('id_user');
      $table->foreign('id_user')->references("id")->on("users")->onDelete("cascade");
      $table->string("title");
      $table->longText("content");
      $table->string('bgArticle');
      $table->integer("watched")->default(0);
      $table->timestamp("hidden")->nullable();
      $table->enum('comment', ['allow', 'disable'])->default('allow');
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
