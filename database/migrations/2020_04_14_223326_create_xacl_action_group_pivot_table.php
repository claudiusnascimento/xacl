<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclActionGroupPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xacl_action_group', function (Blueprint $table) {
            $table->integer('action_id')->unsigned()->index();
            $table->foreign('action_id')->references('id')->on('xacl_actions');
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('xacl_groups');

            $table->primary(['action_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xacl_action_group');
    }
}
