<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpnAclListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vpn_acl_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vpn_user_group_id');
            $table->unsignedBigInteger('vpn_user_id');
            $table->bigInteger('no_ticket')->nullable();
            $table->string('request_type');
            $table->string('note');
            $table->string('address');
            $table->boolean('completed');
            $table->boolean('rejected');
            $table->boolean('active');
            $table->foreign('vpn_user_group_id')->references('id')->on('vpn_user_groups');
            $table->foreign('vpn_user_id')->references('id')->on('vpn_users');
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
        Schema::dropIfExists('vpn_acl_lists');
    }
}
