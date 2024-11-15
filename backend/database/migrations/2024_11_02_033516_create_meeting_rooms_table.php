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
        Schema::create('meeting_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('localizacao');
            $table->integer('capacidade');
            $table->json('recursos')->nullable();
            $table->boolean('ativo')->default(true);
            $table->text('descricao')->nullable();
            $table->json('disponibilidade')->default(json_encode([
                ['inicio' => '08:00', 'fim' => '09:00'],
                ['inicio' => '09:00', 'fim' => '10:00'],
                ['inicio' => '10:00', 'fim' => '11:00'],
                ['inicio' => '11:00', 'fim' => '12:00'],
                ['inicio' => '13:00', 'fim' => '14:00'],
                ['inicio' => '14:00', 'fim' => '15:00'],
                ['inicio' => '15:00', 'fim' => '16:00'],
                ['inicio' => '16:00', 'fim' => '17:00']
            ]));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_rooms');
    }
};
