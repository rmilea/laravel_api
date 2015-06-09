<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
        $this->call('TripTableSeeder');
        $this->call('AirportTableSeeder');
        $this->call('FlightTableSeeder');
	}
        
}

class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->delete();
 
        User::create(array(
            'username' => 'firstuser',
            'password' => Hash::make('first_password')
        ));
 
        User::create(array(
            'username' => 'seconduser',
            'password' => Hash::make('second_password')
        ));
    }
}

class TripTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('trips')->delete();
 
        Trip::create(array(
            'user_id' => '1',
            'name' => 'First Trip'
        ));
 
         Trip::create(array(
            'user_id' => '2',
            'name' => 'Second Trip'
        ));
    }
}

class AirportTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('airports')->delete();
 
        Airport::create(array(
            'name' => 'Toronto',
            'code' => 'YTZ'
        ));
 
        Airport::create(array(
            'name' => 'Toronto',
            'code' => 'YYZ'
        ));

        Airport::create(array(
            'name' => 'Montreal',
            'code' => 'YUL'
        ));

        Airport::create(array(
            'name' => 'New York',
            'code' => 'JFK'
        ));

        Airport::create(array(
            'name' => 'New York',
            'code' => 'LGA'
        ));
    }
}

class FlightTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('flights')->delete();
 
        Flight::create(array(
            'trip_id' => '1',
            'airport_id' => '1'
        ));
 
        Flight::create(array(
            'trip_id' => '1',
            'airport_id' => '2'
        ));

        Flight::create(array(
            'trip_id' => '2',
            'airport_id' => '1'
        ));

        Flight::create(array(
            'trip_id' => '2',
            'airport_id' => '4'
        ));

        Flight::create(array(
            'trip_id' => '2',
            'airport_id' => '3'
        ));
    }
}