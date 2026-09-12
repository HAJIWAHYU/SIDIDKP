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
        Schema::table('surats', function (Blueprint $table) {
            $table->string('surat_dari')->nullable();
            $table->date('tanggal_surat')->nullable();
            $table->string('no_agenda')->nullable();
            $table->string('sifat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            $table->dropColumn(['surat_dari', 'tanggal_surat', 'no_agenda', 'sifat']);
        });
    }
};
