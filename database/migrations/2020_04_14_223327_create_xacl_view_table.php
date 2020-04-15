<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclViewTable extends Migration {

	public function up()
	{
		Schema::create('xacl_view', function(Blueprint $table) {
			$table->increments('id');
            $table->string('action');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('xacl_view');
	}
}
