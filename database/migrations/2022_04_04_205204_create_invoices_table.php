<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->string('invoice_no');
            $table->date('invoice_date');
            $table->date('invoice_due_date');
            $table->double('sub_total',10,2);
            $table->double('tax_amount',10,2)->default(0);
            $table->double('total',10,2);
            $table->double('discount_amount',10,2);
            $table->double('net_total',10,2);
            $table->double('paid',10,2);
            $table->double('due',10,2);
            $table->text('description')->nullable()->default(null);
            $table->tinyInteger('status')->default(1)->comment("1 FOR PAID, 2 FOR PARTIAL PAID & 3 FOR DUE");
            $table->foreignId('tax_id')->nullable()->default(null)->constrained('taxes')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
