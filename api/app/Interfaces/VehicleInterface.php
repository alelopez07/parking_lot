<?php

namespace App\Interfaces;
use App\Http\Requests\StoreEntranceRequest;

interface VehicleInterface
{
    public function newEntrance(StoreEntranceRequest $request);
    public function getEntrancesById($id);
    public function newVehicleType(array $data);
    public function newResident(array $data);
}
