<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('layout')->default(1);
            $table->string('location');
            $table->boolean('online')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('pages')->insert(
            array(
                'name' => 'index',
                'description' => 'index page',
                'layout' => 1,
                'location' => 'pages.main',
                'online' => 1
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
