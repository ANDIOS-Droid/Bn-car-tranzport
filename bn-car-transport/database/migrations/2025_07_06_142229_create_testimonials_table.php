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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('message');
            $table->integer('rating')->default(5); // 1-5 star rating
            $table->string('service_used')->nullable(); // Which service they used
            $table->string('image')->nullable(); // Customer photo
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->date('service_date')->nullable(); // When they used the service
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
