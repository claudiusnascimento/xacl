<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXaclGroupsTable extends Migration {

	public function up()
	{
		Schema::create('xacl_groups', function(Blueprint $table) {
			$table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image');
            $table->text('options');
            $table->boolean('active')->default(false);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('xacl_groups');
	}
}
