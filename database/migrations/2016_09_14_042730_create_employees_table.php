<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('employee_number');
            $table->string('company');
            $table->string('department');
            $table->string('level');
            $table->string('location');
            $table->timestamp('date_hired')->nullable();
            $table->timestamp('date_regularized')->nullable();
            $table->timestamp('date_resigned')->nullable();
            $table->text('job_remarks'); // job information remarks
            $table->text('id_remarks'); // identification remarks remarks
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('name_suffix');
            $table->timestamp('birthdate')->nullable();
            $table->string('birthplace');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('position');
            $table->string('classification');
            $table->string('status');
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('phone_number');
            $table->string('mobile_number');
            $table->string('sss_number');
            $table->string('phil_number');
            $table->string('tax_number');
            $table->string('tax_status');
            $table->string('contact_person');
            $table->string('contact_number');
            $table->string('contact_relation');
            $table->string('hdmf');
            $table->string('bank_name');



            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
}
