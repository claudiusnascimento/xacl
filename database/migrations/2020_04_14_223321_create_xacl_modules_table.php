<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclModulesTable extends Migration {

	public function up()
	{
		Schema::create('xacl_modules', function(Blueprint $table) {
			$table->increments('id');
            $table->string('controller_action');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('xacl_modules');
	}
}
