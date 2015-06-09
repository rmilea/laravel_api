<?php

class FlightController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return 'Hello, API';
	}

	/**
	 * Display the specified resource.	
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getAllFlights($id)
	{
		$error = true;
		$code  = 400;

		if (filter_var(intval($id), FILTER_VALIDATE_INT) !== FALSE) {
			$id = intval($id);
			$flights = DB::table('flights')
		            ->join('airports', 'flights.airport_id', '=', 'airports.id')
		            ->join('trips', 'flights.trip_id', '=', 'trips.id')
		            ->select('airports.name', 'airports.code')
		            ->where('trip_id', $id)
		            ->get();

			$error = false;
			$code  = 200;
		}

	    return Response::json(array(
	        'error'   	=> $error,
	    	'flights' => $error === false ? $flights : "Bad Request"),
	        $code
	    );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getAllAirports()
	{
		$airports = Airport::groupBy('code')
						  ->orderBy('code', 'ASC')
						  ->get();
		
	    return Response::json(array(
	        'error' => false,
	    	'airports' => $airports->toArray()),
	        200
	    );
	}

	public function addNewFlightToTrip($tripId, $airportId) {
		$newFlight = new Flight;
		$error = true;
		$code = 400;

		if (filter_var(intval($tripId), FILTER_VALIDATE_INT) !== FALSE &&
			filter_var(intval($airportId), FILTER_VALIDATE_INT) !== FALSE) {
			$tripId = intval($tripId);
			$airportId = intval($airportId);

			//check if trip ID exist in the DB
			$trip = Trip::where('id', $tripId)
					->take(1)
		            ->get();

		    // check if airport ID exists
		    $airport = Airport::where('id', $airportId)
					->take(1)
		            ->get();

		    // check if this flight DOES NOT exist
		    $flight = Flight::where('trip_id', $tripId)
		     				  ->where('airport_id', $airportId)
		     				  ->take(1)
		     				  ->get();

		 	if (count($trip->toArray()) > 0 && count($airport->toArray()) > 0 
		 		&& count($flight->toArray()) === 0) {

		 		$newFlight->trip_id = $tripId;
		 		$newFlight->airport_id = $airportId;
		 		$newFlight->save();

		        $error = false;
		    	$code  = 200;

		    	$newFlight = Flight::where('trip_id', $tripId)
		     				  ->where('airport_id', $airportId)
		     				  ->take(1)
		     				  ->get();		  
		 	}
		}
	    
	    return Response::json(array(
	        'error' => $error,
	        'newFlight' => $error === false ? $newFlight->toArray() : "Bad Request"),
	        $code
	    );
	}

	public function removeFlightFromTrip($tripId, $airportId) {
		$error = true;
		$code = 400;

		if (filter_var(intval($tripId), FILTER_VALIDATE_INT) !== FALSE &&
			filter_var(intval($airportId), FILTER_VALIDATE_INT) !== FALSE) {
			$tripId = intval($tripId);
			$airportId = intval($airportId);

		    // check if this flight DOES NOT exist
		    $flight = Flight::where('trip_id', $tripId)
		     				  ->where('airport_id', $airportId);
			$flightExist = $flight		     				  
		     				  ->take(1)
		     				  ->get();

		 	if (count($flightExist->toArray()) === 1) {
		 		$flight->delete();

		        $error = false;
		    	$code  = 200;
		 	}
		}
	    
	    return Response::json(array(
	        'error' => $error,
	        'flight' => $error === false ? 'Flight: ' . $airportId . ' removed from trip :' 
	        	. $tripId : "Bad Request"),
	        $code
	    );
	}

	public function addNewAirport() {
		$airport = new Airport;
		$error = true;
		$code = 400;

		if (Request::get('name') && Request::get('code')) {
			$name = trim(filter_var(Request::get('name'), FILTER_SANITIZE_STRING));
			$code = trim(filter_var(Request::get('code'), FILTER_SANITIZE_STRING));

			$airport->name = $name;
		    $airport->code = $code;
		 
		    $airport->save();
		    $error = false;
		    $code  = 200;
		}
	    
	    return Response::json(array(
	        'error' => $error,
	        'airport' => $error === false ? $airport->toArray() : "Bad Request"),
	        $code
	    );
	}
}
