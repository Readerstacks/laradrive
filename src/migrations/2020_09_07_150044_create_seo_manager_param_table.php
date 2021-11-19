<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoManagerParamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_manager_params', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('seo_manager_id');
            $table->string('param');
            $table->string('param_model');
            $table->string('param_model_value');
            $table->string('param_value');
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
        Schema::dropIfExists('seo_manager_params');
    }
}
