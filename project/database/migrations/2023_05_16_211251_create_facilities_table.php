<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();;
            $table->text('description')->nullable(true);
            $table->integer('status');
            $table->uuid('creator_id')->nullable(true)->index();
            $table->uuid('modifier_id')->nullable(true)->index();
            $table->integer('sort')->nullable();
            $table->string('additional', 100)->nullable(true);
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
        Schema::dropIfExists('facilities');
    }
}
