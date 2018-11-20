<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->default(mt_rand(0, 999999) . mt_rand(0, 999999));
            $table->string('name');
            $table->text('description');
            $table->double('requested_amount', 15,3)->default(0);
            $table->string('repayment_frequency')->default('monthly'); ##can be monthly or annual
            $table->double('total_amount_with_rate', 15,3)->default(0);
            $table->string('currency')->default('USD');
            $table->string('collateral_data')->default('N/A');
            $table->integer('request_id')->unsigned()->index();
            $table->foreign('request_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('approval_id')->unsigned()->index();
            $table->foreign('approval_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('extra')->nullable();
            $table->integer('loan_type_id')->unsigned()->index();
            $table->foreign('loan_type_id')->references('id')->on('loan_types')->onDelete('cascade');
            $table->integer('interest_rate')->default(1);
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
