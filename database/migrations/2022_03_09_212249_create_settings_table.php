<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable()->default(null);
            $table->string('site_title')->nullable()->default(null);
            $table->string('site_email')->nullable()->default(null);
            $table->string('site_phone')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->foreignId('country')->nullable()->default(null);
            $table->string('state', 50)->nullable()->default(null);
            $table->string('city', 50)->nullable()->default(null);
            $table->string('zip_code', 10)->nullable()->default(null);
            $table->string('footer_text')->nullable()->default(null);
            $table->boolean('sidebar_collapse')->default(false);
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
        Schema::dropIfExists('settings');
    }
}
