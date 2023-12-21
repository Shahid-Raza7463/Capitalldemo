<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaverequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaverequest', function (Blueprint $table) {
            $table->id();
            $table->integer('applyleaveid');
            $table->integer('createdby')->nullable();
            $table->integer('approver')->nullable();
            $table->string('reason')->nullable();
            $table->string('date')->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
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
        Schema::dropIfExists('leaverequest');
    }
}
