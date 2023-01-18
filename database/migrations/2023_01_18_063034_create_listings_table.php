<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('display_code', 20);
            $table->string('business_name');
            $table->string('banner', 100)->nullable();
            $table->string('logo', 100)->nullable();
            $table->string('qr_code', 100)->nullable();
            $table->date('establish')->nullable();
            $table->tinyInteger('cat_featured')->default(0);
            $table->tinyInteger('home_featured')->default(0);
            $table->tinyInteger('verified')->default(0);
            $table->tinyInteger('claimed')->default(0);
            $table->integer('total_view')->default(0);
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_img', 100)->nullable();
            $table->integer('sort_order')->default(0);
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
        Schema::dropIfExists('listings');
    }
}
