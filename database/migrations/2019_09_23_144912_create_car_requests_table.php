<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('car_requests', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('car_id')->unsigned()->index();
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');

            $table->integer('client_id')->unsigned()->index();
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('owner_id')->unsigned()->index();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('payment_type_id')->unsigned()->index();
            $table->foreign('payment_type_id')->references('id')->on('payment_types')->onDelete('cascade');

            $table->string('from_date_time')->default(time());
            $table->string('to_date_time')->default(time());
            $table->string('status')->default('pending');
            $table->double('initial_payment_amount')->default(0);
            $table->double('total_amount')->default(0);
            $table->string('currency')->default('RWF');
            $table->text('details')->nullable();
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
        Schema::dropIfExists('car_requests');
    }
}
