<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('surname');
            $table->string('patronymic');
            $table->string('sex')->nullable();
            $table->integer('wage');
        });

        Schema::create('departments_employees', function (Blueprint $table) {
            $table->foreignId('department_id')->constrained();
            $table->foreignId('employees_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('departments_employees');
    }
}
