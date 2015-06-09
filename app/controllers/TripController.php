<?php

class TripController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$trips = Trip::where('user_id', Auth::user()->id)->get();
 
	    return Response::json(array(
	        'error' => false,
	        'trips' => $trips->toArray()),
	        200
	    );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$trip = new Trip;
		$error = true;
		$code = 400;

		if (Request::get('name') ) {
			$name = trim(filter_var(Request::get('name'), FILTER_SANITIZE_STRING));

			$trip->name    = $name;
		    $trip->user_id = Auth::user()->id;
		 
		    $trip->save();
		    $error = false;
		    $code  = 200;
		}
	    
	    return Response::json(array(
	        'error' => $error,
	        'trip' => $error === false ? $trip->toArray() : "Bad Request"),
	        $code
	    );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$error = true;
		$code  = 400;

		if (filter_var(intval($id), FILTER_VALIDATE_INT) !== FALSE) {
			$id = intval($id);

			// Make sure current user owns the requested resource
		    $trip = Trip::where('user_id', Auth::user()->id)
		            ->where('id', $id)
		            ->take(1)
		            ->get();
		    $error = false;
		    $code  = 200;
		}

	    return Response::json(array(
	        'error' => $error,
        	'trip' => $error === false ? $trip->toArray() : "Bad Request"),
        	$code
	    );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$code = 400;
		$error = true;

		//validation and cleanup
		$id = filter_var(intval($id), FILTER_VALIDATE_INT);
		if ($id !== FALSE) {
			$trip = Trip::where('user_id', Auth::user()->id)->find($id);	
		}

	    if ( Request::get('name') ) {
	    	$name = trim(filter_var(Request::get('name'), FILTER_SANITIZE_STRING));
	    	$trip->name = $name;
	    	$trip->save();

	    	$code = 200;
	    	$error = false;
	    }
	  
	    return Response::json(array(
	        'error' => $error,
	        'message' => $error === false ? $trip->toArray() : "Bad Request"),
	        $code
	    );
	}

	private function returnResponse($error, $message, $code) {
		return Response::json(array(
	        'error' => $error,
	        'message' => $message),
	        $code
	    );
	}
}
