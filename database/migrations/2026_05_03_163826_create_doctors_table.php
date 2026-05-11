<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('doctor_code')->unique(); // DOK-0001
            $table->string('name');
            $table->string('title')->nullable(); // Sp.PD, Sp.JP, dll
            $table->foreignId('specialist_id')->constrained()->onDelete('restrict');
            $table->string('str_number')->nullable(); // Nomor STR
            $table->string('sip_number')->nullable(); // Nomor SIP
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->json('schedule_days')->nullable(); // ["Sen","Sel","Rab"]
            $table->string('schedule_start')->nullable(); // "08:00"
            $table->string('schedule_end')->nullable();   // "14:00"
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->integer('total_reviews')->default(0);
            $table->enum('status', ['online', 'offline', 'cuti'])->default('online');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};