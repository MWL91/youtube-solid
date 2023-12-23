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
        Schema::create('samples', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('name');
            $table->boolean('result')->nullable();
            $table->string('chart_standard_url');
            $table->string('chart_bvs_url');
            $table->bigIncrements('rate_1');
            $table->bigIncrements('rate_2');
            $table->bigIncrements('rate_3');
            $table->bigIncrements('rate_4');
            $table->bigIncrements('rate_5');
            $table->json('data');
            $table->boolean('deep_analitics')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
