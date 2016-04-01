<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('facility_id')->unsigned();
            $table->string('title',255);
            $table->string('subtitle',255);
            $table->string('alias');
            $table->text('description')->nullable();
            $table->text('header')->nullable();
            $table->text('footer')->nullable();
            $table->text('freetext1')->nullable();
            $table->text('freetext2')->nullable();
            $table->string('type')->nullable();
            $table->string('type_date')->nullable();
            $table->decimal('price',8,2);
            $table->decimal('pseudo_price',8,2);
            $table->decimal('discount',8,2);
            $table->enum('status',['offline','online','hidden','deleted'])->default('offline');
            $table->dateTime('published_at')->nullable();
            $table->dateTime('unpublished_at')->nullable();
            $table->timestamps();

            $table->foreign('facility_id')->references('id')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('offers');
    }
}
