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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('author');
            $table->foreignId('book_type_id')->nullable()->references('id')->on('book_types');
            $table->foreignId('book_status_id')->nullable()->references('id')->on('book_statuses');
            $table->unsignedInteger('total_duration')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('planning_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('rating', 2, 1)->nullable();
            $table->text('review')->nullable();
            $table->unsignedTinyInteger('avg_emoji')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('books');

        Schema::enableForeignKeyConstraints();
    }
};
