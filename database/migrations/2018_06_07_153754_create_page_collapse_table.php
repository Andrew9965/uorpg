<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageCollapseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_collapse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img')->nullable();
            $table->text('title');
            $table->longText('description');
            $table->longText('cntent');
            $table->integer('active')->default('1');
            $table->integer('page_id');
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
        Schema::dropIfExists('page_collapse');
    }
}
