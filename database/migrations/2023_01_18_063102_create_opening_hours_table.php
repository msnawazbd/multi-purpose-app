<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpeningHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->onUpdate('cascade')->onDelete('cascade');
            $table->time('sat_open')->nullable();
            $table->time('sat_close')->nullable();
            $table->time('sun_open')->nullable();
            $table->time('sun_close')->nullable();
            $table->time('mon_open')->nullable();
            $table->time('mon_close')->nullable();
            $table->time('tue_open')->nullable();
            $table->time('tue_close')->nullable();
            $table->time('wed_open')->nullable();
            $table->time('wed_close')->nullable();
            $table->time('thu_open')->nullable();
            $table->time('thu_close')->nullable();
            $table->time('fri_open')->nullable();
            $table->time('fri_close')->nullable();
            $table->tinyInteger('open_twenty_four_seven')->default(0)->comment("1 FOR YES & 0 FOR NO");
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment("1 FOR PUBLISHED & 0 FOR UNPUBLISHED");
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->default(null)->constrained('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('opening_hours');
    }
}
