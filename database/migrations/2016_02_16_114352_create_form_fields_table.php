<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('form_group_id')->unsigned();
            $table->enum('relation',['facility','offer'])->nullable();
            $table->string('title',200)->nullable();
            $table->text('description')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('type')->nullable();
            $table->text('options')->nullable();
            $table->string('validation')->nullable();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('form_group_id')->references('id')->on('form_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('form_fields');
    }
}
