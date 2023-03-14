# pl-api

This is a RESTful API built with Laravel that allows users to manage a parking lot. It provides endpoints for creating new entrances, completing exits, and checking parking status.

## Requirements
You will need the following technologies to continue developing in this repository.

* Docker
* Docker Compose

## Installation

1. Clone the repository:
```bash
git clone git@github.com:alelopez07/parking_lot.git // with ssh
cd parking-lot-api
```

2. Create a .env file:
```bash
cp .env.example .env
```

3. Run the genesis.sh script if you want to go back to genesis in your container system and then, run initialize.sh to initialize the docker containers:
```bash
bash ./genesis.sh
bash ./initialize.sh
```

5. Install the dependencies:
```bash
docker-compose exec app composer install
```

6. Initialize migrations, run migrations and seeders:
```bash
docker exec -it app php artisan migrate:install
docker exec -it app php artisan migrate
docker exec -it app php artisan migrate --seed
```

## Usage

To start the local development server, in your web browser, visit http://localhost/ to verify that the app is running.

You can see a better detail of the API routes described below exposed in the postman document. [click here to get the postman document.]("https://github.com/alelopez07/parking_lot/tree/develop/api/docs/parkingLotApi.postman_collection")

### Endpoints

```bash
  GET|HEAD   / .......................................

  POST       api/v1/entrance/complete ................ v1\ParkingLotController@completeEntrance
  POST       api/v1/entrance/new ..................... v1\ParkingLotController@createNewEntrance
  POST       api/v1/generateReport ................... v1\ParkingLotController@generateResidentsPaymentReport
  GET|HEAD   api/v1/initMonth ........................ v1\ParkingLotController@initMonth
  POST       api/v1/login ............................ v1\AuthController@authentication
  GET|HEAD   api/v1/logout ........................... v1\AuthController@logout
  POST       api/v1/register ......................... v1\UserController@createUser
  POST       api/v1/vehicle_type/{id} ................ v1\VehicleController@createVehicleType
  POST       api/v1/vehicle_type/{id} ................ v1\VehicleController@newVehicle
  GET|HEAD   api/v1/vehicle_types .................... JsonResponse(VehicleType::all(), Response::HTTP_OK)

```

## Architecture

This API is structured under the following layers:

* Models
* Controllers
* Repositories
* Interfaces
* Providers

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

MIT © [JorgeLopez](https://github.com/alelopez07)