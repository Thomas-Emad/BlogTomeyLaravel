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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_user");
            $table->foreign("id_user")->references("id")->on('users')->onDelete("cascade");
            $table->unsignedBigInteger("id_article");
            $table->foreign("id_article")->references("id")->on('articles')->onDelete("cascade");
            $table->enum('action', [0, 1]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
