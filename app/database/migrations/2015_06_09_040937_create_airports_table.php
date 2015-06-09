<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airports', function(Blueprint $table)
		{
			$table->increments('id');
		        $table->string('name');
		        $table->string('code')->unique();
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
		Schema::table('airports', function(Blueprint $table)
		{
			//
		});
	}

}
