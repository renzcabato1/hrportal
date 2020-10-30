<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
          $table->string('name');
            $table->timestamps();
        });

        Schema::create('employee_location', function(Blueprint $table){
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')
                ->on('employees')->onDelete('cascade');

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')
                ->on('locations')->onDelete('cascade');
                
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
        Schema::dropIfExists('employee_location');
        Schema::dropIfExists('locations');
    }
}
