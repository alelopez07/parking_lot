<?php

namespace App\Interfaces;
use App\Models\BaseResponse;

interface VehicleInterface
{
    public function newEntrance($userId, array $data): BaseResponse;
    public function getEntrancesById($id);
    public function newVehicleType(array $data);
    public function newResident(array $data);
    public function completeEntrance($id): BaseResponse;
}
