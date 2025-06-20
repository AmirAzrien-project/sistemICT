<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mesyuarat', function (Blueprint $table) {
            $table->id(); // PRIMARY KEY auto_increment

            $table->unsignedBigInteger('permohonan_id')->nullable(); // foreign key (optional)
            $table->string('no_rujukan')->nullable()->index();
            $table->tinyInteger('peringkat_mesyuarat')->nullable();
            $table->string('tajuk', 150)->nullable();
            $table->string('nilai_projek', 100)->nullable();

            $table->enum('keputusan', [
                'Semakan Semula',
                'Disyorkan',
                'Tidak Disyorkan',
                'Lulus'
            ])->nullable();

            $table->dateTime('tarikh_masa')->nullable();
            $table->string('no_sijil')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesyuarat');
    }
};
