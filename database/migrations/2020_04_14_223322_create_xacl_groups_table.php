2<?php

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
            $table->string('image')->nullable();
            $table->text('options')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('order')->default(0);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('xacl_groups');
	}
}
