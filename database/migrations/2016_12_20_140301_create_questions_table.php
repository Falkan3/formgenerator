<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('survey_id')->unsigned()->default(1);
            $table->integer('step')->unsigned();
            $table->integer('number')->unsigned();
            $table->string('custom_id')->default('');
            $table->string('name');
            $table->string('type');
            $table->string('text');
            $table->text('values');
            $table->integer('min_ticks')->unsigned()->default(1);
            $table->integer('max_ticks')->unsigned()->default(3);
            $table->string('rule')->default('');

            $table->timestamps();

            $table->unique(array('survey_id', 'number'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
