<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclActionsTable extends Migration {

	public function up()
	{
		Schema::create('xacl_actions', function(Blueprint $table) {
			$table->increments('id');
            $table->string('action');
            $table->text('description')->nullable();
            $table->integer('order')->nullable()->default(0);
            $table->boolean('active')->nullable()->default(false);
            $table->text('options')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('xacl_actions');
	}
}
