<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_acts', function (Blueprint $table) {
            $table->uuid('id');
            $table->date('act_date');
            $table->string('title');
            $table->string('type');
            $table->string('description');
            $table->string('file')->nullable();
            $table->boolean('published')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('legal_acts');
    }
};
