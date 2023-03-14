<?php

namespace App\Interfaces;
use App\Models\BaseResponse;
use App\Models\EntranceResponse;

interface VehicleInterface
{
    public function newEntrance($userId, array $data): EntranceResponse;
    public function newVehicleType(array $data);
    public function completeEntrance($id): EntranceResponse;
    public function addNewVehicle($id, $request): BaseResponse;
    public function initMonth(): BaseResponse;
    public function generateReports(): BaseResponse;
}
