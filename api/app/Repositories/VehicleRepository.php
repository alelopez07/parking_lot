<?php

namespace App\Repositories;
use App\Interfaces\VehicleInterface;
use App\Models\BaseResponse;
use App\Models\Entrance;
use App\Models\EntrancePaymentDetail;
use App\Models\EntranceResponse;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Carbon\Carbon;

class VehicleRepository implements VehicleInterface
{
    public function newEntrance($userId, array $data): BaseResponse {
        $result = new EntranceResponse();
        try {
            $startedAt = Carbon::now();
            $entrance = Entrance::create([
                "license_plate" => $data["license_plate"],
                "started_at" => $startedAt, 
                "finalized_at" => "0000-00-00 00:00:00", 
                "state" => "ACTIVE", 
                "vehicle_type_id" => $data["vehicle_type_id"], 
                "user_id" => $userId,
            ]);
            $result->setEntranceId($entrance->id);
            $result->setComments("this token {entrance_id} will help to finalize this entrance. works as ID");
            $result->setResponse(true);
            $result->setMessage("new entrance registered successfuly.");
        } catch (\Throwable $th) {
            $result->setResponse(false);
            $result->setMessage("an error has ocurred: " . $th->getMessage());
        }
        return $result;
    }

    public function getEntrancesById($id) {
        
    }

    public function newVehicleType(array $data): BaseResponse {
        $result = new BaseResponse();
        try {
            $type = VehicleType::create([
                "name" => $data["name"],
                "amount" => doubleval($data["amount"]),
            ]);
            $result->setResponse(true);
            $result->setMessage("new vehicle type: " . $type->name . " created successfuly.");
        } catch (\Throwable $th) {
            $result->setResponse(false);
            $result->setMessage("an error has ocurred: " . $th->getMessage());
        }
        return $result;
    }

    public function newResident(array $data) {

    }

    public function completeEntrance($id) {}
}
