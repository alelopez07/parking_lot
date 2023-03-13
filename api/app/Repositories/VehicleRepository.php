<?php

namespace App\Repositories;
use App\Interfaces\VehicleInterface;
use App\Models\BaseResponse;
use App\Models\Entrance;
use App\Models\EntrancePaymentDetail;
use App\Models\EntranceResponse;
use App\Models\ResponseActionCode;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Carbon\Carbon;

class VehicleRepository implements VehicleInterface
{
    public function newEntrance($userId, array $data): BaseResponse {
        $result = new EntranceResponse();
        try {
            $exist = Entrance::where('license_plate',$data["license_plate"])->where('state',"ACTIVE")->first();
            if ($exist == null) {
                $startedAt = Carbon::now();
                $entrance = Entrance::create([
                    "license_plate" => $data["license_plate"],
                    "started_at" => $startedAt, 
                    "finalized_at" => "0000-00-00 00:00:00", 
                    "state" => "ACTIVE", 
                    "vehicle_type_id" => $data["vehicle_type_id"], 
                    "user_id" => $userId,
                ]);
                $result->setMessage("new entrance registered successfuly.");
                $result->setEntranceId($entrance->id);
                $result->setComments("this token {entrance_id} will help to finalize this entrance. works as ID");
            } else {
                $result->setEntranceId($exist->id);
                $result->setComments("the licence plate: ". $exist->license_plate ." has an active session.");
            }
            $result->setResponse(true);
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

    public function newResident($licensePlate, $diff) { }

    public function completeEntrance($id): BaseResponse {
        $response = new EntranceResponse();
        $entrance = Entrance::find($id);
        if ($entrance != null) {
            $response->setResponse(true);
            $response->setEntranceId($entrance->id);
            if ($entrance->state == "COMPLETED") {
                $response->setMessage("the entrance was completed on: " . $entrance->finalized_at);
                $response->setComments("this session token has already been closed");
            } else {
                $finalizedAt = Carbon::now();
                $entrance->update(['finalized_at' => $finalizedAt, 'state' => "COMPLETED"]);
                $response->setMessage("the entrance was completed successfuly.");
                $response->setComments("this session token was completed and closed at: " . $finalizedAt);
                $diff = $this->getEntranceDiffTime($entrance->started_at, $finalizedAt);
                $resident = $this->handleResidents($entrance->license_plate, $diff);
            }
        } else {
            $response->setResponse(false);
            $response->setMessage("an error has ocurred");
        }
        

        return $response;
    }

    private function handleResidents($licensePlate, $diff): ResponseActionCode {
        $residentId = VehicleType::where('name',VehicleType::CONST_RESIDENT_KEY)->first()->id;
        $vehicleExist = Vehicle::where('license_plate',$licensePlate)->first();

        if ($vehicleExist == null) {
            $vehicle = new Vehicle();
            $vehicle->license_plate = $licensePlate;
            $vehicle->vehicle_type_id = $residentId;
            $vehicle->time = $diff;
            $vehicle->save();
            return ResponseActionCode::CREATED;
        } else {
            $currentTime = new \DateTime::createFromFormat('H:i:s', $vehicleExist->time);
            $newDiff = new \DateTime::createFromFormat('H:i:s', $diff);
            $newTime = $currentTime->add($newDiff);

            
            dd($newTime->format('H:i:s'));
            // $vehicleExist->time = $newTime->format('H:i:s');
            
            return ResponseActionCode::UPDATED;
        }
    }

    private function getEntranceDiffTime($start, $end): string {
        $startDateTime = new \DateTime($start);
        $endDateTime = new \DateTime($end);
        $diff = $startDateTime->diff($endDateTime);
        $diffParse = $diff->h . ':' . $diff->i . ':' . $diff->s;
        return $diffParse;
    }

}
