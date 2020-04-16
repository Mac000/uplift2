<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 40);
            $table->string('phone_no', 11)->unique();
            $table->string('address', 100);
            $table->string('gps', 30);
            $table->string('tehsil', 40);

            $table->boolean('help');
            $table->boolean('checked');
            $table->boolean('invalid');
            $table->json('needs')->nullable();
            $table->timestamps();
//            $table->string('cnic', 500)->unique();
            $table->string('cnic', 13)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receivers');
    }
}
