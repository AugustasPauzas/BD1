<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('translation', function (Blueprint $table) {
            $table->text('original_text')->change();  
            $table->text('translated_text')->change();  
        });
    }

    public function down()
    {
        Schema::table('translation', function (Blueprint $table) {
            $table->string('original_text', 255)->change();  
            $table->string('translated_text', 255)->change();  
        });
    }
};
