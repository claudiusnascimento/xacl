<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclPermissionsTable extends Migration {

	public function up()
	{
		Schema::create('xacl_permissions', function(Blueprint $table) {
			$table->increments('id');
            $table->string('controller_action');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('xacl_permissions');
	}
}
