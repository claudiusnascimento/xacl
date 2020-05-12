<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclActionsTable extends Migration {

	public function up()
	{
		Schema::create('xacl_actions', function(Blueprint $table) {
			$table->increments('id');
            $table->string('action');
            $table->text('description');
            $table->boolean('active')->default(false);
            $table->text('options');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('xacl_actions');
	}
}
