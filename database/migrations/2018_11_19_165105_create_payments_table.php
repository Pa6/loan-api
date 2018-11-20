<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->double('total_amount', 15,3);
            $table->integer('payer_id')->unsigned()->index();
            $table->foreign('payer_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('receiver_id')->unsigned()->index();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('currency')->default('USD');
            $table->integer('loan_id')->unsigned()->index();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('deadline')->nullable();
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
        Schema::dropIfExists('payments');
    }

}
