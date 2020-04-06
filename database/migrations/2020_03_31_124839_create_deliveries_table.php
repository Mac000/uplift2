<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('receiver', 40);
            $table->string('phone_no', 11);
            $table->string('address', 100);
            $table->string('gps', 30);
            $table->string('goods', 255);
            $table->integer('cost');
            $table->string('tehsil', 40);
            $table->timestamps();

         //  Adding CNIC at the end to avoid issues in front end where view is generated on assumption of order of columns in table
            $table->string('image');
            $table->text('cnic');

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
