<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->foreignId('country_id')->constrained('countries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('state_id')->nullable()->default(null)->constrained('states')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->string('latitude', 100)->nullable()->default(null);
            $table->string('longitude', 100)->nullable()->default(null);
            $table->string('postal_code', 100)->nullable()->default(null);
            $table->string('phone', 100)->nullable()->default(null);
            $table->string('mobile', 100)->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('website')->nullable()->default(null);
            $table->string('facebook')->nullable()->default(null);
            $table->string('google')->nullable()->default(null);
            $table->string('twitter')->nullable()->default(null);
            $table->string('youtube')->nullable()->default(null);
            $table->string('linkedin')->nullable()->default(null);
            $table->string('instagram')->nullable()->default(null);
            $table->string('whatsapp')->nullable()->default(null);
            $table->string('pinterest')->nullable()->default(null);
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
        Schema::dropIfExists('addresses');
    }
}
