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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();

            $table->float('auction_price');
            $table->text('note');

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('snap_token')->nullable();
            $table->enum('payment_status', ['1', '2', '3', '4'])->comment('1 = menunggu pembayaran, 2 = sudah dibayar, 3 = kadaluarsa, 4 = gagal / batal')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('jumlah_pembayaran')->nullable();
            $table->string('payment_status_message')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('approval_code_payment')->nullable();

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
        Schema::dropIfExists('auctions');
    }
};
