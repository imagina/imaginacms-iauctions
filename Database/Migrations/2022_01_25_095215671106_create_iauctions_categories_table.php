<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIauctionsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iauctions__categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->string('system_name', 50);
            $table->text('bid_service')->nullable();
            $table->text('options')->nullable();

            $table->integer('auction_form_id')->unsigned()->nullable();
            $table->foreign('auction_form_id')->references('id')->on('iforms__forms')->onDelete('restrict');

            $table->integer('bid_form_id')->unsigned()->nullable();
            $table->foreign('bid_form_id')->references('id')->on('iforms__forms')->onDelete('restrict');

            
            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iauctions__categories');
    }
}
