<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('mobile', 20);
            $table->string('alternate_no', 20)->nullable()->default(null);
            $table->string('address');
            $table->string('gender', 6);
            $table->foreignId('country_id')->constrained('countries');
            $table->string('state', 50)->nullable()->default(null);
            $table->string('city', 50);
            $table->string('postal_code', 10)->nullable()->default(null);
            $table->string('reference_name', 100)->nullable()->default(null);
            $table->string('reference_mobile', 20)->nullable()->default(null);
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
        Schema::dropIfExists('clients');
    }
}
