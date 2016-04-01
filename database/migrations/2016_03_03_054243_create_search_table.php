<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->enum('relation',['facility','offer'])->nullable();
            $table->text('searchtext')->nullable();

        });
        DB::statement('ALTER TABLE `search` ADD FULLTEXT search(searchtext)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('search', function(Blueprint $table) {
            $table->dropIndex('search');
        });
        Schema::drop('search');
    }
}
