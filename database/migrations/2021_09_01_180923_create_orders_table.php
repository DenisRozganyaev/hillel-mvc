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
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('status_id')->constrained('order_statuses');
                $table->foreignId('user_id')->constrained('users');

                $table->string('name', 35);
                $table->string('surname', 50);
                $table->string('phone', 15);
                $table->string('email');
                $table->string('country', 50);
                $table->string('city', 50);
                $table->string('address', 50);
                $table->float('total')->comment('order total price');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('orders')) {
            Schema::dropIfExists('orders');
        }
    }
}
