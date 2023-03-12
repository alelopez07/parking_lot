<?php

namespace App\Repositories;
use App\Http\Requests\StoreEntranceRequest;
use App\Interfaces\VehicleInterface;
use App\Models\Entrance;
use App\Models\EntrancePaymentDetail;
use App\Models\Vehicle;

class VehicleEntrancesRepository implements VehicleInterface
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

    public function getEntrances() {
        return $this->entranceModel->all();
    }
}
