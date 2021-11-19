<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('re_url');
            $table->string('has_params');
            $table->enum('mapping_type',["SEO INTERNAL",'CUSTOM']);
            $table->string('mapping_class');
            $table->enum('type',["FIX",'DYNAMIC']);
            $table->string('meta_title');
            $table->string('author');
            $table->string('canonical_url');
            $table->text('meta_keyword');
            $table->text('meta_description');
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
        Schema::dropIfExists('seo_managers');
    }
}
