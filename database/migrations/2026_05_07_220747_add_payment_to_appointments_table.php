<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {

            // Tambah status pembayaran (CEK DULU)
            if (!Schema::hasColumn('appointments', 'payment_status')) {
                $table->enum('payment_status', ['belum_bayar', 'dibayar'])
                    ->default('belum_bayar')
                    ->after('status');
            }

        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            if (Schema::hasColumn('appointments', 'payment_status')) {
                $table->dropColumn('payment_status');
            }
        });
    }
};