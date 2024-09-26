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
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('user_id');
            $table->string('status');
            $table->string('name');            
            $table->string('description');
            $table->double('price');
            $table->string('ien_code');
            $table->integer('quantity');

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};