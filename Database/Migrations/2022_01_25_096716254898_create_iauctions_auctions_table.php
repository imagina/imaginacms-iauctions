<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIauctionsAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iauctions__auctions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields...
            $table->integer('status')->default(0)->unsigned();
            $table->integer('type')->default(0)->unsigned();

            //Responsible User
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            //User Group
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('iprofile__departments')->onDelete('cascade');

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->text('options')->nullable();

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('iauctions__categories')->onDelete('restrict');


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
        Schema::dropIfExists('iauctions__auctions');
    }
}
