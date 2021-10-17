<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index(); // default, [your queue name]
            $table->longText('payload'); // serialized object
            $table->unsignedTinyInteger('attempts'); // кол-во попыток
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at'); // when will be run
            $table->unsignedInteger('created_at'); // when was created
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
