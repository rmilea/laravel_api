# laravel_api
Project executed with an instance of Laravel 4.2

first laravel project containing API calls examples

steps to execute to execute the API calls on a local server

Inside a connected database execute the following command : create database apis;
CommandLine(CL) : cd /web_server_root_path
CL : chmod 775 -R /web_server_root/laravel_api
CL : cd laravel_api
CL : php artisan migrate
CL : php artisan db:seed

To execute the requested API calls:
-----------------------------------------

The following URLs assume http://localhost is the address of the local web server

Get the list of all airports
http://localhost/laravel_api/public/index.php/api/v1/getAllAirports

List all flights for a trip (trip ID = 1 in the example bellow)
http://localhost/laravel_api/public/index.php/api/v1/getAllFlights/1

Add a flight to a trip (this will add an existing airport to an existing trip - to create a new airport check addNewAirport webservice endpoint)    
http://localhost/laravel_api/public/index.php/api/v1/addToTrip/1/newFlight/5

Remove a flight from a trip
http://localhost/laravel_api/public/index.php/api/v1/removeFromTrip/1/airport/5

Rename a trip
curl -i -X PUT --user seconduser:second_password -d 'name=The best trip' localhost/laravel_api/public/index.php/api/v1/trip/2

Extra calls for better API support:
-------------------------------------

Add a new airport
curl --user seconduser:second_password -d 'name=Chicago&code=CHI' localhost/laravel_api/public/index.php/api/v1/addNewAirport

Add a new trip
curl --user seconduser:second_password -d 'name=Final trip' localhost/laravel_api/public/index.php/api/v1/trip

    
The work in this project has been done in the following directories/files:

app/filters.php - for CORS
app/routes.php - for routes

app/database/migrations
app/databse/seeds
 - creating tables definition and data
app/models - the created Model types
app/controlers - the created controllers logic
