<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

//['name', 'details', 'car_type_id', 'owner_id', 'status', 'manufacturer_year', 'price', 'currency'];

    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('details')->nullable();
            $table->integer('car_type_id')->unsigned()->index();
            $table->foreign('car_type_id')->references('id')->on('car_types')->onDelete('cascade');
            $table->integer('owner_id')->unsigned()->index();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('manufacturer_year')->nullable();
            $table->double('price', 15,2)->default(0);
            $table->string('currency')->default('RWF');
            $table->integer('approval_id')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('cars');
    }
}
