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
    Schema::create('report_articles', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger("id_article");
      $table->foreign("id_article")->references('id')->on('articles')->onDelete("cascade");
      $table->unsignedBigInteger("id_user_report");
      $table->foreign("id_user_report")->references('id')->on('users')->onDelete("cascade");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('report_articles');
  }
};
