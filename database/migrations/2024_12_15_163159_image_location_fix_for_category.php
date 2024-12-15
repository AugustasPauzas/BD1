<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('category', function (Blueprint $table) {
            // Check if 'status' column doesn't exist before adding it
            if (!Schema::hasColumn('category', 'status')) {
                $table->integer('status')->default(1); // Set default value for status
            }

            // Check if 'image_location' column doesn't exist before adding it
            if (!Schema::hasColumn('category', 'image_location')) {
                $table->string('image_location')->nullable(); // Make image_location nullable
            }
        });
    }

    public function down(): void
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('status'); 
            $table->dropColumn('image_location'); 
        });
    }
};
