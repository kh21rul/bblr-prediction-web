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
        Schema::create('dataujis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('umur');
            $table->string('lila');
            $table->string('tinggi');
            $table->boolean('bblr_nb')->default(false);
            $table->boolean('bblr_c45')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataujis');
    }
};
