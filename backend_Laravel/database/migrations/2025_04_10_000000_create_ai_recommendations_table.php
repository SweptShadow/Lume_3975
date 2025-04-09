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
        Schema::create('ai_recommendations', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->timestamps();
        });
<<<<<<< HEAD
=======

        Schema::table('ai_recommendations', function (Blueprint $table) {
            // Add content column if it doesn't exist
            if (!Schema::hasColumn('ai_recommendations', 'content')) {
                $table->text('content')->nullable();
            }
        });
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_recommendations');
<<<<<<< HEAD
=======

        Schema::table('ai_recommendations', function (Blueprint $table) {
            $table->dropColumn('content');
        });
>>>>>>> 8fb13458bb23f9a684115ac14e856cd8f0cf39b3
    }
};