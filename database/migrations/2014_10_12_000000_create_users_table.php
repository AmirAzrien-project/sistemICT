<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 

            $table->integer('type')->nullable(); 

            $table->string('id_pekerja', 100)->unique()->nullable(); 
            $table->string('jawatan', 100)->nullable();              
            $table->string('jabatan', 100)->nullable();              

            $table->string('name');                                  
            $table->string('notel', 15)->nullable();                 
            $table->string('email')->unique();                       

            $table->timestamp('email_verified_at')->nullable();      
            $table->string('password');                               

            $table->rememberToken();                                  
            $table->timestamps();                                     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
