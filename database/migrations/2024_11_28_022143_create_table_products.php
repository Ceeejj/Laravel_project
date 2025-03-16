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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_image')->nullable();
            $table->string('product_name')->unique();
            $table->text('task_description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // If you want to associate comments with users
            $table->text('comment');
            $table->date('task_date')->nullable();
            $table->tinyInteger('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('category_id')
                   ->references('category_id')
                   ->on('categories')
                   ->onDelete('set null')
                   ->onUpdate('cascade');  
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
