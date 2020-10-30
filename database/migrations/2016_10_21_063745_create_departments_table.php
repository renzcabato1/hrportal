<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('department_employee', function(Blueprint $table){
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')
                ->on('employees')->onDelete('cascade');

            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')
                ->on('departments')->onDelete('cascade');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_employee');
        Schema::dropIfExists('departments');
    }
}