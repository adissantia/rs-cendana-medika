<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code')->unique(); // P-001234
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->integer('age');
            $table->date('birth_date')->nullable();
            $table->foreignId('specialist_id')->nullable()->constrained()->onDelete('set null');
            $table->text('address')->nullable();
            $table->date('last_visit')->nullable();
            $table->enum('status', ['aktif', 'rawat_inap', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};