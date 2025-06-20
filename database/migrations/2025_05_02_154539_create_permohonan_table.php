<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY, auto_increment
            $table->string('no_rujukan')->unique()->nullable();
            $table->string('id_pekerja', 100)->nullable()->index(); // index = MUL
            $table->string('jabatan', 100)->nullable();
            $table->string('name')->nullable();
            $table->string('notel', 15)->nullable();
            $table->string('skop')->nullable();
            $table->string('tajuk'); // NOT NULL
            $table->string('dokumen1')->nullable();
            $table->string('dokumen2')->nullable();
            $table->string('dokumen3')->nullable();
            $table->string('dokumen4')->nullable();
            $table->string('dokumen5')->nullable();
            $table->text('keterangan')->nullable();

            $table->enum('status_sekretariat', [
                'Menunggu',
                'Lengkap',
                'Tidak Lengkap',
                'Perlu Semakan Semula',
                'Disyorkan',
                'Telah Dikemaskini',
                'Lulus',
                'Tidak Lulus',
                'Selesai'
            ])->default('Menunggu')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};
