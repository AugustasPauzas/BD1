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
        Schema::create('cart', function (Blueprint $table) {
            
            $table->id();
            $table->integer('category_id_1');
            $table->integer('category_id_2');
            $table->integer('operation');
            $table->integer('parameter_id_1');
            $table->integer('parameter_id_2');
            $table->timestamps();

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
