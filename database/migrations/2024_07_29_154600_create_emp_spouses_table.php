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
        Schema::create('emp_spouse', function (Blueprint $table) {
            $table->increments('spouse_count');
            $table->unsignedInteger('emp_count');
            $table->string('spouse_fname', 35);
            $table->string('spouse_mname', 35)->nullable();
            $table->string('spouse_lname', 35);
            $table->string('spouse_xname', 10)->nullable();
            $table->string('spouse_occup', 35);
            $table->string('spouse_office', 35);
            $table->string('spouse_busadd', 150);
            $table->string('spouse_tel', 15);
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('emp_count')
                  ->references('emp_count')
                  ->on('employees')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_spouse');
    }
};
