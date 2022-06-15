<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_order');
            $table->integer('id_customer');
            $table->integer('id_user');
            $table->integer('id_harga');
            $table->decimal('jumlah');
            $table->string('satuan');
            $table->integer('harga');
            $table->integer('disc')->nullable();
            $table->bigInteger('harga_akhir');
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
        Schema::dropIfExists('detail_order');
    }
}