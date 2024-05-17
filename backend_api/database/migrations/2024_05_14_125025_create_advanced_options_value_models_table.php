<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvancedOptionsValueModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advanced_options_value_models', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('advanced_options_id')->comment('id попции');
            $table->bigInteger('commentable_id')->nullable();
            $table->json('value')->nullable()->comment('значение');
            $table->softDeletes();
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
        Schema::dropIfExists('advanced_options_value_models');
    }
}
