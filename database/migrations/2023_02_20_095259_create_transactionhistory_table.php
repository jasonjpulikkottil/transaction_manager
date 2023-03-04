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
        Schema::create('transactionhistory', function (Blueprint $table) {
            
            $table->increments('no');
            $table->date('trans_date');
            $table->time('trans_time');
            $table->string('description');
            $table->double('qty');
            $table->string('info');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactionhistory');
    }
};
