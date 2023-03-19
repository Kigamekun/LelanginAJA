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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->float('start_from');
            $table->date('end_auction');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('category_id')->nullable();

            $table->text('thumb');
            $table->text('condition');
            $table->text('saleroom_notice');
            $table->text('catalogue_note');


            $table->enum('status', ['0', '1'])->comment('0 : Closed, 1 : Opened')->default(1);
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
