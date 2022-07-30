<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->double('original_price',8,2)->default(0)->unsigned();
            $table->double('discounted_price',8,2)->default(0)->unsigned();
            $table->tinyInteger('validity')->comment("VALIDITY IN DAYS & NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('listings')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('categories')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('photos')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('videos')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('tags')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('amenities')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('products')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('services')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('articles')->default(0)->comment("NEGATIVE VALUES FOR INFINITY");
            $table->tinyInteger('featured_listings')->default(0)->comment("1 FOR ALLOWED & 0 FOR NOT-ALLOWED");
            $table->tinyInteger('contact_form')->default(0)->comment("1 FOR ALLOWED & 0 FOR NOT-ALLOWED");
            $table->tinyInteger('social_items')->default(0)->comment("1 FOR ALLOWED & 0 FOR NOT-ALLOWED");
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
        Schema::dropIfExists('prices');
    }
}
