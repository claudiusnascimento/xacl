<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclGroupUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $userForeign = config('xacl.user_model.foreign_key', 'id');
        $userTableName = config('xacl.user_model.table_name', 'users');
        $userTypeField = config('xacl.user_model.user_type_field', 'bigInteger');

        Schema::create('xacl_group_user', function (Blueprint $table) use($userForeign, $userTableName, $userTypeField) {
            $table->integer('group_id')->unsigned()->index();
            $table->foreign('group_id')->references('id')->on('xacl_groups');
            $table->{$userTypeField}('user_id')->unsigned()->index();
            $table->foreign('user_id')
                  ->references($userForeign)
                  ->on($userTableName);;
            $table->primary(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('xacl_group_user');
    }
}
