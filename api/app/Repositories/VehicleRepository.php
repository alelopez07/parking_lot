<?php

namespace App\Repositories;
use App\Http\Requests\StoreEntranceRequest;
use App\Interfaces\VehicleInterface;
use App\Models\Entrance;
use App\Models\EntrancePaymentDetail;
use App\Models\Vehicle;
use App\Models\VehicleType;

class VehicleRepository implements VehicleInterface
{
    protected $vehicleModel;
    protected $entranceModel;
    protected $paymentModel;

    public function __construct(
        Entrance $entrance, 
        Vehicle $vehicle, 
        EntrancePaymentDetail $payment
    ) {
        $this->entranceModel = $entrance;
        $this->vehicleModel = $vehicle;
        $this->paymentModel = $payment;
    }

    public function newEntrance(StoreEntranceRequest $request) {
        $this->entranceModel->create($request);
    }

    public function getEntrancesById($id) {
        return $this->entranceModel->all();
    }

    public function newVehicleType(array $data): \stdClass {
        $result = new \stdClass();
        try {
            $type = VehicleType::create([
                "name" => $data["name"],
                "amount" => doubleval($data["amount"]),
            ]);
            $result->response = true;
            $result->message = "new vehicle type: " . $type->name . " created successfuly.";
        } catch (\Throwable $th) {
            $result->response = false;
            $result->message = "an error has ocurred";
        }
        return $result;
    }

    public function newResident(array $data) {

    }
}
