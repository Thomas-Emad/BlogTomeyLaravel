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
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->string('email')->unique();
      $table->string('password');
      $table->string('info')->nullable()->default("Hi, I\'m a new editor here and I\'m looking forward to sharing my knowledge and joining this amazing community.");
      $table->string('img')->nullable();
      $table->enum('type', ['male', 'female'])->default("male");
      $table->enum('status', ['open', 'block'])->default("open");
      $table->integer('reports')->default(0);
      $table->date('email_verified_at')->nullable();
      $table->date('last_login')->nullable();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
