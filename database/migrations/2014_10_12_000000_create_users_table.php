<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable()->default(null);
            $table->string('mobile', 20)->unique();
            $table->string('alternate_no', 20)->nullable()->default(null);
            $table->string('address');
            $table->string('gender', 6);
            $table->foreignId('country_id')->constrained('countries');
            $table->string('state', 50)->nullable()->default(null);
            $table->string('city', 50);
            $table->string('zip_code', 10)->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('user');
            $table->string('avatar')->nullable();
            $table->tinyInteger('activation_status')->default(1)->comment("1 FOR ACTIVATE & 0 FOR DEACTIVATE");
            $table->foreignId('created_by')->nullable()->default(null)->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->default(null)->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
