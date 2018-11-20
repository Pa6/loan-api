<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_id')->unsigned()->index();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->integer('loan_id')->unsigned()->index();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->integer('receiver_id')->unsigned()->index();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('payer_id')->unsigned()->index();
            $table->foreign('payer_id')->references('id')->on('users')->onDelete('cascade');
            $table->double('amount', 15, 3)->default(0);
            $table->string('payment_status')->default('pending');
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
        Schema::dropIfExists('loan_payments');
    }
}
