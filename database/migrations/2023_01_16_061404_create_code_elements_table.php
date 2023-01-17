<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodeElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('code_elements', function (Blueprint $table) {
            $table->id();
            $table->string('element_key');
            $table->string('element_name');
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
        Schema::dropIfExists('code_elements');
    }
}
