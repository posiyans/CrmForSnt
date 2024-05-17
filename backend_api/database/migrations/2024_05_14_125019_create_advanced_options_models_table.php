<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvancedOptionsModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advanced_options_models', function (Blueprint $table) {
            $table->id();
            $table->string('commentable_type')->nullable()->comment('к какому классу относится опция');;
            $table->string('type')->nullable()->comment('классификация внутри класса'); // для разделяние опций внутри класса, если их больше 1
            $table->string('name')->comment('названия свойства');
            $table->string('type_value')->comment('тип данных');
            $table->json('options')->comment('дополнительные данные');
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
        Schema::dropIfExists('advanced_options_models');
    }
}
