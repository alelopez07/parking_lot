<?php

namespace App\Interfaces;
use App\Models\EntranceResponse;

interface VehicleInterface
{
    public function newEntrance($userId, array $data): EntranceResponse;
    public function getEntrancesById($id);
    public function newVehicleType(array $data);
    public function newResident($licensePlate, $diff);
    public function completeEntrance($id): EntranceResponse;
}
