<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbUsersContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pb_users_contacts', function (Blueprint $table) {
            $table->id('contact_id');
            $table->unsignedBigInteger('pb_user_id');
            $table->bigInteger('mobile_number')->nullable(false);
            $table->string('type', 10)->nullable(false);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('pb_user_id')->references('pb_user_id')->on('phonebook_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pb_users_contacts');
    }
}
