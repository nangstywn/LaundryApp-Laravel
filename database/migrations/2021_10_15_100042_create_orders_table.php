<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice');
            $table->string('karyawan');
            $table->string('tgl_ambil')->nullable();
            $table->integer('ongkir')->nullable();
            $table->integer('spotting')->nullable();
            $table->string('status_order');
            $table->string('tgl_transaksi');
            $table->string('notif')->default(0);
            $table->string('notif_admin')->default(0);
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
        Schema::dropIfExists('order');
    }
}