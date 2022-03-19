<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('cnpj')->nullable();
            $table->integer('address_id')->nullable()->unsigned();
            $table->dateTime('created_at')->nullable()->default(Date('Y/m/d'));
            $table->dateTime('updated_at')->nullable()->default(Date('Y/m/d'));
        });
        Schema::table('company', function (Blueprint $table) {
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
           
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company');
    }
};
