<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->enum('type', ['fixed', 'percent']);
            $table->integer('value');
            $table->integer('limit')->nullable();
            $table->integer('used')->default(0);
            $table->timestamp('start_date')->nullable()->default(now());
            $table->timestamp('end_date')->nullable()->default(null);


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
        Schema::dropIfExists('vouchers');
    }
}
