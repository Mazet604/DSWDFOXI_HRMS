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
        Schema::create('pagibiginfo', function (Blueprint $table) {
            $table->increments('pgbg_count');
            $table->string('empid', 7);
            $table->string('pgbg_id', 20);
            $table->decimal('pgbg_amt', 10, 2);
            $table->decimal('pgbg_mem', 10, 2);
            $table->decimal('pgbg_emp', 10, 2);
            $table->timestamps();

            // Define foreign key constraint with onDelete and onUpdate actions
            $table->foreign('empid')
                  ->references('empid')
                  ->on('emp_acc')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagibiginfo');
    }
};
