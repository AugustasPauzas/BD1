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
        Schema::create('order', function (Blueprint $table) {
            
            $table->id();
            $table->string('group');
            $table->integer('status');
            $table->integer('user_id');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('deliver_country');
            $table->string('deliver_postcode');
            $table->string('deliver_city');
            $table->string('deliver_address');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->double('price');
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
