<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent')->default(0);
            $table->integer('level')->default(0);
            $table->string('display_code', 20);
            $table->string('cat_name', 100);
            $table->string('banner', 100)->nullable();
            $table->string('icon', 100)->nullable();
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('top')->default(0);
            $table->tinyInteger('is_top_nav')->default(0);
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_img', 100)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('categories');
    }
}
